/**
 * 
 */
package com.archie.service.dto;

import java.io.Serializable;
import java.util.List;

/**
 * @author Archie
 * @date Nov 6, 2020
 */
@SuppressWarnings("serial")
public class TKTaiXiuDTO implements Serializable{
	
	private long id;
	private String result;
	List<TKPhienDTO> lstData;

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
	 * @return the lstData
	 */
	public List<TKPhienDTO> getLstData() {
		return lstData;
	}

	/**
	 * @param lstData the lstData to set
	 */
	public void setLstData(List<TKPhienDTO> lstData) {
		this.lstData = lstData;
	}

	/**
	 * @param id
	 * @param result
	 * @param lstData
	 */
	public TKTaiXiuDTO(long id, String result, List<TKPhienDTO> lstData) {
		super();
		this.id = id;
		this.result = result;
		this.lstData = lstData;
	}

	/**
	 * 
	 */
	public TKTaiXiuDTO() {
		super();
	}

	@Override
	public String toString() {
		return "TKTaiXiuDTO [id=" + id + ", result=" + result + ", lstData=" + lstData + "]";
	}

}
