/**
 * 
 */
package com.archie.service.dto;

/**
 * @author Archie
 * @date Oct 11, 2020
 */
public class TaiXiuRefundNotifyDTO {
	private String loginname;
	private int typed;
	private double amount;

	/**
	 * @return the loginname
	 */
	public String getLoginname() {
		return loginname;
	}

	/**
	 * @param loginname the loginname to set
	 */
	public void setLoginname(String loginname) {
		this.loginname = loginname;
	}

	/**
	 * @return the typed
	 */
	public int getTyped() {
		return typed;
	}

	/**
	 * @param typed the typed to set
	 */
	public void setTyped(int typed) {
		this.typed = typed;
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
	 * @param loginname
	 * @param typed
	 * @param amount
	 */
	public TaiXiuRefundNotifyDTO(String loginname, int typed, double amount) {
		super();
		this.loginname = loginname;
		this.typed = typed;
		this.amount = amount;
	}

	/**
	 * 
	 */
	public TaiXiuRefundNotifyDTO() {
		super();
	}

	@Override
	public boolean equals(Object o) {
		if (this == o) {
			return true;
		}
		if (!(o instanceof TaiXiuRefundNotifyDTO)) {
			return false;
		}
		return loginname != null && loginname.equals(((TaiXiuRefundNotifyDTO) o).loginname);
	}
	
	/**
	 * @param loginname
	 * @param typed
	 * @param amount
	 */
	public TaiXiuRefundNotifyDTO(TaiXiuBetDTO obj) {
		super();
		this.loginname = obj.getLoginname();
		this.typed = obj.getTyped();
		this.amount = obj.getBetamount();
	}

	@Override
	public String toString() {
		return "TaiXiuRefundNotifyDTO [loginname=" + loginname + ", typed=" + typed + ", amount=" + amount + "]";
	}


}
