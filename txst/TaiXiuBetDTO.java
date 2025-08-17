/**
 * 
 */
package com.archie.service.dto;

import java.io.Serializable;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.NotNull;

import com.archie.entity.TaixiuRecord;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.ObjectWriter;
import com.fasterxml.jackson.databind.SerializationFeature;

/**
 * @author Archie
 * @date Sep 18, 2020
 */
public class TaiXiuBetDTO implements Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = -4578940795750994568L;

	@NotNull
	private Long taixiuId;
	
	@NotBlank
	private String loginname;//nick_name

	@NotNull
	private Long betamount;
	
	@NotNull
	private Integer typed;
	
	private long refundamount;

	private String ip;

	private String time;

	private int userType;
	
	private int status;
	
	private long id;
	
	private String result;
	
	private int betfrom;
	
	private String username;
	
	public String getUsername() {
		return username;
	}


	public void setUsername(String username) {
		this.username = username;
	}


	/**
	 * @return the betfrom
	 */
	public int getBetfrom() {
		return betfrom;
	}


	/**
	 * @param betfrom the betfrom to set
	 */
	public void setBetfrom(int betfrom) {
		this.betfrom = betfrom;
	}


	/**
	 * @return the result
	 */
	public String getResult() {
		return result;
	}
	

	/**
	 * @return the refundamount
	 */
	public long getRefundamount() {
		return refundamount;
	}

	/**
	 * @param refundamount the refundamount to set
	 */
	public void setRefundamount(long refundamount) {
		this.refundamount = refundamount;
	}



	/**
	 * @param result the result to set
	 */
	public void setResult(String result) {
		this.result = result;
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
	 * @return the status
	 */
	public int getStatus() {
		return status;
	}

	/**
	 * @param status the status to set
	 */
	public void setStatus(int status) {
		this.status = status;
	}

	/**
	 * @return the userType
	 */
	public int getUserType() {
		return userType;
	}

	/**
	 * @param userType the userType to set
	 */
	public void setUserType(int userType) {
		this.userType = userType;
	}

	/**
	 * @return the time
	 */
	public String getTime() {
		return time;
	}

	/**
	 * @param time the time to set
	 */
	public void setTime(String time) {
		this.time = time;
	}

	/**
	 * @return the ip
	 */
	public String getIp() {
		return ip;
	}

	/**
	 * @param ip the ip to set
	 */
	public void setIp(String ip) {
		this.ip = ip;
	}

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
	 * 
	 */
	public TaiXiuBetDTO() {
		super();
	}


	public TaiXiuBetDTO(Long taixiuId, String loginname, Long betamount, Integer typed, int userType) {
		super();
		this.taixiuId = taixiuId;
		this.loginname = loginname;
		this.betamount = betamount;
		this.typed = typed;
		this.userType =userType;
	}
	

	/**
	 * @param taixiuId
	 * @param loginname
	 * @param betamount
	 * @param typed
	 * @param ip
	 * @param time
	 * @param userType
	 * @param wid
	 * @param status
	 * @param id
	 * @param result
	 */
	public TaiXiuBetDTO(TaixiuRecord tx ,String time) {
		super();
		this.taixiuId = tx.getTaixiuId();
		this.loginname = tx.getLoginname();
		this.betamount = tx.getBetamount();
		this.typed = tx.getTyped();
		this.userType = tx.getUserType();
		this.status = tx.getStatus();
		this.id = tx.getId();
		this.time = time;
	}

	public String toString() {
		ObjectWriter ow = new ObjectMapper().writer();
		ow.with(SerializationFeature.INDENT_OUTPUT);
		try {
			String json = ow.writeValueAsString(this);
			return json;
		} catch (Exception e) {
			return null;
		}
	}
	
	
	
	/**
	 * 
	 */
	public TaiXiuBetDTO(TaiXiuBetDTO dto) {
		this.taixiuId = dto.getTaixiuId();
		this.loginname = dto.getLoginname();
		this.betamount = dto.getBetamount();
		this.typed = dto.getTyped();
		this.refundamount = dto.getRefundamount();
		this.time = dto.getTime();
		this.userType = dto.getUserType();
		this.status = dto.getStatus();
		this.id = dto.getId();
		this.result = dto.getResult();
		this.username = dto.getUsername();
	}
	

	@Override
	public boolean equals(Object o) {
		if (this == o) {
			return true;
		}
		if (!(o instanceof TaiXiuBetDTO)) {
			return false;
		}
		return loginname != null && loginname.equalsIgnoreCase(((TaiXiuBetDTO) o).loginname);
	}

}
