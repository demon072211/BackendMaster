/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.dal.entities.taixiu.TransactionTaiXiu
 *  com.vinplay.dal.service.impl.TaiXiuServiceImpl
 *  com.vinplay.vbee.common.cp.BaseProcessor
 *  com.vinplay.vbee.common.cp.Param
 *  javax.servlet.http.HttpServletRequest
 */
package com.vinplay.api.processors.minigame;

import com.vinplay.api.processors.minigame.response.LichSuGiaoDichTXResponse;
import com.vinplay.dal.entities.taixiu.TransactionTaiXiu;
import com.vinplay.dal.service.impl.OverUnderServiceImpl;
import com.vinplay.dal.service.impl.TaiXiuServiceImpl;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import java.sql.SQLException;
import java.util.List;
import javax.servlet.http.HttpServletRequest;

public class LichSuGiaoDichTXProcessor
implements BaseProcessor<HttpServletRequest, String> {
    public String execute(Param<HttpServletRequest> param) {
        LichSuGiaoDichTXResponse response = new LichSuGiaoDichTXResponse(false, "1001");
        HttpServletRequest request = (HttpServletRequest)param.get();
        String username = request.getParameter("un");
        int page = Integer.parseInt(request.getParameter("p"));
        if (page < 0) {
            return response.toJson();
        }
        int moneyType = Integer.parseInt(request.getParameter("mt"));

        String txType = request.getParameter("txType");
        if(txType == null || txType.equals("1")){
            TaiXiuServiceImpl service = new TaiXiuServiceImpl();
            try {
                List trans = service.getLichSuGiaoDich(username, page, moneyType);
                int totalPages = 10;
                response.setTotalPages(10);
                response.setTransactions(trans);
                response.setSuccess(true);
                response.setErrorCode("0");
            }
            catch (SQLException e) {
                e.printStackTrace();
            }
        }
        else{
            OverUnderServiceImpl service = new OverUnderServiceImpl();
            try {
                List trans = service.getLichSuGiaoDich(username, page, moneyType);
                int totalPages = 10;
                response.setTotalPages(10);
                response.setTransactions(trans);
                response.setSuccess(true);
                response.setErrorCode("0");
            }
            catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return response.toJson();
    }
}

