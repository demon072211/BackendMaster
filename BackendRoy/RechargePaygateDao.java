/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.vbee.common.exceptions.KeyNotFoundException
 *  com.vinplay.vbee.common.messages.dvt.RechargeByBankMessage
 *  com.vinplay.vbee.common.messages.dvt.RechargeByCardMessage
 */
package com.vinplay.payment.dao;

import com.vinplay.payment.entities.DepositPaygateModel;
import com.vinplay.payment.entities.DepositPaygateReponse;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public interface RechargePaygateDao {
	public boolean isExistDeposit(String nickName);

	/**
	 * Check exist transaction is pending by nickname and provider name
	 * 
	 * @param nickname
	 * @param providerName
	 * @return true: exist; false: not exist
	 */
	public boolean CheckPending(String nickname, String providerName);

	/**
	 * Get detail transaction by id
	 * 
	 * @param Id: Id of transaction
	 * @return DepositPaygateModel
	 */
	public DepositPaygateModel GetById(String Id);

	/**
	 * Add transaction
	 * 
	 * @param depositPayWellModel
	 * @return orderId
	 */
	public long Add(DepositPaygateModel depositPayWellModel);
	
	public long topupByCash(DepositPaygateModel depositPayWellModel);

	public Boolean Update(DepositPaygateModel depositPayWellModel);
	
	public Boolean delete(String id);
	
	/**
	 * Update status all record not callback from paygate clickpay
	 * 
	 * @param minutes
	 * @return
	 */
	public boolean updatePendingStatusToFailedAfterMinus(int minutes, String provider);

	/**
	 * Update status transaction
	 * 
	 * @param OrderId:     Order id of transaction (not Id)
	 * @param cartId:      Id reference
	 * @param status:      Status of transaction will be change
	 * @param userApprove: User name change status
	 * @return true: success; false: failed
	 */
	public Boolean UpdateStatus(String orderId, String cartId, int status, String userApprove);

	/**
	 * Update status transaction
	 * 
	 * @param OrderId:     Order id of transaction (not Id)
	 * @param status:      Status of transaction will be change
	 * @param userApprove: User name change status
	 * @return true: success; false: failed
	 */
	public Boolean UpdateStatus(String orderId, int status, String userApprove);
	
	public Boolean UpdateStatusById(String id, int status, String userApprove);

	/**
	 * Update request time of transaction
	 * 
	 * @param OrderId:       Order id of transaction (not Id)
	 * @param reRequestTime: Time request
	 * @param userApprove:   User name change status
	 * @param userApprove:   User name change status
	 * @return true: success; false: failed
	 */
	public Boolean UpdateRequestTime(String orderId, String reRequestTime, String userApprove);

	/**
	 * Update amount, amount fee of transaction
	 * 
	 * @param OrderId:     Order id of transaction (not Id)
	 * @param amount:      Amount of transaction
	 * @param amountFee:   Amount fee of transaction
	 * @param userApprove: User name change status
	 * @return true: success; false: failed
	 */
	public Boolean UpdateAmount(String orderId, long amount, long amountFee, String userApprove);

	/**
	 * Get detail transaction by reference Id
	 * 
	 * @param cartId: Reference Id of transaction
	 * @return DepositPaygateModel
	 */
	public DepositPaygateModel GetByReferenceId(String cartId);

	/**
	 * Get detail transaction by reference Id
	 * 
	 * @param orderId: Order id of transaction (not Id)
	 * @return DepositPaygateModel
	 */
	public DepositPaygateModel GetByOrderId(String orderId);

	/**
	 * Search transaction
	 * 
	 * @param depositPayWellModel: Contain value of fields want to search
	 * @param status
	 * @param page
	 * @param maxItem
	 * @param fromTime
	 * @param endTime
	 * @return DepositPaygateModel
	 */
	public DepositPaygateReponse Find(DepositPaygateModel depositPayWellModel, int page, int maxItem, String fromTime,
			String endTime);

	/**
	 * Search transaction
	 * 
	 * @param nickname
	 * @param status
	 * @param page
	 * @param maxItem
	 * @param fromTime
	 * @param endTime
	 * @param providerName (If want get all, set value is empty)
	 * @return DepositPaygateModel
	 */
	public DepositPaygateReponse Find(String nickname, int status, int page, int maxItem, String fromTime,
			String endTime, String providerName);

	public ArrayList<Object> find(HashMap<String, Object> condition, int page, int maxItem) throws Exception;

	public long count(HashMap<String, Object> condition);

	public Long[] statistic(HashMap<String, Object> condition);

	/**
	 * Search transaction
	 * 
	 * @param nickname
	 * @param orderId
	 * @param transactionId
	 * @param status
	 * @param page
	 * @param maxItem
	 * @param fromTime
	 * @param endTime
	 * @param providerName  (If want get all, set value is empty)
	 * @return DepositPaygateModel
	 */
	public DepositPaygateReponse Find(String nickname, int status, int page, int maxItem, String fromTime,
			String endTime, String providerName, String orderId, String transactionId, String bankName,
			Double fromAmount, Double toAmount);

	/**
	 * Search transaction only display for user play
	 * 
	 * @param nickname
	 * @param status
	 * @param page
	 * @param maxItem
	 * @param fromTime
	 * @param endTime
	 * @param providerName (If want get all, set value is empty)
	 * @return DepositPaygateModel
	 */
	public Map<String, Object> FindTransaction(String nickname, int status, int page, int maxItem, String fromTime,
			String endTime, String providerName);

	public Map<String, Object> FindTransaction(String nickname, String agentCode, int status, int page, int maxItem,
			String fromTime, String endTime, String providerName);
}
