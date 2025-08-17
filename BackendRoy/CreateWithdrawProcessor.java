package com.vinplay.api.processors.payment;

import java.sql.SQLException;
import java.util.Map;
import java.util.concurrent.ConcurrentHashMap;
import javax.servlet.http.HttpServletRequest;
import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import com.vinplay.api.utils.PortalUtils;
import com.vinplay.dal.dao.AgentDAO;
import com.vinplay.dal.dao.impl.AgentDAOImpl;
import com.vinplay.dal.entities.agent.UserAgentModel;
import com.vinplay.dichvuthe.response.RechargePaywellResponse;
import com.vinplay.payment.entities.Bank;
import com.vinplay.payment.entities.UserBank;
import com.vinplay.payment.service.WithDrawManualBankService;
import com.vinplay.payment.service.impl.WithDrawManualBankServiceImpl;
import com.vinplay.payment.utils.Constant;
import com.vinplay.payment.utils.PaymentConstant;
import com.vinplay.usercore.service.UserBankService;
import com.vinplay.usercore.service.UserService;
import com.vinplay.usercore.service.impl.UserBankServiceImpl;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.models.UserModel;
import com.vinplay.vbee.common.models.cache.UserCacheModel;
import com.vinplay.vbee.common.response.BaseResponse;

public class CreateWithdrawProcessor implements BaseProcessor<HttpServletRequest, String> {

	private static final Logger logger = Logger.getLogger("api");

	private static Map<String, Long> mapCache = new ConcurrentHashMap<String, Long>();

	public static boolean validateRequest(String orderID) {
		if (mapCache.isEmpty()) {
			long t1 = new java.util.Date().getTime();
			mapCache.put(orderID, t1);
		} else {
			if (mapCache.containsKey(orderID)) {

				long t1 = mapCache.get(orderID);
				long t2 = new java.util.Date().getTime();
				if ((t2 - t1) > 1000 * 5) {
					mapCache.put(orderID, t2);
					return true;
				} else {
					return false;
				}

			} else {
				long t1 = new java.util.Date().getTime();
				mapCache.put(orderID, t1);
			}
		}
		return true;
	}

	@Override
	public String execute(Param<HttpServletRequest> param) {
		HttpServletRequest request = param.get();
		long amount = 0;
		try {
			amount = Long.parseLong(request.getParameter("am"));
		} catch (Exception e) {
			return BaseResponse.error("99", e.getMessage());
		}

		String agentCode = request.getParameter("code");
		if (StringUtils.isBlank(agentCode)) {
			return BaseResponse.error(Constant.ERROR_PARAM, "Agent code can not empty");
		}

		String bankNumber = request.getParameter("bn");
		String nickName = request.getParameter("nn");
		String accessToken = request.getParameter("at");
		String ip = PortalUtils.getIpAddress(request);
		logger.info("Withdraw request nickName: " + nickName + ", accessToken: " + accessToken + ",ipaddress=" + ip);
		if (!validateRequest(nickName)) {
			return BaseResponse.error(Constant.ERROR_DUPLICATE,
					"Please wait 5 seconds to make the next transaction, NickName =" + nickName);
		}

		if (StringUtils.isBlank(nickName) || StringUtils.isBlank(accessToken)) {
			return BaseResponse.error(Constant.ERROR_PARAM, "Input parameter is null or empty");
		}

		if (StringUtils.isBlank(bankNumber)) {
			return BaseResponse.error(Constant.ERROR_PARAM, "Bank number can not empty");
		}

		UserService userService = new UserServiceImpl();
		try {
			// validation token
			WithDrawManualBankService withdrawService = new WithDrawManualBankServiceImpl();
			boolean isToken = userService.isActiveToken(nickName, accessToken);
			if (isToken) {
				// check min amount
				if (amount < 1000) {
					return BaseResponse.error(Constant.MIN_MONEY, "Money must be greater than " + 100000);
				}
				
				// get usermodel
				UserModel user = userService.getUserByNickName(nickName);
				if (user.isBanLogin() || user.isBanTransferMoney() || user.isBot()) {
					return BaseResponse.error(Constant.ERROR_USERTYPE, "You can not allow access this feature");
				}
				
				if(user.getDaily() == 1) {
					AgentDAO agentDao = new AgentDAOImpl();
			        UserAgentModel agentModel;
					try {
						agentModel = agentDao.DetailUserAgentByNickName(nickName);
					} catch (SQLException e1) {
						e1.printStackTrace();
						agentModel = null;
					}
					
			        if(agentModel == null)
			        	return BaseResponse.error(Constant.ERROR_PARAM, "Agent account is not exist");
			        
			        if(agentModel.getActive() == 0)
			        	return BaseResponse.error(Constant.ERROR_PARAM, "Agent is inactive");
				}
				
				UserBankService bankService = new UserBankServiceImpl();
				UserBank userBank = bankService.getByDetail(nickName, bankNumber);
				if (userBank == null)
					return BaseResponse.error(Constant.ERROR_USERTYPE, "Bank number is invalid");

				Bank bank = GameCommon.LIST_BANK_NAME.stream()
						.filter(x -> userBank.getBankName().equals(x.getBank_name())).findAny().orElse(null);
				RechargePaywellResponse rs = withdrawService.create(String.valueOf(user.getId()), user.getUsername(),
						user.getNickname(), bank == null ? userBank.getBankName() : bank.getCode(), bankNumber,
						userBank.getCustomerName(), agentCode, amount);
				if (rs == null) {
					return BaseResponse.error(Constant.ERROR_CREATE_TRANSACTION, "Create transaction deposit failure");
				} else {
					logger.info("Deposit response nickName: " + nickName + ", response : " + rs.toJson());
				}

				if (PaymentConstant.SUCCESS == rs.getCode()) {
					return new BaseResponse<>().success(rs.getData());
				} else {
					return BaseResponse.error(rs.getCode() + "", rs.getData());
				}
			} else {
				return BaseResponse.error(Constant.ERROR_SESSION,
						"Your trading session has expried, please reload the page and login again.");
			}
		} catch (Exception e) {
			logger.error(e);
			return BaseResponse.error(Constant.ERROR_SYSTEM, e.getMessage());
		}
	}
}
