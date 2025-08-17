package com.archie.web.websocket.dto;

import java.io.Serializable;

/**
 * Data Transfer Objects.
 */
public class WsResponse<T> implements Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 4341321904147170250L;

	private int cmd;

	private int status;
	
	private T data;
	
	/**
	 * @return the data
	 */
	public T getData() {
		return data;
	}

	/**
	 * @param data the data to set
	 */
	public void setData(T data) {
		this.data = data;
	}

	/**
	 * @return the cmd
	 */
	public int getCmd() {
		return cmd;
	}

	/**
	 * @param cmd the cmd to set
	 */
	public void setCmd(int cmd) {
		this.cmd = cmd;
	}

	/**
	 * @return the status
	 */
	public int getStatus() {
		return status;
	}

	/**
	 * @param status the status to set
	 */
	public void setStatus(int status) {
		this.status = status;
	}

	/**
	 * @param cmd
	 * @param status
	 */
	public WsResponse(int status) {
		super();
		this.status = status;
	}
	
	public WsResponse(int status, T data) {
		super();
		this.status = status;
		this.data = data;
	}
	
	public WsResponse(int status, int cmd , T data) {
		super();
		this.cmd=cmd;
		this.status = status;
		this.data = data;
	}

	/**
	 * 
	 */
	public WsResponse() {
		super();
	}

	@Override
	public String toString() {
		return "WsResponse [cmd=" + cmd + ", status=" + status + ", data=" + data + "]";
	}


}
