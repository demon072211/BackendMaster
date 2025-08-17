package com.archie.schedule;

import java.util.ArrayList;
import java.util.List;
import java.util.Map;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.messaging.simp.SimpMessagingTemplate;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Component;

import com.archie.config.Constants;
import com.archie.dao.TaixiuRecordRepository;
import com.archie.service.UserService;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.service.dto.WsBaseDTO;
import com.archie.service.dto.WsChatDto;
import com.archie.web.websocket.dto.WsNotifyUserDTO;
import com.archie.web.websocket.dto.WsTaiXiuDTO;
import com.vinplay.vbee.common.enums.Games;
import com.vinplay.vbee.common.response.MoneyResponse;
@Component
public class AsyncComponent {
	private final Logger log = LoggerFactory.getLogger(BatchTaixiuBonus.class);
	@Autowired
	private SimpMessagingTemplate template;
	
	@Autowired private UserService userService;
	
	@Autowired
	private TaixiuRecordRepository taixiuRecordDao;

	@Async("taskExecutor")
	public void sendQueueUserWin(Map<String, Long> lstUser) {
		log.info("WS sendQueueUserWin data = {}", lstUser.toString());
		long t1 = System.currentTimeMillis();
		lstUser.forEach((k, v) -> {
			WsNotifyUserDTO payload = new WsNotifyUserDTO((Constants.rate + 1) * v, Constants.CMD_WIN_USER);
			template.convertAndSendToUser(k, "/queue/tx", payload);
		});
		long t2 = System.currentTimeMillis();
		log.info("WS sendQueueUserWin timexx = {}", (t2 - t1));
	}

	@Async("taskExecutor")
	public void sendQueueUserRefund(Map<String, Long> lstUser) {
		long t1 = System.currentTimeMillis();
		lstUser.forEach((k, v) -> {
			WsNotifyUserDTO payload = new WsNotifyUserDTO(v, Constants.CMD_REFUND_USER);
			template.convertAndSendToUser(k, "/queue/tx", payload);
		});
		long t2 = System.currentTimeMillis();
		log.info("WS sendQueueUserRefund  timexx = {}", (t2 - t1));
	}

	@Async("taskExecutor")
	public void sendMessageBet(Map<String, String> mapData) {
		log.info("WS sendMessageBet  data = {}", mapData.toString());
		long t1 = System.currentTimeMillis();
		mapData.forEach((k, v) -> {
			template.convertAndSendToUser(k, "/queue/tx", new WsBaseDTO<String>(Constants.CMD_USER_BET, v));
		});
		long t2 = System.currentTimeMillis();
		log.info("WS sendMessageBet  timexx = {}", (t2 - t1));
	}

	@Async("taskExecutor")
	public void send15s(int count, long tai, long xiu, long taiAmount, long xiuAmount, long taiAmountOld,
			long xiuAmountOld, long taixiuId) {
		WsTaiXiuDTO wsMessage = new WsTaiXiuDTO(count, tai, xiu, taiAmount, xiuAmount, taixiuId, Constants.CMD_17S);
		long t1 = System.currentTimeMillis();
		template.convertAndSend("/topic/tx", wsMessage);
		long t2 = System.currentTimeMillis();
		log.info("WS Sending send50s message data = {} , timexx ={}", wsMessage.toString(), (t2 - t1));
	}

	@Async("taskExecutor")
	public void send51s14s(int cd, long ut, long ux, long at, long ax, long id, int cmd, int[] result) {
		WsTaiXiuDTO wsMessage = new WsTaiXiuDTO(cd, ut, ux, at, ax, id, result, cmd);
		long t1 = System.currentTimeMillis();
		template.convertAndSend("/topic/tx", wsMessage);
		long t2 = System.currentTimeMillis();
		log.info("WS Sending send51s14s message data = {} , timexx = {}", wsMessage.toString(), (t2 - t1));
	}

	@Async("taskExecutor")
	public void sendMaintainNotify(boolean isMaintain) {
		template.convertAndSend("/topic/tx", new WsBaseDTO<Boolean>(Constants.CMD_MAINTAIN, isMaintain));
	}
	
	//
	@Async("taskExecutor")
	public void updateListBotWin(String resultStr, List<Long> lstBotIdWin) {
		taixiuRecordDao.updateListBotWin(Constants.rate, resultStr, lstBotIdWin);

	}

	@Async("taskExecutor")
	public void updateListBotLose(String resultStr, List<Long> lstBotIdLose) {
		taixiuRecordDao.updateListBotLose(lstBotIdLose, resultStr);
	}
	
	@Async("taskExecutor")
	public void updateListUserWin(List<TaiXiuBetDTO> lstData) {
		List<Long> lstID = new ArrayList<Long>();
		String result = "";
		try {

			for (TaiXiuBetDTO tx : lstData) {
				double amount = (1 + Constants.rate) * (tx.getBetamount() - tx.getRefundamount());
				MoneyResponse moneyResponse = userService.updateMoneyUser(tx.getLoginname(), (long) amount,
						"vin", Games.TAI_XIU_ST.getName(), Games.TAI_XIU_ST.getId() + "", "Thắng tài xỉu siêu tốc", 0,
						true);
				if (moneyResponse != null && moneyResponse.getErrorCode().equals("0")) {
					lstID.add(tx.getId());
					result = tx.getResult();
				}
			}
			if (lstID != null && !lstID.isEmpty()) {
				updateListBotWin(result, lstID);
			}

		} catch (Exception e) {
			log.error(e + "");
		}
		//return CompletableFuture.completedFuture(null);
	}
	
	@Async("taskExecutor")
	public void updateListUserLose(List<TaiXiuBetDTO> lstData) {
		List<Long> lstID = new ArrayList<Long>();
		String result = "";
		try {
			for (TaiXiuBetDTO tx : lstData) {
				lstID.add(tx.getId());
				result = tx.getResult();
			}
			if (lstID != null && !lstID.isEmpty()) {
				updateListBotLose(result, lstID);
			}
		} catch (Exception e) {
			log.error(e + "");
		}
		//return CompletableFuture.completedFuture(null);
	}
	
	@Async("taskExecutor")
	public void sendMess(WsChatDto message) {
		message.setCmd(Constants.CMD_CHAT);
		template.convertAndSend("/topic/tx", message);
	}

}
