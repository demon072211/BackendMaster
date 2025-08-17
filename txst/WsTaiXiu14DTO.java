/**
 * 
 */
package com.archie.web.websocket.dto;

/**
 * @author Archie
 * @date Oct 2, 2020
 */
public class WsTaiXiu14DTO {
	private int cmd;
	private int cd;
	private long id;
	private int st;

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
	 * @return the cd
	 */
	public int getCd() {
		return cd;
	}

	/**
	 * @param cd the cd to set
	 */
	public void setCd(int cd) {
		this.cd = cd;
	}

	/**
	 * @return the id
	 */
	public long getId() {
		return id;
	}

	/**
	 * @param id the id to set
	 */
	public void setId(long id) {
		this.id = id;
	}

	/**
	 * @return the st
	 */
	public int getSt() {
		return st;
	}

	/**
	 * @param st the st to set
	 */
	public void setSt(int st) {
		this.st = st;
	}

	/**
	 * @param cmd
	 * @param cd
	 * @param id
	 * @param st
	 */
	public WsTaiXiu14DTO(int cd, long id, int st ,int cmd) {
		super();
		this.cmd = cmd;
		this.cd = 68 - cd;
		this.id = id;
		this.st = st;
	}

	/**
	 * 
	 */
	public WsTaiXiu14DTO() {
		super();
	}

}
