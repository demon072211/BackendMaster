/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.dal.service.impl.RechargeBySmsPlus9029ServiceImpl
 *  com.vinplay.vbee.common.cp.BaseProcessor
 *  com.vinplay.vbee.common.cp.Param
 *  com.vinplay.vbee.common.response.recharge.ExportDataRechargeBySmsPlusResponse
 *  javax.servlet.http.HttpServletRequest
 */
package com.vinplay.api.backend.processors.doisoat;

import com.vinplay.dal.service.impl.RechargeBySmsPlus9029ServiceImpl;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.response.recharge.ExportDataRechargeBySmsPlusResponse;
import java.util.List;
import javax.servlet.http.HttpServletRequest;

public class ExportDataRechargeBySmsPlusProcessor
implements BaseProcessor<HttpServletRequest, String> {
    public String execute(Param<HttpServletRequest> param) {
        ExportDataRechargeBySmsPlusResponse response = new ExportDataRechargeBySmsPlusResponse(false, "1001");
        HttpServletRequest request = (HttpServletRequest)param.get();
        String timeStart = request.getParameter("ts");
        String timeEnd = request.getParameter("te");
        String amount = request.getParameter("am");
        String code = request.getParameter("co");
        RechargeBySmsPlus9029ServiceImpl service = new RechargeBySmsPlus9029ServiceImpl();
        List trans = service.exportDataRechargeBySmsPlus(timeStart, timeEnd, amount, code);
        response.setSuccess(true);
        response.setErrorCode("0");
        response.setTransactions(trans);
        return response.toJson();
    }
}

