/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.vinplay.usercore.dao.impl.UserDaoImpl
 *  com.vinplay.usercore.service.impl.MarketingServiceImpl
 *  com.vinplay.usercore.service.impl.SecurityServiceImpl
 *  com.vinplay.usercore.service.impl.UserServiceImpl
 *  com.vinplay.usercore.utils.GameCommon
 *  com.vinplay.usercore.utils.UserMakertingUtil
 *  com.vinplay.vbee.common.cp.BaseProcessor
 *  com.vinplay.vbee.common.cp.Param
 *  com.vinplay.vbee.common.enums.StatusGames
 *  com.vinplay.vbee.common.messages.UserMarketingMessage
 *  com.vinplay.vbee.common.response.BaseResponseModel
 *  com.vinplay.vbee.common.utils.UserValidaton
 *  com.vinplay.vbee.common.utils.VinPlayUtils
 *  javax.servlet.http.HttpServletRequest
 *  org.apache.log4j.Logger
 */
package com.vinplay.api.processors;

import com.vinplay.api.utils.PortalUtils;
import com.vinplay.usercore.dao.impl.UserDaoImpl;
import com.vinplay.usercore.service.impl.MarketingServiceImpl;
import com.vinplay.usercore.service.impl.SecurityServiceImpl;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.usercore.utils.UserMakertingUtil;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.enums.StatusGames;
import com.vinplay.vbee.common.messages.UserMarketingMessage;
import com.vinplay.vbee.common.response.BaseResponseModel;
import com.vinplay.vbee.common.utils.UserValidaton;
import com.vinplay.vbee.common.utils.VinPlayUtils;
import java.sql.SQLException;
import javax.servlet.http.HttpServletRequest;
import org.apache.log4j.Logger;

public class QuickRegisterProcessor
implements BaseProcessor<HttpServletRequest, String> {
    private static final Logger logger = Logger.getLogger((String)"api");

    public String execute(Param<HttpServletRequest> param) {
        BaseResponseModel res;
        block10 : {
            HttpServletRequest request = (HttpServletRequest)param.get();
            String username = request.getParameter("un");
            String password = request.getParameter("pw");
            String captcha = request.getParameter("cp");
            String captchaId = request.getParameter("cid");
            String campaign = request.getParameter("utm_campaign");
            String medium = request.getParameter("utm_medium");
            String source = request.getParameter("utm_source");
            logger.debug((Object)("Request quickRegister: username: " + username + ", password: " + password));
            res = new BaseResponseModel(false, "1001");
            try {
                int statusGame = GameCommon.getValueInt((String)"STATUS_GAME");
                if (statusGame == StatusGames.MAINTAIN.getId() || statusGame == StatusGames.SANDBOX.getId()) {
                    res.setErrorCode("1114");
                    logger.debug((Object)("Response login: " + res.toJson()));
                    return res.toJson();
                }
                if (username == null || password == null || captcha == null || captchaId == null) break block10;
                if (PortalUtils.checkCaptcha(captcha, captchaId)) {
                    if (UserValidaton.validateUserName((String)username)) {
                        try {
                            UserServiceImpl userService = new UserServiceImpl();
                            res.setErrorCode(userService.insertUser(username, password));
                            if (!res.getErrorCode().equals("0")) break block10;
                            res.setSuccess(true);
                            try {
                                if (campaign != null && medium != null && source != null) {
                                    MarketingServiceImpl mktService = new MarketingServiceImpl();
                                    UserMarketingMessage message = new UserMarketingMessage(username, "", 0, VinPlayUtils.getCurrentDateMarketing(), campaign, medium, source);
                                    mktService.saveUserMarketing(message);
                                    UserMakertingUtil.newRegisterUser((String)campaign, (String)medium, (String)source);
                                }
                                UserDaoImpl dao = new UserDaoImpl();
                                int userId = dao.getIdByUsername(username);
                                SecurityServiceImpl sercuSer = new SecurityServiceImpl();
                                sercuSer.saveLoginInfo(userId, username, "", PortalUtils.getIpAddress(request), PortalUtils.getUserAgent(request), 0, "web");
                                break block10;
                            }
                            catch (Exception e) {
                                logger.debug((Object)e);
                            }
                        }
                        catch (SQLException e2) {
                            logger.debug((Object)e2);
                        }
                        break block10;
                    }
                    res.setErrorCode("101");
                    break block10;
                }
                res.setErrorCode("115");
            }
            catch (Exception e3) {
                e3.printStackTrace();
            }
        }
        logger.debug((Object)("Response quickRegister: " + res.toJson()));
        return res.toJson();
    }
}

