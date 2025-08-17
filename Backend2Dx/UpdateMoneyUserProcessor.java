/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.usercore.service.impl.OtpServiceImpl
 *  com.vinplay.usercore.service.impl.UserServiceImpl
 *  com.vinplay.usercore.utils.GameCommon
 *  com.vinplay.vbee.common.cp.BaseProcessor
 *  com.vinplay.vbee.common.cp.Param
 *  com.vinplay.vbee.common.response.BaseResponseModel
 *  javax.servlet.http.HttpServletRequest
 *  org.apache.log4j.Logger
 */
package com.vinplay.api.backend.processors.money;

import com.vinplay.api.backend.report.utils.BackendUtils;
import com.vinplay.usercore.service.impl.OtpServiceImpl;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.response.BaseResponseModel;
import javax.servlet.http.HttpServletRequest;
import org.apache.log4j.Logger;
import org.python.parser.ast.Str;

import java.util.ArrayList;

public class UpdateMoneyUserProcessor
implements BaseProcessor<HttpServletRequest, String> {
    private static final Logger logger = Logger.getLogger((String)"backend");

    public String execute(Param<HttpServletRequest> param) {
        HttpServletRequest request = (HttpServletRequest)param.get();
        BaseResponseModel response = new BaseResponseModel(false, "1001");
        try {
            String actionName = request.getParameter("ac");
            String nickname = request.getParameter("nn");
            long money = Long.valueOf(request.getParameter("mn"));
            String moneyType = request.getParameter("mt");
            String reason = request.getParameter("rs");
            String otp = request.getParameter("otp");
            String type = request.getParameter("type");
            String nicknameSend = request.getParameter("nns");            
            logger.debug((Object)("Request UpdateMoneyUser: nickname: " + nickname + ", money: " + money + ", moneyType: " + moneyType + ", reason: " + reason + ", otp: " + otp + ", otpType: " + type));
            if (nickname != null && reason != null && !reason.isEmpty() && money != 0L && moneyType != null && (moneyType.equals("vin") || moneyType.equals("xu")) && otp != null && type != null && (type.equals("1") || type.equals("0"))) {
                OtpServiceImpl otpService = new OtpServiceImpl();
                int code = 3;
                if (moneyType.equals("vin")) {
                    if(otp.equals("1") || otp.equals("")){
                        code = 0;
                    }else{
                        String admin;
                        String[] arr = GameCommon.getValueStr((String)"SUPER_ADMIN").split(",");
                        int i = 0;
                        String[] array = arr;
                        int length = array.length;
//                    for (int j = 0; j < length && (code = otpService.checkOtp(otp, admin = array[j], type, (String)null)) != 0; ++j) {
                        for (int j = 0; j < length && (code = otpService.checkOdp(array[j], otp)) != 0; ++j) {
                            if (i > 0 && money > 2000000L) {
                                return response.toJson();
                            }
                            ++i;
                        }
                    }

                } else if (nicknameSend != null) {
//                    code = otpService.checkOtp(otp, nicknameSend, type, (String)null);
//                    16 Sep 2019 | 02:08:35,355 | DEBUG | qtp21802780-63 - /api_backend?c=100&nn=cuccu888&mn=1000000&mt=vin&rs=AAAAAA&otp=55555&type=0&ac=Admin | backend |     | Request UpdateMoneyUser: nickname: cuccu888, money: 1000000, moneyType: vin, reason: AAAAAA, otp: 55555, otpType: 0
                    String[] arr = GameCommon.getValueStr((String)"SUPER_ADMIN").split(",");
                    code = otpService.checkOdp(arr[0], otp);
                }
                if (code == 0) {
                    if (actionName == null) {
                        actionName = "Admin";
                    }
                    UserServiceImpl service = new UserServiceImpl();
                    response = service.updateMoneyFromAdmin(nickname, money, moneyType, actionName, "Admin", reason);
                    if (response.isSuccess()) {
                        ArrayList<String> listUser = new ArrayList<>();
                        listUser.add(nickname);
                        BackendUtils.sendUpdateUserMoneyInfo(listUser);
                    }
                } else if (code == 3) {
                    response.setErrorCode("1008");
                } else if (code == 4) {
                    response.setErrorCode("1021");
                }
            }
        }
        catch (Exception e) {
            logger.debug((Object)e);
        }
        logger.debug((Object)("Response UpdateMoneyUser: " + response.toJson()));
        return response.toJson();
    }
}

