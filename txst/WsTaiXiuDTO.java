/**
 * 
 */
package com.archie.web.websocket.dto;

import java.util.Arrays;

import com.archie.config.Constants;

/**
 * @author Archie
 * @date Sep 22, 2020
 */
public class WsTaiXiuDTO {
	private int cd;
	private long ut;
	private long ux;

	private long at;
	private long ax;

	private long id;
	
	private int[] rs;
	
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
	public int[] getRs() {
		return rs;
	}

	/**
	 * @param rs the rs to set
	 */
	public void setRs(int[] rs) {
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
	public long getAt() {
		return at;
	}

	/**
	 * @param at the at to set
	 */
	public void setAt(long at) {
		this.at = at;
	}

	/**
	 * @return the ax
	 */
	public long getAx() {
		return ax;
	}

	/**
	 * @param ax the ax to set
	 */
	public void setAx(long ax) {
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
	 */
	
	public WsTaiXiuDTO(int cd, long ut, long ux, long at, long ax, long id, int[] rs, int cmd) {
		super();
		this.cmd=cmd;
		if (cmd == Constants.CMD_5S) {
			this.cd = 23 - cd;
		} else {
			this.cd = 18 - cd;
		}
		
		this.ut = ut;
		this.ux = ux;
		this.at = at;
		this.ax = ax;
		this.id = id;
		this.rs = rs;
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
	public WsTaiXiuDTO(int cd, long ut, long ux, long at, long ax, long id, int cmd) {
		super();
		this.cmd = cmd;
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
	public WsTaiXiuDTO() {
		super();
	}

	@Override
	public String toString() {
		return "WsTaiXiuDTO [cd=" + cd + ", ut=" + ut + ", ux=" + ux + ", at=" + at + ", ax=" + ax + ", id=" + id
				+ ", rs=" + Arrays.toString(rs) + ", cmd=" + cmd + "]";
	}

}
