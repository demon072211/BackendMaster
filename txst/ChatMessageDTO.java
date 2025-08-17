/**
 * 
 */
package com.archie.web.websocket.dto;

import java.io.Serializable;

/**
 * @author Archie
 * @date Sep 21, 2020
 */
public class ChatMessageDTO implements Serializable{
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 7970437799423481737L;
	private MessageType type;
	private String content;
	private String sender;

	public enum MessageType {
		CHAT, JOIN, LEAVE
	}

	public MessageType getType() {
		return type;
	}

	public void setType(MessageType type) {
		this.type = type;
	}

	public String getContent() {
		return content;
	}

	public void setContent(String content) {
		this.content = content;
	}

	public String getSender() {
		return sender;
	}

	public void setSender(String sender) {
		this.sender = sender;
	}
}
