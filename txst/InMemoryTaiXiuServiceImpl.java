package com.archie.service.impl;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.CopyOnWriteArrayList;
import java.util.concurrent.atomic.AtomicLong;

import javax.transaction.Transactional;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;

import com.archie.config.Constants;
import com.archie.dao.TaixiuRecordRepository;
import com.archie.entity.TaixiuRecord;
import com.archie.entity.TxRank;
import com.archie.schedule.AsyncComponent;
import com.archie.service.BotService;
import com.archie.service.InMemoryTaiXiuService;
import com.archie.service.RankService;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.util.CommonUtil;


/**
 * @author Archie
 * @date Sep 18, 2020
 */
@Service
public class InMemoryTaiXiuServiceImpl implements InMemoryTaiXiuService {

	private static final Logger log = LoggerFactory.getLogger(InMemoryTaiXiuServiceImpl.class);

	private List<TaiXiuBetDTO> listData = new CopyOnWriteArrayList<TaiXiuBetDTO>();
	
	private Map<String, String> userAmount = new ConcurrentHashMap<String, String>();
	
	private AtomicLong taiCount = new AtomicLong(0);

	private AtomicLong xiuCount = new AtomicLong(0);

	private AtomicLong taiAmount = new AtomicLong(0);

	private AtomicLong xiuAmount = new AtomicLong(0);
	
	private AtomicLong taiAmountReal = new AtomicLong(0);

	private AtomicLong xiuAmountReal = new AtomicLong(0);
	
	@Autowired
	private AsyncComponent asyncComponent;
	
	@Autowired
	private BotService botService;
	
	@Autowired
	private TaixiuRecordRepository taixiuRecordDao;
	
	@Autowired
	private RankService rankService;
	
	private static final int BATCH_SIZE_BOT = 150;
	
	
	private static final int BATCH_SIZE_REAL = 50;
	
	@Override
	public List<TaiXiuBetDTO> getList() {
		return new ArrayList<>(listData);
	}
	
	@Override
	public int isValidBet(String loginname, int typed) {
		/*
		 * FAIL : đã đặt cua khac 
		 * EXIST : đã đặt cửa này 
		 * OK: chưa cược bg
		 */
		for (TaiXiuBetDTO taiXiuBet : listData) {
			if (taiXiuBet.getLoginname().equals(loginname)) {
				if (taiXiuBet.getTyped().intValue() != typed) {
					return Constants.FAIL;
				} else {
					return Constants.EXIST;
				}
			}
		}
		return Constants.OK;
	}

	@Override
	public synchronized void addToList(TaiXiuBetDTO obj, int isExist) {/* synchronized */
		int type = obj.getTyped().intValue();
		long amountNew = obj.getBetamount();
		//log.info("before add cachedata size={}", listData.size());
		if (Constants.EXIST != isExist) {
			if (obj.getTyped().equals(Constants.TAI)) {
				userAmount.put(obj.getUsername(), obj.getBetamount() + Constants.POINT + Constants.TAI);
				taiCount.getAndIncrement();
			} else {
				userAmount.put(obj.getUsername(), obj.getBetamount() + Constants.POINT + Constants.XIU);
				xiuCount.getAndIncrement();
			}
		} else {
			userAmount.computeIfPresent(obj.getUsername(),
					(key, oldValue) -> (Long.parseLong(oldValue.split(Constants.POINT)[0]) + obj.getBetamount())
							+ Constants.POINT + oldValue.split(Constants.POINT)[1]);
		}
		log.info("requestbet2 ={}",obj.toString());
		// put to list
		listData.add(obj);
		//increase amount user real
		addAmountTotal(type, amountNew, true);
	}

	@Override
	public void reset() {
		if (listData != null && !listData.isEmpty()) {
			listData.clear();
		}
		taiCount.set(0);
		xiuCount.set(0);
		taiAmount.set(0);
		xiuAmount.set(0);
		
		taiAmountReal.set(0);
		xiuAmountReal.set(0);
		
		if (userAmount != null && !userAmount.isEmpty()) {
			userAmount.clear();
		}
	}

	@Override
	public long size() {
//		long size;
//		lock.readLock().lock();
//		size = listData.size();
//		lock.readLock().unlock();
		return listData.size();
	}

	@Override
	public long[] getQuantity1s() {
		long[] quantity = { taiCount.get(), xiuCount.get(), 
							taiAmount.get(), xiuAmount.get() , 
							taiAmountReal.get() , xiuAmountReal.get() };
		return quantity;
	}

	@Override
	public void addAmountTai(long amount) {
		taiAmount.getAndAdd(amount);
	}

	@Override
	public void addAmountXiu(long amount) {
		xiuAmount.getAndAdd(amount);
	}
	
	
	@Override
	@Async("taskExecutor")
	public void winloseData(int resultType , int[] result) {
		Map<String, Long> mapNotifyData = new HashMap<String, Long>();
		List<Long> lstBotIdWin = new ArrayList<Long>();
		List<Long> lstBotIdLose = new ArrayList<Long>();
		
		List<TaiXiuBetDTO> lstURealWin = new ArrayList<TaiXiuBetDTO>();
		List<TaiXiuBetDTO> lstURealLose = new ArrayList<TaiXiuBetDTO>();
		//List<CompletableFuture<Void>> futures = new ArrayList<>();
		String resultStr = Arrays.toString(result);
		if (listData != null && !listData.isEmpty()) {
			int i=0;
			int j=0;
			int k=0;
			int h=0;
			for (TaiXiuBetDTO tx : listData) {
				tx.setResult(resultStr);
				
				if (tx.getUserType() == Constants.BOT) {
					if (resultType == tx.getTyped().intValue()) {
						lstBotIdWin.add(tx.getId());
						if (i % BATCH_SIZE_BOT == 0 && i > 0) {
							asyncComponent.updateListBotWin(resultStr, lstBotIdWin);
							lstBotIdWin.clear();
			            }
						i++;
					} else {
						lstBotIdLose.add(tx.getId());
						if (j % BATCH_SIZE_BOT == 0 && j > 0) {
							asyncComponent.updateListBotLose(resultStr, lstBotIdLose);
							lstBotIdLose.clear();
			            }
						j++;
					}
					
					
				} else {
					if (resultType == tx.getTyped().intValue()) {
						if (tx.getBetamount().longValue() != tx.getRefundamount()) {
							lstURealWin.add(tx);
							if (k % BATCH_SIZE_REAL == 0 && k > 0) {
//								futures.add();
								asyncComponent.updateListUserWin(lstURealWin);
								lstURealWin.clear();
				            }
							k++;
						}
						// add to notify 
						log.info("requestbet3 ={}",tx.toString());
						if(mapNotifyData.containsKey(tx.getUsername())) {
							mapNotifyData.computeIfPresent(tx.getUsername(), (key, v) -> v + tx.getBetamount() - tx.getRefundamount());
						}else {
							mapNotifyData.put(tx.getUsername(), tx.getBetamount() - tx.getRefundamount());
						}
						
					} else {
						// update record lose
						lstURealLose.add(tx);
						//lossAmount += tx.getBetamount() - tx.getRefundamount();
						if (h % BATCH_SIZE_REAL == 0 && h > 0) {
//							futures.add();
							asyncComponent.updateListUserLose(lstURealLose);
							lstURealLose.clear();
			            }
						h++;
						
					}
				}
				
			}
		}
		//save real
		if (lstURealWin.size() > 0) {
//			futures.add();
			asyncComponent.updateListUserWin(lstURealWin);
		}
		if (lstURealLose.size() > 0) {
//			futures.add(asyncComponent.updateListUserLose(lstURealLose));
			asyncComponent.updateListUserLose(lstURealLose);
		}
		//save bot
		if (lstBotIdWin.size() > 0) {
			asyncComponent.updateListBotWin(resultStr, lstBotIdWin);
		}
		if (lstBotIdLose.size() > 0) {
			asyncComponent.updateListBotLose(resultStr, lstBotIdLose);
		}
//		if(futures!=null && !futures.isEmpty()) {
////			for (CompletableFuture<Void> completableFuture : futures) {
////				CompletableFuture.allOf(completableFuture).join();
////			}
//			CompletableFuture.allOf(futures.toArray(new CompletableFuture[0])).join();
//		}
		if(!mapNotifyData.isEmpty()) {
			asyncComponent.sendQueueUserWin(mapNotifyData);
		}
		
	}
	
	
//	@Async
//	public CompletableFuture<Void> updateUserWins(List<TaiXiuBetDTO> lstData) {
//		int i =0;
//		List<TaiXiuBetDTO> lstHandle = new ArrayList<>();
//		for (TaiXiuBetDTO tx : lstData) {
//			lstHandle.add(tx);
//			if (i % BATCH_SIZE_REAL == 0 && i > 0) {
//				updateListUserWin(lstHandle);
//				lstHandle.clear();
//	        }
//			i++;
//		}
//		if(lstHandle.size() >0) {
//			updateListUserWin(lstHandle);
//		}
//		return CompletableFuture.completedFuture(null);
//	}
	private void addSync(TaiXiuBetDTO obj) {
		if(obj.getId()==0) return;
//		lock.writeLock().lock();
//		try {
//			
//		} finally {
//			lock.writeLock().unlock();
//		}
		listData.add(obj);
	}
	
	@Override
	public void addBot(TaiXiuBetDTO obj) {
//		if (obj.getId() == 0)
//			return;
		int type = obj.getTyped().intValue();
		obj.setUserType(Constants.BOT);
		// put to queue
		addSync(obj);
		if (type ==Constants.TAI) {
			taiCount.getAndIncrement();
		} else {
			xiuCount.getAndIncrement();
		}
		//add to top
		rankService.insertRank(new TxRank(obj.getLoginname(), obj.getBetamount()));
		//log.info("after add CacheBotData oddCount={} ,evenCount={} ", taiCount.get(), xiuCount.get());
		// add amount cache
		addAmountTotal(type, obj.getBetamount(), false);
	}


	@Override
	public void addBot(long id , long amount) {
		addBot(new TaiXiuBetDTO(id, botService.getNamBot(),amount, Constants.TAI, Constants.BOT));
		addBot(new TaiXiuBetDTO(id, botService.getNamBot(),amount, Constants.XIU, Constants.BOT));
	}

	@Override
	public void addBot10s(long id , int type , long amount) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(),amount, type, Constants.BOT);
		addBot(tx);
	}

	@Override
	public void addBot20s(long id , int type , long amount) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(),amount, type, Constants.BOT);
		addBot(tx);
		
	}

	@Override
	public void addBot35s(long id , int type , long amount) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(),amount, type, Constants.BOT);
		addBot(tx);
		
	}

	@Override
	public void addBot45s(long id , int type , long amount) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(),amount, type, Constants.BOT);
		addBot(tx);
		
	}

	@Override
	public void addBot50s(long id , int type , long amount) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(),amount, type, Constants.BOT);
		addBot(tx);
		
	}

	private void addAmountTotal(int type, long amount, boolean isReal) {
		if (type == Constants.TAI) {
			if (isReal) {
				taiAmountReal.getAndAdd(amount);
			}
			addAmountTai(amount);
		} else {
			if (isReal) {
				xiuAmountReal.getAndAdd(amount);
			}
			addAmountXiu(amount);
		}
		//log.info("taiAmountReal ={} , xiuAmountReal={}", taiAmountReal.get(), xiuAmountReal.get());
		//log.info("total taiAmount ={} ,total xiuAmount={}", taiAmount.get(), xiuAmount.get());
	}

	@Override
	public void addBot(long id, long amount, int type) {
		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botService.getNamBot(), amount, type, Constants.BOT);
		addBot(tx);
	}

	@Override
	public void addBot(long id, long amount, int type, boolean isChoose) {
		String botname = "";
		if (type == Constants.TAI) {
			if (isChoose) {
				botname = botService.getNamBotTai();
			} else {
				botname = botService.getNamBotXiu();
			}
		} else {
			if (isChoose) {
				botname = botService.getNamBotXiu();
			} else {
				botname = botService.getNamBotTai();
			}
		}

		TaiXiuBetDTO tx = new TaiXiuBetDTO(id, botname, amount, type, Constants.BOT);
		addBot(tx);
	}
	
//	@Override
//	public Map<String,Long> refundMoney(int resultType, String resultStr, long amount) {
//		Map<String,Long> notifyData = new HashMap<String, Long>();
//		long tAmount = 0;
//		int i = listData.size() - 1;
//		log.info("Sizeeeeeeee batchhhhhhhhhhhhhhh ={}", i+1);
//		
//		try {
//			while (i >= 0 && tAmount < amount) {
//				TaiXiuBetDTO lastObj = listData.get(i);
//				int type = lastObj.getTyped().intValue();
//				if (type == resultType) {
//					i--;
//					continue;
//				}
//				String loginname = lastObj.getLoginname();
//				int usertype = lastObj.getUserType();
//				long lastAmount = lastObj.getBetamount();
//				if(usertype == Constants.REAL) {
//					if (lastAmount <= (amount - tAmount)) {
//						lastObj.setRefundamount(lastObj.getBetamount());
//					} else {
//						lastObj.setRefundamount(amount - tAmount);
//					}
//					spTaiXiuRefundDao.refundTaixiu(lastObj, resultStr);
//					listData.set(i, lastObj);
//					//add to send notify
//					if(notifyData.containsKey(loginname)) {
//						notifyData.computeIfPresent(loginname, (k, v) -> v + lastObj.getRefundamount());
//					}else {
//						notifyData.put(loginname, lastObj.getRefundamount());
//					}
//					
//				}else {
//					if (lastAmount <= (amount - tAmount)) {
//						// return all
//						//spDataBotDao.updateBotRefund(lastObj.getBetamount(), lastObj.getId());
//						
//					} else {
//						// return lastAmount - amount
//						//spDataBotDao.updateBotRefund(amount - tAmount, lastObj.getId());
//					}
//					
////					long amountB = 0;
////					if (lastAmount > amount) {
////						amountB = lastAmount - amount;
////					}else {
////						amountB = lastObj.getBetamount();
////					}
////					spDataBotDao.updateBotRefund(amountB, lastObj.getId());
//				}
//				i--;
//				tAmount += lastAmount;
//			}
//		} catch (Exception e) {
//			log.error(e.getMessage());
//		}
//		return notifyData;
//	}
	
	@Override
	@Async("taskExecutor")
	public void addMultipleBot(int numBotTai, int numBotXiu, long id, long amountTai, long amountXiu,
			boolean isChoose) {
		long t1 = System.currentTimeMillis();
		String time = CommonUtil.getCurDate(null);
		List<TaixiuRecord> lstData = new ArrayList<>();
		for (int i = 0; i < numBotTai; i++) {
			String nameBot = "";
			if (isChoose) {
				nameBot = botService.getNamBotTai();
			} else {
				nameBot = botService.getNamBotXiu();
			}
			if (nameBot == null || nameBot.equals("") || amountTai < 1000)
				continue;

			TaixiuRecord tx = new TaixiuRecord();
			tx.setBetamount(i == 0 ? amountTai : amountTai * i);
			tx.setLoginname(nameBot);
			tx.setTaixiuId(id);
			tx.setTyped(Constants.TAI);
			tx.setUserType(Constants.BOT);
			tx.setStatus(Constants.STATUS_FINISH);
			tx.setBettime(LocalDateTime.now());
			tx.setRefundamount(0l);
			lstData.add(tx);
		}

		for (int i = 0; i < numBotXiu; i++) {
			String nameBot = "";
			if (isChoose) {
				nameBot = botService.getNamBotXiu();
			} else {
				nameBot = botService.getNamBotTai();
			}
			if (nameBot == null || nameBot.equals("") || amountXiu < 1000)
				continue;

			TaixiuRecord tx = new TaixiuRecord();
			tx.setBetamount(i == 0 ? amountXiu : amountXiu * i);
			tx.setLoginname(nameBot);
			tx.setTaixiuId(id);
			tx.setTyped(Constants.XIU);
			tx.setUserType(Constants.BOT);
			tx.setStatus(Constants.STATUS_FINISH);
			tx.setBettime(LocalDateTime.now());
			tx.setRefundamount(0l);
			lstData.add(tx);

		}
		// save batch tai
		if (!lstData.isEmpty()) {
			List<TaixiuRecord> lstr = saveAll(lstData);
			for (TaixiuRecord taixiuRecord : lstr) {
				if (taixiuRecord.getId().longValue() == 0) {
					continue;
				}
				addBot(new TaiXiuBetDTO(taixiuRecord, time));
				//add to top
				rankService.insertRank(new TxRank(taixiuRecord.getLoginname(), taixiuRecord.getBetamount()));
			}

			long t2 = System.currentTimeMillis();
			log.info("Add multiple bot size ={} , timexxxxxxxxxxxxxxx={}", lstr.size(), (t2 - t1));
		}
	}
	
//	@Override
//	@Async("taskExecutor")
//	public void addMultipleBot(int numBotTai, int numBotXiu, long id, long amountTai, long amountXiu) {
//		long t1 =System.currentTimeMillis();
//		String time = CommonUtil.getCurDate(null);
//		List<TaixiuRecord> lstData = new ArrayList<>();
//		for (int i = 0; i < numBotTai ; i++) {
//			String nameBot = botService.getNamBot();
//			if (nameBot == null || nameBot.equals("") ||amountTai<1000)
//				continue;
//			
//			TaixiuRecord tx = new TaixiuRecord();
//			tx.setBetamount(i == 0 ? amountTai : amountTai * i);
//			tx.setLoginname(nameBot);
//			tx.setTaixiuId(id);
//			tx.setTyped(Constants.TAI);
//			tx.setUserType(Constants.BOT);
//			tx.setStatus(Constants.STATUS_FINISH);
//			tx.setBettime(LocalDateTime.now());
//			tx.setRefundamount(0d);
//			tx.setId(1l);
//			lstData.add(tx);
//		}
//		
//		for (int i = 0; i < numBotXiu ; i++) {
//			String nameBot = botService.getNamBot();
//			if (nameBot == null || nameBot.equals("") ||amountXiu <1000)
//				continue;
//			
//			TaixiuRecord tx = new TaixiuRecord();
//			tx.setBetamount(i == 0 ? amountXiu : amountXiu * i);
//			tx.setLoginname(nameBot);
//			tx.setTaixiuId(id);
//			tx.setTyped(Constants.XIU);
//			tx.setUserType(Constants.BOT);
//			tx.setStatus(Constants.STATUS_FINISH);
//			tx.setBettime(LocalDateTime.now());
//			tx.setRefundamount(0d);
//			tx.setId(1l);
//			lstData.add(tx);
//			
//		}
//		if (!lstData.isEmpty()) {
//			for (TaixiuRecord taixiuRecord : lstData) {
//				addBot(new TaiXiuBetDTO(taixiuRecord, time));
//			}
//		}
////		//save batch tai
////		if (!lstData.isEmpty()) {
////			List<TaixiuRecord> lstr = saveAll(lstData);
////			for (TaixiuRecord taixiuRecord : lstr) {
////				if(taixiuRecord.getId().longValue()==0) {
////					continue;
////				}
////				addBot(new TaiXiuBetDTO(taixiuRecord, time));
////			}
////			
////			long t2 = System.currentTimeMillis();
////			log.info("Add multiple bot size ={} , timexxxxxxxxxxxxxxx={}", lstr.size(), (t2 - t1));
////		}
////		if(listData.size()>0) {
////			int size =taixiuRecordDao.count(listData.get(0).getTaixiuId());
////			if(size!=listData.size()) {
////				System.out.println("s");
////			}
////		}
//		
//	}
//	
	@Transactional
	public List<TaixiuRecord> saveAll(List<TaixiuRecord> lstData) {
		return taixiuRecordDao.saveAll(lstData);
	}

	/**
	 * @return the userAmount
	 */
	@Override
	public Map<String, String> getUserAmount() {
		return userAmount;
	}

	/**
	 * @param userAmount the userAmount to set
	 */
	public void setUserAmount(Map<String, String> userAmount) {
		this.userAmount = userAmount;
	}
	
}
