/**
 * 
 */
package com.archie.web.websocket;

import java.security.Principal;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationListener;
import org.springframework.messaging.handler.annotation.MessageMapping;
import org.springframework.messaging.handler.annotation.Payload;
import org.springframework.messaging.handler.annotation.SendTo;
import org.springframework.messaging.simp.SimpMessageSendingOperations;
import org.springframework.messaging.simp.annotation.SendToUser;
import org.springframework.messaging.simp.stomp.StompHeaderAccessor;
import org.springframework.stereotype.Controller;
import org.springframework.web.socket.messaging.SessionDisconnectEvent;
import com.archie.config.Constants;
import com.archie.entity.Taixiu;
import com.archie.entity.TxRank;
import com.archie.schedule.BatchTaixiuBonus;
import com.archie.service.ChatboxService;
import com.archie.service.RankService;
import com.archie.service.TaixiuRecordService;
import com.archie.service.TaixiuService;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.service.dto.WsBaseDTO;
import com.archie.service.dto.WsChatDto;
import com.archie.web.websocket.dto.ActivityDTO;
import com.archie.web.websocket.dto.WsResponse;

@Controller
public class TaiXiuWsController implements ApplicationListener<SessionDisconnectEvent> {

	private static final Logger log = LoggerFactory.getLogger(TaiXiuWsController.class);

	@Autowired
	private SimpMessageSendingOperations messagingTemplate;

	private static final String IP_ADDRESS = "IP_ADDRESS";

	@Autowired private TaixiuRecordService taixiuService;
	
	@Autowired private BatchTaixiuBonus tx;
	
	@Autowired private ChatboxService service;
	
	@Autowired private TaixiuService txService;
	
	@Autowired private RankService rankService;

	@MessageMapping("/topic/bet")
	@SendToUser("/queue/tx")
	public WsResponse<TaiXiuBetDTO> betTaixiu(@Payload TaiXiuBetDTO taixiuDTO,
			StompHeaderAccessor stompHeaderAccessor, Principal principal) {
		taixiuDTO.setIp(stompHeaderAccessor.getSessionAttributes().get(IP_ADDRESS).toString());
		String loginname = principal.getName();
		taixiuDTO.setUsername(loginname);
		WsResponse<TaiXiuBetDTO> result = null;
		try {
			result = taixiuService.save(taixiuDTO);
		} catch (Exception e) {
			log.error(e.getMessage());
			result = new WsResponse<>(Constants.SYSTEM_ERROR);
		}
		result.setCmd(Constants.CMD_BET);
		log.debug("betTaixiu user {}, bet data {}", principal.getName(), taixiuDTO.toString());
		return result;
	}
	

	@MessageMapping("/topic/chats")
	@SendTo("/topic/tx")
	public WsChatDto sendMessage(@Payload WsChatDto chat, StompHeaderAccessor stompHeaderAccessor,
			Principal principal) {
		log.info("request chat {}",chat.toString());
		String loginname = principal.getName();
		log.info("user chat lognname = {}",loginname);
		if (loginname == null || loginname.equals(""))
			return null;
		
		//sendOneMessage(chat);
		return service.save(chat);
	}
	
	@MessageMapping("/topic/maintainstatus")
	@SendToUser("/topic/tx")
	public WsBaseDTO<Boolean> maintainstatus(StompHeaderAccessor stompHeaderAccessor, Principal principal) {
		log.info("wsmaintainstatus info");
		return new WsBaseDTO<Boolean>(Constants.CMD_MAINTAIN, tx.isMaintain());
	}
	
	@MessageMapping("/topic/public")
	@SendToUser("/queue/tx")
	public WsResponse<List<WsChatDto>> getMessage(StompHeaderAccessor stompHeaderAccessor, Principal principal) {
		WsResponse<List<WsChatDto>>  ws =null;
		log.info("request topic chat, loginname = {}", principal.getName());
		String loginname = principal.getName();
		if (loginname == null || loginname.equals(""))
			return new WsResponse<List<WsChatDto>>(Constants.FAIL);
		try {
			List<WsChatDto> result = service.findAll();
			if (result != null)
				log.info("Sending topic chat size = {}", result.size());
			ws = new WsResponse<List<WsChatDto>>(Constants.OK, result);
		} catch (Exception e) {
			log.error(e.getMessage());
			new WsResponse<List<WsChatDto>>(Constants.FAIL);
		}
		ws.setCmd(Constants.CMD_CHAT_ALL);
		return ws;
	}
	
	@MessageMapping("/topic/lichsuphien")
	@SendToUser("/queue/tx")
	public WsResponse<List<Taixiu>> history(StompHeaderAccessor stompHeaderAccessor, Principal principal) {
		WsResponse<List<Taixiu>> result = null;
		try {
			List<Taixiu> data = txService.getLast100Record();
				result = new WsResponse<List<Taixiu>>(Constants.OK, data) ;
		} catch (Exception e) {
			result = new WsResponse<>(Constants.SYSTEM_ERROR);
		}
		result.setCmd(Constants.CMD_HISTORY);
		log.debug("Sending user {}, history data {}", principal.getName(), result);
		//messagingTemplate.convertAndSendToUser(principal.getName(), "/queue/tx", result);
		return result;
	}
	
	@MessageMapping("/topic/ranktx")
	@SendToUser("/queue/tx")
	public WsResponse<List<TxRank>> getTopRank(StompHeaderAccessor stompHeaderAccessor, Principal principal) {
		log.debug("REST request to get a page of TxRanks");
		try {
			return new WsResponse<List<TxRank>>(Constants.OK, Constants.CMD_RANK_TX,
					rankService.getTopTxRank());
		} catch (Exception e) {
			return new WsResponse<>(Constants.SYSTEM_ERROR, Constants.CMD_RANK_TX, null);
		}
	}
	
	@Override
	public void onApplicationEvent(SessionDisconnectEvent event) {
		ActivityDTO activityDTO = new ActivityDTO();
		activityDTO.setSessionId(event.getSessionId());
		activityDTO.setPage("logout");
		messagingTemplate.convertAndSend("/queue/tx", activityDTO);
	}
}
