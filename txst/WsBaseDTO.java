/**
 * 
 */
package com.archie.service.dto;

import java.io.Serializable;

/**
 * @author Archie
 * @date Nov 16, 2020
 */
public class WsBaseDTO<T> implements Serializable {
	private int cmd;
	private T rs;

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
	 * @return the rs
	 */
	public T getRs() {
		return rs;
	}

	/**
	 * @param rs the rs to set
	 */
	public void setRs(T rs) {
		this.rs = rs;
	}

	/**
	 * 
	 */
	public WsBaseDTO() {
	}
	

	/**
	 * @param cmd
	 * @param rs
	 */
	public WsBaseDTO(int cmd, T rs) {
		this.cmd = cmd;
		this.rs = rs;
	}

	@Override
	public String toString() {
		return "WsBaseDTO [cmd=" + cmd + ", rs=" + rs + "]";
	}

}
