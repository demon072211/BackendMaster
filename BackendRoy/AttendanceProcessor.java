package com.vinplay.api.processors.attendance;

import com.google.gson.Gson;
import com.vinplay.payment.utils.Constant;
import com.vinplay.usercore.entities.UserAttendance;
import com.vinplay.usercore.service.AttendanceService;
import com.vinplay.usercore.service.impl.AttendanceServiceImpl;
import com.vinplay.usercore.service.UserService;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.response.BaseResponse;
import org.apache.commons.lang.StringUtils;
import org.apache.log4j.Logger;
import javax.servlet.http.HttpServletRequest;
import java.util.HashMap;
import java.util.Map;

public class AttendanceProcessor implements BaseProcessor<HttpServletRequest, String> {
	private static final Logger logger = Logger.getLogger("portal");

	public String execute(Param<HttpServletRequest> param) {
		HttpServletRequest request = param.get();
		String nickname = request.getParameter("nn");
		String accessToken = request.getParameter("at");
		String action = request.getParameter("ac");// get-receive
		if (nickname == null || nickname.trim().isEmpty())
			return BaseResponse.error(Constant.ERROR_PARAM, "Nickname can not empty");

		if (StringUtils.isBlank(accessToken))
			return BaseResponse.error(Constant.ERROR_PARAM, "Access token can not empty");

		if (StringUtils.isBlank(action))
			return BaseResponse.error(Constant.ERROR_PARAM, "Action can not empty");

		if (!"get".equals(action) && !"receive".equals(action))
			return BaseResponse.error(Constant.ERROR_PARAM, "Action is invalid");

		UserService userService = new UserServiceImpl();
		boolean isToken = userService.isActiveToken(nickname, accessToken);
		if (!isToken) {
			return BaseResponse.error(Constant.ERROR_SESSION,
					"Your trading session is expired, please reload page and login again.");
		}
		
		BaseResponse<Object> res = new BaseResponse<Object>();
		try {
			AttendanceService attendanceService = new AttendanceServiceImpl();
			Map<String, Object> map = new HashMap<>();
			switch (action) {
				case "get":
					map = attendanceService.CheckAttendance(nickname);
					break;
				case "receive":
					map = attendanceService.Attendance(nickname);
					break;
			}

			String code = "";
			code = map.get("code").toString();
			String msg = "";
			msg = map.get("msg").toString();
			int consecutive = 0;
			if ("get".equals(action)) {
				consecutive = Integer.parseInt(map.get("consecutive").toString());
			}

			switch (code) {
				case "exist":
					res.setData("get".equals(action) ? consecutive : null);
					res.setErrorCode("1002");
					res.setMessage(msg);
					res.setSuccess(false);
					return res.toJson();
				case "invalid":
					res.setData("get".equals(action) ? consecutive : null);
					res.setErrorCode("1003");
					res.setMessage(msg);
					res.setSuccess(false);
					return res.toJson();
				case "success":
					Gson g = new Gson();
					if("receive".equals(action)) {
						UserAttendance p = g.fromJson(msg, UserAttendance.class);
						res.setData(p);
					}else
						res.setData(consecutive);
						
					res.setErrorCode("0");
					res.setMessage("get".equals(action) ? msg : null);
					res.setSuccess(true);
					return res.toJson();
				case "exception":
				case "failed":
				default:
					res.setData("get".equals(action) ? consecutive : null);
					res.setErrorCode("1001");
					res.setMessage(msg);
					res.setSuccess(false);
					return res.toJson();
			}
		} catch (Exception e) {
			logger.trace(e);
			res.setData("get".equals(action) ? 0 : null);
			res.setErrorCode("1001");
			res.setMessage("Exception, please contact customer care support for help.");
			res.setSuccess(false);
			return res.toJson();
		}
	}
}