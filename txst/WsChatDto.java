/**
 * 
 */
package com.archie.service.dto;

import java.io.Serializable;

import com.archie.entity.Chatbox;

/**
 * @author Archie
 * @date Oct 17, 2020
 */
public class WsChatDto implements Serializable {
	/**
	 * 
	 */
	private static final long serialVersionUID = -211350201077935735L;
	private long id;
	private String u;
	private String m;
	private String dt;
	private int cmd;
	
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
	 * @return the u
	 */
	public String getU() {
		return u;
	}

	/**
	 * @param u the u to set
	 */
	public void setU(String u) {
		this.u = u;
	}

	/**
	 * @return the m
	 */
	public String getM() {
		return m;
	}

	/**
	 * @param m the m to set
	 */
	public void setM(String m) {
		this.m = m;
	}

	/**
	 * @return the dt
	 */
	public String getDt() {
		return dt;
	}

	/**
	 * @param dt the dt to set
	 */
	public void setDt(String dt) {
		this.dt = dt;
	}

	/**
	 * @param u
	 * @param m
	 * @param dt
	 */
	public WsChatDto(String u, String m, String dt) {
		this.u = u;
		this.m = m;
		this.dt = dt;
	}
	
	public WsChatDto(String u, String m) {
		this.u = u;
		this.m = m;
	}

	/**
	 * 
	 */
	public WsChatDto() {
	}

	/**
	 * @param u
	 * @param m
	 * @param dt
	 * @param cmd
	 */
	public WsChatDto(Chatbox c) {
		this.u = c.getLoginname();
		this.m = c.getMessage();
		this.dt = c.getCreated();
		this.id=c.getId();
	}

	@Override
	public String toString() {
		return "WsChatDto [id=" + id + ", u=" + u + ", m=" + m + ", dt=" + dt + ", cmd=" + cmd + "]";
	}

}
