package com.archie.web.websocket;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.event.EventListener;
import org.springframework.messaging.simp.SimpMessageSendingOperations;
import org.springframework.messaging.simp.stomp.StompHeaderAccessor;
import org.springframework.messaging.support.GenericMessage;
import org.springframework.stereotype.Component;
import org.springframework.web.socket.messaging.SessionDisconnectEvent;
import org.springframework.web.socket.messaging.SessionSubscribeEvent;

import com.archie.config.Constants;
import com.archie.web.websocket.dto.WsResponse;

@Component
public class WebSocketEventListener {
	
	@Autowired
	private SimpMessageSendingOperations messagingTemplate;
	private static final Logger log = LoggerFactory.getLogger(WebSocketEventListener.class);
	public static final String LOGINNAME = "LOGINNAME";
	
//	@EventListener
//	public void handleWebSocketConnectListener(SessionConnectedEvent event) {
//		System.out.println("Received a new web socket connection");
//	}

	@EventListener
	public void handleWebSocketDisconnectListener(SessionDisconnectEvent event) {
		StompHeaderAccessor headerAccessor = StompHeaderAccessor.wrap(event.getMessage());
		String username = (String) headerAccessor.getSessionAttributes().get(LOGINNAME);
		log.info("disconnected ws from user {}", username);
		if (username != null) {
			WsResponse<String> ws = new WsResponse<>(0, Constants.CMD_DIS_TX, "WebSocketDisconnect");
			messagingTemplate.convertAndSendToUser(username, "/queue/tx", ws);
		}
	}

//	@EventListener
//	public void handleSessionSubscribeEvent(SessionSubscribeEvent event) {
//
//	}
	  
}