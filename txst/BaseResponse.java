package com.archie.service.dto;

import java.io.Serializable;

/**
 * Data Transfer Objects.
 */
public class BaseResponse<T> implements Serializable {
	
	/**
	 * 
	 */
	private static final long serialVersionUID = 6103741387855596431L;

	private int cmd;
	
	private int status;

	private String message;

	private T data;
	

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
	 * @return the message
	 */
	public String getMessage() {
		return message;
	}

	/**
	 * @param message the message to set
	 */
	public void setMessage(String message) {
		this.message = message;
	}

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
	 * @param status
	 * @param message
	 * @param data
	 */
	public BaseResponse(int status, String message, T data) {
		super();
		this.status = status;
		this.message = message;
		this.data = data;
	}
	

	/**
	 * 
	 */
	public BaseResponse() {
		super();
	}

	/**
	 * @param status
	 * @param message
	 */
	public BaseResponse(int status, String message) {
		super();
		this.status = status;
		this.message = message;
	}

	@Override
	public String toString() {
		return "BaseResponse [status=" + status + ", message=" + message + ", data=" + data + "]";
	}

}
