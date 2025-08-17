package com.vinplay.dichvuthe.service;

import com.vinplay.dichvuthe.response.RechargeResponse;

public interface RechargeService {

//    public byte checkRechargeIAP(String var1, int var2);

//    public RechargeIAPResponse rechargeIAP(String var1, String var2, String var3);

//    public String smsPlusRequest(Map<String, String[]> var1);

//    public RechargeApiOTPResponse sendRequestChargingOTP(String var1, String var2, int var3);
//
//    public RechargeApiOTPResponse sendConfirmChargingOTP(String var1, String var2, String var3);
//
//    public String receiveConfirmChargingOTP(Map<String, String[]> var1);

    public RechargeResponse rechargeByBankManual(String nickname, long amount, String bankAccountNumber);
}

