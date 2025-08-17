/**
 * 
 */
package com.archie.web.websocket.dto;

/**
 * @author Archie
 * @date Oct 3, 2020
 */
public class WsNotifyUserDTO {
	private double amount;
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

	/**
	 * @return the amount
	 */
	public double getAmount() {
		return amount;
	}

	/**
	 * @param amount the amount to set
	 */
	public void setAmount(double amount) {
		this.amount = amount;
	}

	/**
	 * @param amount
	 */
	public WsNotifyUserDTO(double amount, int cmd) {
		super();
		this.amount = amount;
		this.cmd = cmd;
	}

	/**
	 * 
	 */
	public WsNotifyUserDTO() {
		super();
	}

}
