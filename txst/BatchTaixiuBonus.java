/**
 * 
 */
package com.archie.schedule;

import java.security.SecureRandom;
import java.time.LocalDateTime;
import java.util.Random;
import java.util.SplittableRandom;
import java.util.concurrent.CompletableFuture;
import java.util.concurrent.atomic.AtomicBoolean;
import java.util.concurrent.atomic.AtomicInteger;
import java.util.concurrent.atomic.AtomicLong;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;

import com.archie.config.Constants;
import com.archie.entity.Taixiu;
import com.archie.service.InMemoryTaiXiuService;
import com.archie.service.TaixiuService;

/**
 * @author Archie
 * @date Sep 18, 2020
 */
@Service
public class BatchTaixiuBonus {

	private final Logger log = LoggerFactory.getLogger(BatchTaixiuBonus.class);

	private AtomicBoolean enabled = new AtomicBoolean(true);

	private AtomicInteger count = new AtomicInteger(0);

	private long taiAmountOld = 0;

	private long xiuAmountOld = 0;

	private AtomicBoolean isChoose = new AtomicBoolean(true);
	
	private AtomicInteger code = new AtomicInteger(0);

	@Autowired
	private AsyncComponent asyncComponent;

	@Autowired
	private InMemoryTaiXiuService txCacheService;

	@Autowired
	private TaixiuService taixiuService;

	private AtomicLong taixiuIdOpening = new AtomicLong(0);

	private final SplittableRandom rdom = new SplittableRandom();
	
	private int taiHigh = 0;

	private int xiuHigh = 0;
	private int count10s = 0;
	private int count20s = 0;
	private int count30s = 0;
	private int count40s = 0;

	int resultStatus = 0;
	int[] result = new int[3];
	//long resultAmount;
	private AtomicBoolean enableBot = new AtomicBoolean(true);
	private AtomicBoolean isMaintained = new AtomicBoolean(false);
	private AtomicInteger winCount = new AtomicInteger();
	private int rate = 3;
	
	private void resetInit() {
		count.set(0);
		enabled.set(true);
		// save old value =0
		taiAmountOld = 0;
		xiuAmountOld = 0;

		taiHigh = 0;
		xiuHigh = 0;

		count10s = 0;
		count20s = 0;
		count30s = 0;
		count40s = 0;

		result = new int[3];
		//resultAmount = 0;
		resultStatus = 0;
	}

	private int[] resultRoll(int resultStatus) {
		if (Constants.XIU == resultStatus) {
			int totalNum = rdom.nextInt(10 - 3 + 1) + 3;
			int t1 = totalNum / 3;
			int t2 = 0;
			if (totalNum - t1 <= 6) {
				t2 = rdom.nextInt(totalNum - t1 - 1 - 1 + 1) + 1;
			} else {
				t2 = rdom.nextInt(6 - 1 - 1 + 1) + 1;
			}
			int t3 = totalNum - t1 - t2;
			int[] resultTx = { t1, t2, t3 };
			log.info("Dang tinh thuong ...xiu win");
			return resultTx;
		} else {
			int totalNum = rdom.nextInt(18 - 11 + 1) + 11;
			int t1 = totalNum / 3;
			int t2 = rdom.nextInt(6 - (totalNum - t1 - 6) + 1) + (totalNum - t1 - 6);
			int t3 = totalNum - t1 - t2;
			int[] resultTx = { t1, t2, t3 };
			log.info("Dang tinh thuong ...tai win");
			return resultTx;
		}
	}
	
	@Scheduled(fixedDelay = 1000) 
	public void countdown() {
		log.info("BatchTaixiuBonus , countdown ={} , threadname = {} , availableProcessors={} ", count.get(),
				Thread.currentThread().getName(), Runtime.getRuntime().availableProcessors());
		if (isMaintained.get() && count.get() >= 23) {
			enabled.set(false);
			return;
		}
		try {
			if (count.get() == 0) {
				// open 1st luot xo
				Taixiu opennew = taixiuService.opennew();
				if (opennew == null) {
					log.error("Khong tao duoc luot xo moi");
					return;
				}
				isChoose.getAndSet(rdom.nextBoolean());
				taixiuIdOpening.getAndSet(opennew.getId());
				randomByTime();
			}
			int num = count.getAndIncrement();

			long[] longQuantity = txCacheService.getQuantity1s();
			long taiCount = longQuantity[0];
			long xiuCount = longQuantity[1];
			long taiAmount = longQuantity[2];
			long xiuAmount = longQuantity[3];
			long taiAmountReal = longQuantity[4];
			long xiuAmountReal = longQuantity[5];
			asyncComponent.sendMessageBet(txCacheService.getUserAmount());
			if (num < 3 || num > 17) {
				enabled.set(false);
			}
			//bet từ s thứ 3->17
			if (num >=3 && num <=17) {
				enabled.set(true);
				// send topic to clients
				optimize(num, taiCount, xiuCount, taiAmount, xiuAmount, taiAmountOld, xiuAmountOld, taixiuIdOpening.get(), taiAmountReal ,xiuAmountReal);
			} else {
				try {
					if (num == 18) {
						enabled.set(false);
						Thread.sleep(1000);

						// tinh ket qua
						if (winCount.get() > rate) {
							winCount.set(0);
						}
						SecureRandom srdom = new SecureRandom();
						if (taiAmountReal + xiuAmountReal <= 10000000) {
							if (winCount.get() <= rate) {
								if (srdom.nextBoolean()) {
									resultStatus = Constants.XIU;
								} else {
									resultStatus = Constants.TAI;
								}
								if ((resultStatus == Constants.XIU && taiAmountReal < xiuAmountReal)
										|| (resultStatus == Constants.TAI && xiuAmountReal < taiAmountReal)) {
									winCount.getAndIncrement();
								}
							} else {
								resultStatus = taiAmountReal > xiuAmountReal ? Constants.XIU : Constants.TAI;
							}
						}else {
							int ranE = srdom.nextInt(3 - 1 + 1) + 1;
							if (ranE == 2) {
								if (srdom.nextBoolean()) {
									resultStatus = Constants.XIU;
								} else {
									resultStatus = Constants.TAI;
								}
							} else {
								resultStatus = taiAmountReal > xiuAmountReal ? Constants.XIU : Constants.TAI;
							}
						}
						
						result = resultRoll(resultStatus);
						// send all users
						asyncComponent.send51s14s(num, taiCount, xiuCount, taiAmount, xiuAmount, taixiuIdOpening.get(), Constants.CMD_18S,result);
						// update status old luot xo
						taixiuService.updateOld(result, resultStatus == Constants.TAI ? taiAmount : xiuAmount);
						//calculate result
						txCacheService.winloseData(resultStatus, result);
					}
					// chuan bi luot ke
					asyncComponent.send51s14s(num, taiCount, xiuCount, taiAmount, xiuAmount, taixiuIdOpening.get(), Constants.CMD_5S,result);
					//sendNotificationAdmin(num, taiCount, xiuCount, taiAmount, xiuAmount, taiAmountReal, xiuAmountReal, taixiuIdOpening, result);
					if (num >= 19 || num <= 22) {
						Thread.sleep(500);
					}
					if (num >= 23) {
						resetInit();
						txCacheService.reset();
					}
				} catch (Exception e) {
					log.error("ERROR Batch {}", e);
					resetInit();
					txCacheService.reset();
				} finally {
					if (num >= 23) {
						resetInit();
						txCacheService.reset();
					}
				}
			}
			log.info("countdown , count ={}", num);
		} catch (Exception e) {
			log.error("ERROR countdown {}", e);
		}
	}
	
	// return 1->1000000
	private int randomAmount() {
		Random r = new Random();
		int k = r.nextInt(100 - 5 + 1) + 5;
		return k * 10000;
	}

	private void randomByTime() {
		// random.nextInt(max - min + 1) + min
		//3->5 6->9 , 10->14 , 15 -> 17
		count10s = rdom.nextInt(5 - 3 + 1) + 3;
		count20s = rdom.nextInt(9 - 6 + 1) + 6;
		count30s = rdom.nextInt(14 - 10 + 1) + 10;
		count40s = rdom.nextInt(17 - 15 + 1) + 15;
	}

	public void optimize(int count, long tai, long xiu, long taiAmount, long xiuAmount, long taiAmountOld,
			long xiuAmountOld, long taixiuId, long taiAmountReal, long xiuAmountReal) {
		// enhance bot random.nextInt(max - min + 1) + min
		if (enableBot.get()) {
			int numBotTai = 1, numBotXiu = 1;

			int hour = LocalDateTime.now().getHour();
			if (count > 1 && hour < 22 && hour > 9) {
				numBotTai = rdom.nextInt(15 - 1 + 1) + 1;
				numBotXiu = rdom.nextInt(15 - 1 + 1) + 1;
			}
			if (count > 1 && (hour >= 22 || hour <= 9)) {
				// it ng choi
				numBotTai = rdom.nextInt(12 - 0 + 1) + 0;
				numBotXiu = rdom.nextInt(12 - 0 + 1) + 0;
			}
			boolean isOddEven = isChoose.get();
			if (count <= count10s && count > 1) {
				txCacheService.addMultipleBot(numBotTai, numBotXiu, taixiuId, count * 10000, count * 20000,
						isOddEven);
			} else if (count <= count20s) {
				txCacheService.addMultipleBot(numBotTai, numBotXiu, taixiuId, count * 25000, count * 20000, isOddEven);
			} else if (count <= count30s) {
				txCacheService.addMultipleBot(numBotTai, numBotXiu, taixiuId, count * 15000, count * 20000, isOddEven);
			} else if (count <= count40s) {
				txCacheService.addMultipleBot(numBotTai, numBotXiu, taixiuId, count * 20000, count * 10000, isOddEven);
			}
			if (count <=17) {
				// check old
				if (taiAmount > xiuAmount && taiAmountOld > xiuAmountOld) {
					taiHigh++;
				} else {
					taiHigh = 0;
				}
				if (xiuAmount > taiAmount && xiuAmountOld > taiAmountOld) {
					xiuHigh++;
				} else {
					xiuHigh = 0;
				}

				if (xiuHigh >= 3) {
					// xiu hon tai random lan -> tang tai
					long tAmount = (xiuAmount - taiAmount) + randomAmount();
					xiuHigh = 0;
					txCacheService.addBot(taixiuId, tAmount, Constants.TAI, isOddEven);
				}
				if (taiHigh >= 3) {
					// tai hon xiu random lan -> tang xiu
					long xAmount = (taiAmount - xiuAmount) + randomAmount();
					taiHigh = 0;
					txCacheService.addBot(taixiuId, xAmount, Constants.XIU, isOddEven);
				}
			}
		}
		this.taiAmountOld =taiAmount;
		this.xiuAmountOld =xiuAmount;
		asyncComponent.send15s(count, tai, xiu, taiAmount, xiuAmount, taiAmountOld, xiuAmountOld, taixiuId);
	}
	
	
	/**
	 * @return the enabled
	 */
	public boolean getEnabled() {
		return enabled.get();
	}

	/**
	 * @param enabled the enabled to set
	 */
	public void setEnabled(boolean enabled) {
		this.enabled.set(enabled);
	}

	/**
	 * @return the count
	 */
	public int getCount() {
		return count.get();
	}

	/**
	 * @param count the count to set
	 */
	public void setCount(int count) {
		this.count.set(count);
	}

	/**
	 * @return the enableBot
	 */
	public boolean isEnableBot() {
		return enableBot.get();
	}

	/**
	 * @param enableBot the enableBot to set
	 */
	public boolean setEnableBot() {
		if (enableBot.get()) {
			enableBot.getAndSet(false);
		} else {
			enableBot.getAndSet(true);
		}
		return enableBot.get();
	}

	/**
	 * @return the isMaintain
	 */
	public boolean isMaintain() {
		return isMaintained.get();
	}

	/**
	 * @param isMaintain the isMaintain to set
	 */
	public boolean setMaintain() {
		if (this.isMaintained.get()) {
			this.isMaintained.getAndSet(false);
		} else {
			this.isMaintained.getAndSet(true);
			log.info("He thong se maintainnnnnnn trong it phut");
		}
		asyncComponent.sendMaintainNotify(isMaintained.get());
		return this.isMaintained.get();
	}

	/**
	 * @param code the code to set
	 */
	public Integer setCode(int code) {
		return this.code.getAndSet(code);
	}

	public int getWinCount() {
		return rate;
	}

	public int setWinCount(int winCount) {
		if (winCount > 5 || winCount < 0) {
			return rate;
		}
		rate = winCount;
		return rate;
	}

}
