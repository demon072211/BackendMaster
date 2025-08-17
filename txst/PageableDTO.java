/**
 * 
 */
package com.archie.web.websocket.dto;

import java.io.Serializable;

/**
 * @author Archie
 * @date Oct 13, 2020
 */
public class PageableDTO implements Serializable{
	/**
	 * 
	 */
	private static final long serialVersionUID = -8860821400916455807L;
	private int page;
	private int size;
	private String sort;
	
	/**
	 * @return the sort
	 */
	public String getSort() {
		return sort;
	}
	/**
	 * @param sort the sort to set
	 */
	public void setSort(String sort) {
		this.sort = sort;
	}
	/**
	 * @return the page
	 */
	public int getPage() {
		return page;
	}
	/**
	 * @param page the page to set
	 */
	public void setPage(int page) {
		this.page = page;
	}
	/**
	 * @return the size
	 */
	public int getSize() {
		return size;
	}
	/**
	 * @param size the size to set
	 */
	public void setSize(int size) {
		this.size = size;
	}
	
	
}
