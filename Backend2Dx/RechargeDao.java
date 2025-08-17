/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.vbee.common.exceptions.KeyNotFoundException
 *  com.vinplay.vbee.common.messages.dvt.RechargeByBankMessage
 *  com.vinplay.vbee.common.messages.dvt.RechargeByCardMessage
 */
package com.vinplay.dichvuthe.dao;

import com.vinplay.dichvuthe.entities.NganLuongModel;
import com.vinplay.dichvuthe.response.LogApiOtpConfirmResponse;
import com.vinplay.dichvuthe.response.LogApiOtpRequestResponse;
import com.vinplay.dichvuthe.response.LogSMS8x98Response;
import com.vinplay.dichvuthe.response.LogSMSPlusCheckMoResponse;
import com.vinplay.dichvuthe.response.LogSMSPlusResponse;
import com.vinplay.iap.lib.Purchase;
import com.vinplay.usercore.response.LogRechargeBankNLResponse;
import com.vinplay.usercore.response.LogRechargeBankNapasResponse;
import com.vinplay.vbee.common.exceptions.KeyNotFoundException;
import com.vinplay.vbee.common.messages.dvt.RechargeByBankMessage;
import com.vinplay.vbee.common.messages.dvt.RechargeByCardMessage;
import org.bson.Document;

import java.sql.SQLException;
import java.text.ParseException;
import java.util.Calendar;
import java.util.List;

public interface RechargeDao {
    public List<RechargeByCardMessage> getListCardPending(String var1, String var2) throws NumberFormatException, KeyNotFoundException;

    public List<RechargeByCardMessage> getListCardPending() throws NumberFormatException, KeyNotFoundException;

    public boolean updateCard(String var1, int var2, int var3, String var4, int var5);

    public RechargeByBankMessage getRechargeByBank(String var1);

    public boolean logRechargeByBank(RechargeByBankMessage var1) throws Exception;

    public boolean updateRechargeByBank(String var1, String var2, String var3, String var4, String var5, String var6) throws Exception;

    public boolean insertLogRechargeByBankError(String var1, String var2, String var3, String var4, String var5, String var6, String var7, String var8, String var9, String var10, String var11, String var12, String var13, String var14) throws Exception;

    public boolean logRechargeByNL(String var1, String var2, String var3, String var4, String var5, int var6, int var7, int var8, int var9, String var10, String var11, String var12, String var13, String var14, String var15, String var16, String var17);

    public boolean updateRechargeByNL(String var1, String var2, String var3);

    public boolean logRechargeByNLError(String var1, String var2, String var3);

    public NganLuongModel getNLTrans(String var1);

    public LogRechargeBankNapasResponse getLogNapas(String var1, String var2, String var3, String var4, String var5, String var6, String var7, String var8, int var9);

    public LogRechargeBankNLResponse getLogNL(String var1, String var2, String var3, String var4, String var5, String var6, String var7, String var8, int var9);

    public boolean saveLogIAP(Purchase var1, String var2, int var3, int var4, String var5);

    public boolean checkOrderId(String var1);

    public long getTotalRechargeIapInday(String var1, Calendar var2) throws ParseException;

    public boolean checkRequestIdSMS(String var1);

    public boolean checkRequestIdSMSPlus(String var1);

    public boolean saveLogRechargeBySMS(String var1, String var2, String var3, int var4, String var5, String var6, String var7, int var8, String var9, int var10);

    public boolean saveLogRechargeBySMSPlus(String var1, String var2, String var3, int var4, String var5, String var6, String var7, String var8, String var9, int var10, String var11, int var12);

    public boolean saveLogRechargeBySMSPlusCheckMO(String var1, String var2, int var3, String var4, int var5, String var6);

    public LogSMS8x98Response getLogSMS8x98(String var1, String var2, int var3, String var4, String var5, int var6, String var7, String var8, int var9);

    public LogSMSPlusResponse getLogSMSPlus(String var1, String var2, int var3, String var4, int var5, String var6, String var7, int var8);

    public boolean saveLogRequestApiOTP(String var1, String var2, int var3, String var4, String var5, String var6, String var7, int var8, String var9);

    public boolean saveLogConfirmApiOTP(String var1, String var2, int var3, String var4, String var5, String var6, String var7, String var8, int var9, String var10, int var11);

    public LogApiOtpConfirmResponse getApiOtpConfirm(String var1, String var2, int var3, String var4, int var5, String var6, String var7, int var8);

    public LogApiOtpRequestResponse getApiOtpRequest(String var1, String var2, int var3, String var4, int var5, String var6, String var7, int var8);

    public RechargeByCardMessage getPendingCardByReferenceId(String var1);

    public boolean insertLogUpdateCardPending(String var1, String var2, String var3, String var4, String var5, String var6, String var7, String var8, String var9, String var10, String var11, String var12) throws Exception;

    public boolean updateRechargeByCard(String transId, String responseCode, String description,String amountReceive) throws Exception ;

    public boolean isAgent(String var1) throws SQLException;

    public List<String> getListSmsIdNearly();

    public List<String> getListSmsPlusIdNearly();

    public LogSMSPlusCheckMoResponse getLogSMSPlusCheckMO(String var1, int var2, int var3, String var4, String var5, int var6);

    public boolean updateSMS(String var1, int var2, String var3, int var4);

    public Document getRechargeByGachthe(String transId);

    public boolean UpdateGachtheTransctions(String transId,int code, String message);

    public Document getRechargeByGachthe(String nickname,String serial,String pin);

    public boolean saveLogRechargeByGachThe(String nickname, String serial, String pin, long amount, String requestId, String requestTime, int code, String des, long money, String provider, String platform,long currentMoney,long addMoney,int userId, String username, String partner, String client);

}

