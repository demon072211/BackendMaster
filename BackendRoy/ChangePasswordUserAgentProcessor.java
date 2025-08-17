package com.vinplay.api.backend.processors.agent;

import com.vinplay.dal.dao.AgentDAO;
import com.vinplay.dal.dao.impl.AgentDAOImpl;
import com.vinplay.payment.utils.Constant;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.response.BaseResponse;
import javax.servlet.http.HttpServletRequest;

public class ChangePasswordUserAgentProcessor implements BaseProcessor<HttpServletRequest, String> {
    @Override
    public String execute(Param<HttpServletRequest> param) {
        HttpServletRequest request = param.get();
        String serPath = request.getServletPath();
        if(serPath == null || serPath.trim().isEmpty() || serPath != "/api_agent"){
            return BaseResponse.error(Constant.ERROR_PARAM, "Not allow access this api");
        }
        
        String nick_name = request.getParameter("nn");
        String old_password = request.getParameter("op");
        String new_password = request.getParameter("np");
        if(nick_name == null || nick_name.trim().isEmpty()) {
            return BaseResponse.error("-1", "Nickname can not empty");
        }

        AgentDAO dao = new AgentDAOImpl();
        try {
            String status = dao.changePasswordUserAgent(nick_name, old_password, new_password);
            switch (status) {
                case "success":
                    return BaseResponse.success(null, 1);
                case "not_found":
                    return BaseResponse.error("-1", "Can not found agent");
                case "not_same":
                    return BaseResponse.error("-1", "Old password not match");
                default:
                    return BaseResponse.error("-1", status);
            }
        }
        catch (Exception e) {
            return BaseResponse.error("-1", e.getMessage());
        }
    }
}