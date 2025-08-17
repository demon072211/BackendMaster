package com.archie.service.impl;

import java.time.Instant;
import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.archie.config.Constants;
import com.archie.entity.Taixiu;
import com.archie.entity.TaixiuRecord;
import com.archie.entity.TxRank;
import com.archie.hazelcast.HazelcastUtils;

import com.archie.repository.UserinfoRepository;
import com.archie.domain.User;
import com.archie.domain.Userinfo;
import com.archie.dao.TaixiuRecordRepository;
import com.archie.schedule.BatchTaixiuBonus;
import com.archie.service.InMemoryTaiXiuService;
import com.archie.service.RankService;
import com.archie.service.TaixiuRecordService;
import com.archie.service.TaixiuService;
import com.archie.service.UserService;
import com.archie.service.dto.TKPhienDTO;
import com.archie.service.dto.TKTaiXiuDTO;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.util.CommonUtil;
import com.archie.web.websocket.dto.WsResponse;
import com.vinplay.vbee.common.enums.Games;
import com.vinplay.vbee.common.response.MoneyResponse;
import com.vinplay.vbee.common.utils.VinPlayUtils;
/**
 * Service Implementation for managing {@link TaixiuRecord}.
 */
@Service
public class TaixiuRecordServiceImpl implements TaixiuRecordService {

    private final Logger log = LoggerFactory.getLogger(TaixiuRecordServiceImpl.class);

    private final TaixiuRecordRepository taixiuRecordRepository;
    
	@Autowired
	private RankService rankService;
    
    @Autowired 
    private BatchTaixiuBonus batchTx;
    
    @Autowired
    private UserService userService;
    
    @Autowired
    private UserinfoRepository userinfoRepository;
    
    @Autowired 
    private TaixiuService taixiuService;
    
    @Autowired 
    private InMemoryTaiXiuService txCacheService;

    public TaixiuRecordServiceImpl(TaixiuRecordRepository taixiuRecordRepository) {
        this.taixiuRecordRepository = taixiuRecordRepository;
    }

    @Override
    public TaixiuRecord save(TaixiuRecord taixiuRecord) {
        log.debug("Request to save TaixiuRecord : {}", taixiuRecord);
        return taixiuRecordRepository.save(taixiuRecord);
    }

	@Override
	@Transactional(readOnly = false)
	public Page<TaixiuRecord> filter(Pageable pageable, String loginname, Long luotxo, Integer type, Integer status,
			Integer userType, Instant startTime, Instant endTime) {
		log.debug("Request to get all TaixiuRecords");
		return taixiuRecordRepository.filter(pageable, loginname, luotxo, type, status, userType, startTime, endTime);
	}

    @Override
    @Transactional(readOnly = false)
    public Page<TaixiuRecord> findAll(Pageable pageable) {
        log.debug("Request to get all TaixiuRecords");
        return taixiuRecordRepository.findAll(pageable);
    }


    @Override
    @Transactional(readOnly = false)
    public Optional<TaixiuRecord> findOne(Long id) {
        log.debug("Request to get TaixiuRecord : {}", id);
        return taixiuRecordRepository.findById(id);
    }

    @Override
    public void delete(Long id) {
        log.debug("Request to delete TaixiuRecord : {}", id);
        taixiuRecordRepository.deleteById(id);
    }
    
    @Scheduled(cron = "0 0 12 * * ?")
    public void ScheduleCleanData() {
        log.debug("Request to clear TaixiuRecord : {}", LocalDateTime.now());
        taixiuRecordRepository.deleteListBot(LocalDateTime.now().minusDays(2));
    }
   	
	@Override
	public WsResponse<TaiXiuBetDTO> save(TaiXiuBetDTO taixiuRecord) throws Exception{
		Long taixiuID = taixiuRecord.getTaixiuId();
		String nickName = taixiuRecord.getLoginname();
		Long betamount = taixiuRecord.getBetamount();
		Integer typed = taixiuRecord.getTyped();
		String username = taixiuRecord.getUsername();
		if (taixiuID == null) {
			log.error("Sai du lieu, taixiuID is null !");
			return new WsResponse<TaiXiuBetDTO>(6);
		}
		if (nickName == null || "".equals(nickName)) {
			log.error("Sai du lieu, nickName is null or empty !");
			return new WsResponse<TaiXiuBetDTO>(6);
		}
		if (betamount == null || betamount<=0) {
			log.error("Sai du lieu, betamount is null or betamount < 0!");
			return new WsResponse<TaiXiuBetDTO>(6);
		}
		if (typed == null) {
			log.error("Sai du lieu, type is null !");
			return new WsResponse<TaiXiuBetDTO>(6);
		}
		if (username == null || "".equals(username)) {
			log.error("Sai du lieu, username is null or empty !");
			return new WsResponse<TaiXiuBetDTO>(6);
		}
		log.info("bet request = {}", taixiuRecord.toString());
		
		String time = CommonUtil.getCurDate("yyyy-MM-dd HH:mm:ss");
		int type = typed.intValue();
		
		//get taixiuid
		if(!batchTx.getEnabled() || batchTx.getCount() >17 || batchTx.isMaintain() || batchTx.getCount() < 3) {
			log.error("Phien moi chua bat dau !");
			return new WsResponse<TaiXiuBetDTO>(1);
		}
		Optional<Userinfo> user = userinfoRepository.findOneByNickName(nickName);
		//check min max amount
//		Optional<User> user = userService.findOneByLogin(nickName);
		if(user.isPresent()) {
			if(user.get().getBalance() < betamount) {
				log.error("số dư không đủ betamount= {} ", betamount);
				return new WsResponse<TaiXiuBetDTO>(16);
			}
			if(!user.get().getLoginname().equals(username)) {
				log.error("sai token, token username= {} , loginname real ={}", username, user.get().getLoginname());
				return new WsResponse<TaiXiuBetDTO>(98);
			}
		}else {
			log.error("Khong ton tai user nay , nickName = {}",nickName);
			return new WsResponse<TaiXiuBetDTO>(5);
		}
		//check id mo thuong
		Long openingTx = taixiuService.getTaixiuOpening();
		if (!openingTx.equals(taixiuID)) {
			log.error("Luot xo nay da het han , vui long cho toi luot xo sau ! , luotxo ={}",taixiuRecord.getTaixiuId());
			return new WsResponse<TaiXiuBetDTO>(3);
		}
		if(type != Constants.TAI && type != Constants.XIU) {
			return new WsResponse<TaiXiuBetDTO>(4);
		}
		//check type
		int check = txCacheService.isValidBet(nickName, type);
		if (check == Constants.FAIL) {
			log.error("User da cuoc cua khac roi, vui long dat cuoc lai !");
			//String typeName = Constants.TAI == type ? "XỈU" : "TÀI";
			return new WsResponse<TaiXiuBetDTO>(8);
		}
		//set dataa
		taixiuRecord.setTime(time);
		taixiuRecord.setUserType(Constants.REAL);
		taixiuRecord.setStatus(Constants.PENDING);
		taixiuRecord.setRefundamount(0);
		MoneyResponse moneyResponse = userService.updateMoneyUser(nickName, -betamount, "vin", Games.TAI_XIU_ST.getName(),
				Games.TAI_XIU_ST.getId() + "", "Cược tài xỉu siêu tốc", 0, true);
			
		if (moneyResponse == null || !"0".equals(moneyResponse.getErrorCode())) {
			log.error(moneyResponse.getMessage());
			return new WsResponse<TaiXiuBetDTO>(92);
		}
		// save to db
		TaixiuRecord tx = new TaixiuRecord(taixiuRecord);
		tx = taixiuRecordRepository.save(tx);
		//save List , count to cached
		taixiuRecord.setId(tx.getId());
		txCacheService.addToList(taixiuRecord, check);
		rankService.insertRank(new TxRank(nickName, betamount));
		//taixiuRecord.setUsername(null);
		return new WsResponse<TaiXiuBetDTO>(Constants.OK, taixiuRecord);
	}

	@Override
	public Page<TaixiuRecord> findByLoginname(Pageable pageable, String loginname) {
		Optional<User> uo = userService.findOneByLogin(loginname);
		if(uo.isPresent()) {
			return taixiuRecordRepository.findAllByLoginname(pageable, uo.get().getFullName());
		}else {
			return null;
		}
	}

	@Override
	public List<TaixiuRecord> findAllByTaiXiuId(long id) {
		Optional<Taixiu> luotxo = taixiuService.findOne(id);
		if(luotxo.isPresent()) {
			List<TaixiuRecord> result = taixiuRecordRepository.findAllByTaixiuId(id);
			return result;
		}else {
			List<TaixiuRecord> result = taixiuRecordRepository.findAllByTaixiuId(taixiuService.getTaixiuOpening());
			return result;
		}
	}

	@Override
	public TKTaiXiuDTO findAllByPhienId(long id) {
		Optional<Taixiu> luotxo = taixiuService.findOne(id);
		if (luotxo.isPresent()) {
			Taixiu ob = luotxo.get();
			List<TKPhienDTO> page  =  taixiuRecordRepository.findByTaixiuId(id);
			return new TKTaiXiuDTO(ob.getId(), ob.getResult(), page);
		}
		return new TKTaiXiuDTO();
	}

	@Override
	@Transactional
	public List<TaixiuRecord> saveAll(List<TaixiuRecord> lstData) {
		return taixiuRecordRepository.saveAll(lstData);
	}

}
