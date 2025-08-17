package com.archie.service.dto;

import java.io.Serializable;
import java.time.LocalDateTime;

/**
 * A TaixiuRecord.
 */
@SuppressWarnings("serial")
public class TKPhienDTO implements Serializable {

	private Long taixiuId;

	private String loginname;

	private Long betamount;

	private Integer typed;

	private Integer status;

	private LocalDateTime bettime;

	private String result;

	private Long refundamount;

	/**
	 * @return the taixiuId
	 */
	public Long getTaixiuId() {
		return taixiuId;
	}

	/**
	 * @param taixiuId the taixiuId to set
	 */
	public void setTaixiuId(Long taixiuId) {
		this.taixiuId = taixiuId;
	}

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
	 * @return the betamount
	 */
	public Long getBetamount() {
		return betamount;
	}

	/**
	 * @param betamount the betamount to set
	 */
	public void setBetamount(Long betamount) {
		this.betamount = betamount;
	}

	/**
	 * @return the typed
	 */
	public Integer getTyped() {
		return typed;
	}

	/**
	 * @param typed the typed to set
	 */
	public void setTyped(Integer typed) {
		this.typed = typed;
	}

	/**
	 * @return the status
	 */
	public Integer getStatus() {
		return status;
	}

	/**
	 * @param status the status to set
	 */
	public void setStatus(Integer status) {
		this.status = status;
	}

	/**
	 * @return the bettime
	 */
	public LocalDateTime getBettime() {
		return bettime;
	}

	/**
	 * @param bettime the bettime to set
	 */
	public void setBettime(LocalDateTime bettime) {
		this.bettime = bettime;
	}

	/**
	 * @return the result
	 */
	public String getResult() {
		return result;
	}

	/**
	 * @param result the result to set
	 */
	public void setResult(String result) {
		this.result = result;
	}

	/**
	 * @return the refundamount
	 */
	public Long getRefundamount() {
		return refundamount;
	}

	/**
	 * @param refundamount the refundamount to set
	 */
	public void setRefundamount(Long refundamount) {
		this.refundamount = refundamount;
	}

	/**
	 * @param taixiuId
	 * @param loginname
	 * @param betamount
	 * @param typed
	 * @param status
	 * @param bettime
	 * @param result
	 * @param refundamount
	 */
	public TKPhienDTO(Long taixiuId, String loginname, Long betamount, Integer typed, Integer status, LocalDateTime bettime,
			String result, Long refundamount) {
		super();
		this.taixiuId = taixiuId;
		this.loginname = loginname;
		this.betamount = betamount;
		this.typed = typed;
		this.status = status;
		this.bettime = bettime;
		this.result = result;
		this.refundamount = refundamount;
	}

	/**
	 * 
	 */
	public TKPhienDTO() {
		super();
	}

	@Override
	public String toString() {
		return "TKPhienDTO [taixiuId=" + taixiuId + ", loginname=" + loginname + ", betamount=" + betamount + ", typed="
				+ typed + ", status=" + status + ", bettime=" + bettime + ", result=" + result + ", refundamount="
				+ refundamount + "]";
	}

}
