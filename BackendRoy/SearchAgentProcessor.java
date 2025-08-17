package com.vinplay.api.processors;

import com.vinplay.dal.dao.AgentDAO;
import com.vinplay.dal.dao.impl.AgentDAOImpl;
import com.vinplay.dal.entities.agent.UserAgentModel;
import com.vinplay.dal.utils.AgentUtils;
import com.vinplay.payment.utils.Constant;
import com.vinplay.usercore.service.UserService;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.models.UserModel;
import com.vinplay.vbee.common.response.BaseResponse;
import javax.servlet.http.HttpServletRequest;
import java.sql.SQLException;
import java.util.ArrayList;

public class SearchAgentProcessor implements BaseProcessor<HttpServletRequest, String> {
	@Override
	public String execute(Param<HttpServletRequest> param) {
		HttpServletRequest request = param.get();
		String keyword = request.getParameter("key");
		int page, maxItem;
		try {
			page = Integer.parseInt(request.getParameter("pg"));
		} catch (NumberFormatException e) {
			page = 1;
		}

		try {
			maxItem = Integer.parseInt(request.getParameter("mi"));
		} catch (NumberFormatException e) {
			maxItem = 1000;
		}
		
		String nickname = request.getParameter("nn");
		String accessToken = request.getParameter("at");
		UserService userService = new UserServiceImpl();
		boolean isToken = userService.isActiveToken(nickname, accessToken);
		if (!isToken) {
			return BaseResponse.error(Constant.ERROR_SESSION,
					"Your trading session is expired, please refesh page and login again.");
		}
		
		UserModel userModel = new UserModel(); 
		try {
			userModel = userService.getUserByNickName(nickname);
		} catch (SQLException e1) {
			userModel = null;
			e1.printStackTrace();
		}
		
		if(userModel == null)
			return BaseResponse.error(Constant.ERROR_SESSION,
					"Can not found user: " + nickname);

		AgentDAO dao = new AgentDAOImpl();
		UserAgentModel currentAgent = new UserAgentModel();
		try {
			currentAgent = dao.DetailUserAgentByCode(userModel.getReferralCode());
		} catch (SQLException e) {
			currentAgent = null;
		}
		
//		String levelStr = request.getParameter("lv");
//		int level = currentAgent == null ? -1 : currentAgent.getLevel() + 1;
//		try {
//			level = Integer.parseInt(levelStr);
//		} catch (Exception e) { }
		
		try {
			if(currentAgent == null)
				return AgentUtils.searchChilds(-1, keyword, -1, page, maxItem).toJson();
			else
				return AgentUtils.searchAgentMix(currentAgent.getId(), keyword, -1, page, maxItem).toJson();
			 
		} catch (Exception e) {
			return BaseResponse.success(new ArrayList<>(), 0);
		}
	}
}
