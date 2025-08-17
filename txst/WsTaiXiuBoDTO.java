/**
 * 
 */
package com.archie.web.websocket.dto;

import java.io.Serializable;

/**
 * @author Archie
 * @date Sep 22, 2020
 */
public class WsTaiXiuBoDTO implements Serializable{
	/**
	 * 
	 */
	private static final long serialVersionUID = 8386714649066031146L;
	private int cd;
	private long ut;
	private long ux;

	private String at;
	private String ax;

	private long id;
	
	private String rs;
	
	//private int st;
	//private long am;
	
	private int cmd;
	
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
//
//	/**
//	 * @return the am
//	 */
//	public long getAm() {
//		return am;
//	}
//
//	/**
//	 * @param am the am to set
//	 */
//	public void setAm(long am) {
//		this.am = am;
//	}

	/**
	 * @return the cd
	 */
	public int getCd() {
		return cd;
	}

	/**
	 * @return the rs
	 */
	public String getRs() {
		return rs;
	}

	/**
	 * @param rs the rs to set
	 */
	public void setRs(String rs) {
		this.rs = rs;
	}

	/**
	 * @param cd the cd to set
	 */
	public void setCd(int cd) {
		this.cd = cd;
	}

	/**
	 * @return the ut
	 */
	public long getUt() {
		return ut;
	}

	/**
	 * @param ut the ut to set
	 */
	public void setUt(long ut) {
		this.ut = ut;
	}

	/**
	 * @return the ux
	 */
	public long getUx() {
		return ux;
	}

	/**
	 * @param ux the ux to set
	 */
	public void setUx(long ux) {
		this.ux = ux;
	}

	/**
	 * @return the at
	 */
	public String getAt() {
		return at;
	}

	/**
	 * @param at the at to set
	 */
	public void setAt(String at) {
		this.at = at;
	}

	/**
	 * @return the ax
	 */
	public String getAx() {
		return ax;
	}

	/**
	 * @param ax the ax to set
	 */
	public void setAx(String ax) {
		this.ax = ax;
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
	 * @param cd
	 * @param ut
	 * @param ux
	 * @param at
	 * @param ax
	 * @param id
	 * @param st
	 */
	public WsTaiXiuBoDTO(int cd, long ut, long ux, String at, String ax, long id, String result) {
		super();
		this.rs = result;
		this.cd = 50 - cd;
		this.ut = ut;
		this.ux = ux;
		this.at = at;
		this.ax = ax;
		this.id = id;
	}
	
	/**
	 * 
	 */
	public WsTaiXiuBoDTO() {
		super();
	}

}
