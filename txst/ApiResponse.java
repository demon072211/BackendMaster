/**
 * 
 */
package com.archie.service.dto;

import java.io.Serializable;

/**
 * @author Archie
 * @date Oct 15, 2020
 */
public class ApiResponse<T> implements Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 3678601180572223763L;

	private String message;

	private int totalPages;

	private T content;

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
	 * @return the totalPages
	 */
	public int getTotalPages() {
		return totalPages;
	}

	/**
	 * @param totalPages the totalPages to set
	 */
	public void setTotalPages(int totalPages) {
		this.totalPages = totalPages;
	}

	/**
	 * @return the content
	 */
	public T getContent() {
		return content;
	}

	/**
	 * @param content the content to set
	 */
	public void setContent(T content) {
		this.content = content;
	}

	/**
	 * @param message
	 * @param totalPages
	 * @param content
	 */
	public ApiResponse(String message, int totalPages, T content) {
		super();
		this.message = message;
		this.totalPages = totalPages;
		this.content = content;
	}

	/**
	 * 
	 */
	public ApiResponse() {
		super();
	}

}
