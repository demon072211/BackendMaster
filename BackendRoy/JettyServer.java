package com.vinplay.pay.server;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.Arrays;
import java.util.EnumSet;
import java.util.HashMap;
import java.util.List;
import java.util.Properties;

import javax.servlet.DispatcherType;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.apache.commons.fileupload.FileItemIterator;
import org.apache.commons.fileupload.FileItemStream;
import org.apache.commons.fileupload.FileUploadException;
import org.apache.commons.fileupload.servlet.ServletFileUpload;
import org.apache.commons.fileupload.util.Streams;
import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;
import org.eclipse.jetty.server.ConnectionFactory;
import org.eclipse.jetty.server.Connector;
import org.eclipse.jetty.server.Handler;
import org.eclipse.jetty.server.HttpConfiguration;
import org.eclipse.jetty.server.HttpConnectionFactory;
import org.eclipse.jetty.server.SecureRequestCustomizer;
import org.eclipse.jetty.server.Server;
import org.eclipse.jetty.server.ServerConnector;
import org.eclipse.jetty.server.SslConnectionFactory;
import org.eclipse.jetty.server.handler.HandlerCollection;
import org.eclipse.jetty.server.handler.IPAccessHandler;
import org.eclipse.jetty.servlet.ServletHandler;
import org.eclipse.jetty.util.ssl.SslContextFactory;
import org.w3c.dom.Element;
import org.w3c.dom.NodeList;

import com.vinplay.api.otp.PayResponse;
import com.vinplay.dichvuthe.response.RechargePaywellResponse;
import com.vinplay.payment.entities.PaywellNotifyRequest;
import com.vinplay.payment.service.RechargeOneClickPayService;
import com.vinplay.payment.service.RechargePayWellService;
import com.vinplay.payment.service.RechargePrincePayService;
import com.vinplay.payment.service.WithDrawPrincePayService;
import com.vinplay.payment.service.impl.RechargeOneClickPayServiceImpl;
import com.vinplay.payment.service.impl.RechargePayWellServiceImpl;
import com.vinplay.payment.service.impl.RechargePrincePayServiceImpl;
import com.vinplay.payment.service.impl.WithDrawPrincePayServiceImpl;
import com.vinplay.payment.utils.Constant;
import com.vinplay.payment.utils.PayUtils;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.usercore.utils.GameThirdPartyInit;
import com.vinplay.vbee.common.config.VBeePath;
import com.vinplay.vbee.common.cp.BaseController;
import com.vinplay.vbee.common.hazelcast.HazelcastLoader;
import com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory;
import com.vinplay.vbee.common.response.BaseResponse;
import com.vinplay.vbee.common.rmq.RMQApi;
import com.vinplay.vbee.common.statics.Consts;

public class JettyServer {
	private static final Logger logger = Logger.getLogger(JettyServer.class);
	private static final Logger blackListIpLogger = Logger.getLogger("BlackListIpLogger");
	private static final String LOG_PROPERTIES_FILE = "config/log4j.properties";
	private static int HTTP_PORT = 8081;
	private static int SSL_PORT = 443;
	private static long IDLE_TIMEOUT = 30000L;
	private static BaseController<HttpServletRequest, String> controller;
	private static String basePasth;

	private static void initializeLogger() {
		Properties logProperties = new Properties();
		try {
			File file = new File(basePasth.concat(LOG_PROPERTIES_FILE));
			logProperties.load(new FileInputStream(file));
			PropertyConfigurator.configure((Properties) logProperties);
			logger.info("Logging initialized.");
		} catch (IOException e) {
			throw new RuntimeException("Unable to load logging property config/log4j.properties");
		}
	}
	public static String getIpAddress(HttpServletRequest request) {
		String ipAddress = request.getHeader("X-FORWARDED-FOR");
		if (ipAddress == null) {
			ipAddress = request.getRemoteAddr();
		}
		String clientIp = null;
		if (ipAddress != null && !"".equals(ipAddress)) {
			String[] arrayIp = ipAddress.split(",");
			if(arrayIp.length>0) {
				clientIp = arrayIp[0].trim();
			}
		}
		return clientIp;
	}
	public static class PayPrinceNotifyServlet extends HttpServlet {
		private static final long serialVersionUID = 1L;

		protected void doGet(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			doPost(request, response);
		}

		protected void doPost(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			this.onExecute(request, response);
		}

		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");
			response.setStatus(200);
			String status =  request.getParameter("status");
			String result = request.getParameter("result");
			String sign = request.getParameter("sign");
			logger.info("Notify princepay , status = " + status + ",result=" + result + ",sign=" + sign);
			RechargePrincePayService service = new RechargePrincePayServiceImpl();
			//String requestData = request.getReader().lines().collect(Collectors.joining());
			int statusInt = 0;
			try {
				statusInt = Integer.parseInt(status);
			} catch (NumberFormatException e) {
				logger.error(e);
				return ;
			}
			if (StringUtils.isBlank(result) || StringUtils.isBlank(sign))
				return;

			RechargePaywellResponse responseData = service.notify(statusInt, result,sign);
			logger.info("Notify princepay , response = " + responseData.toJson());
			response.getWriter().println(responseData.toJson());
		}
	}

	public static class PayPrinceWithDrawNotifyServlet extends HttpServlet {
		private static final long serialVersionUID = 1L;

		protected void doGet(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			doPost(request, response);
		}

		protected void doPost(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			this.onExecute(request, response);
		}

		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");
			response.setStatus(200);
			String status =  request.getParameter("status");
			String result = request.getParameter("result");
			String sign = request.getParameter("sign");
			logger.info("Notify princepay , status = " + status + ",result=" + result + ",sign=" + sign);
			WithDrawPrincePayService service = new WithDrawPrincePayServiceImpl();
			//String requestData = request.getReader().lines().collect(Collectors.joining());
			int statusInt = 0;
			try {
				statusInt = Integer.parseInt(status);
			} catch (NumberFormatException e) {
				logger.error(e);
				return ;
			}
			if (StringUtils.isBlank(result) || StringUtils.isBlank(sign))
				return;

			boolean responseData = service.notify(statusInt, result, sign);
			if(responseData) {
				response.getWriter().println("{\"get\":\"success\"}");
			}else {
				response.getWriter().println("{\"get\":\"false\"}");
			}
		}
	}

//	public static class PayPrinceWithDrawClickServlet extends HttpServlet {
//		private static final long serialVersionUID = 1L;
//
//		protected void doGet(HttpServletRequest request, HttpServletResponse response)
//				throws ServletException, IOException {
//			doPost(request, response);
//		}
//
//		protected void doPost(HttpServletRequest request, HttpServletResponse response)
//				throws ServletException, IOException {
//			this.onExecute(request, response);
//		}
//
//		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
//			response.setContentType("application/json");
//			response.setCharacterEncoding("UTF-8");
//			response.setStatus(200);
//			String c = request.getParameter("c");
//			String ip =  "";
//			try{
//				ip = request.getParameter("ip");
//			}catch (Exception e) { }
//
//			RechargePaywellResponse responseData = new RechargePaywellResponse(1, 0L, 0, 0L,"");
//			WithDrawPrincePayService service = new WithDrawPrincePayServiceImpl();
//			if(c.contains("0")) {
//				String userId =  request.getParameter("userId");
//				String username = request.getParameter("username");
//				String nickname = request.getParameter("nickname");
//				String bankNumber = request.getParameter("bankNumber");
//				long amount = Long.valueOf(request.getParameter("amount"));
//				logger.info("Withdraw oneclick , userId = " + userId + ",username=" + username + ",nickname=" + nickname
//						+ ",amount=" + String.valueOf(amount) + ",bankNumber=" + bankNumber);
//				responseData = service.requestWithdrawUser(userId, username, nickname, amount, bankNumber);
//			}
//
//			if(c.contains("1")) {
//				String orderId = request.getParameter("orderId");
//				String channel = request.getParameter("channel");
//				String staffUserName = request.getParameter("approvedName");
//				logger.info("Withdraw oneclick by staff , orderId = " + orderId + ",channel=" + channel + ",staffUserName=" + staffUserName
//						+ ",ip=" + ip);
//				responseData = service.withdrawal(orderId, channel, staffUserName, ip);
//			}
//			response.getWriter().println(responseData.toJson());
//		}
//	}
//	
	

	public static class PayOneClickDepositNotifyServlet extends HttpServlet {
		private static final long serialVersionUID = 1L;

		protected void doGet(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			doPost(request, response);
		}

		protected void doPost(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			this.onExecute(request, response);
		}
		//
		
		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");
			response.setStatus(200);
			String remoteAddr = getIpAddress(request);
			if (!"52.77.84.74".equalsIgnoreCase(remoteAddr)) {
				logger.error("Remote IP Address PayOneClickDepositNotifyServlet = " + remoteAddr);
			}
			

			String amount = request.getParameter("amount");
			String net_amount = request.getParameter("net_amount");
			String transactionId = request.getParameter("tnx");
			String orderId = request.getParameter("merchant_txn");
			String sign = request.getParameter("sign");
			logger.info("Notify oneclick , amount = " + amount + ",net_amount=" + net_amount + ",transactionId="
					+ transactionId + ",orderId=" + orderId + ",sign=" + sign);
			RechargeOneClickPayService service = new RechargeOneClickPayServiceImpl();
//			RechargePaywellResponse responseData = service.notify(statusInt, result,sign);
			RechargePaywellResponse responseData = service.notify(amount, net_amount, transactionId, orderId, sign);
			if (responseData.getCode() == 0) {
				response.getWriter().println("VERIFIED");
			} else {
				response.getWriter().println("FAILED");
			}
		}
	}
	
	public static class PayWellNotifyServlet extends HttpServlet {
		private static final long serialVersionUID = 1L;
		private static final List<String> IP_PAYWELL = Arrays.asList(new String[] { "128.199.175.124", "165.22.55.154" });
		
		protected void doGet(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			doPost(request, response);
		}

		protected void doPost(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			this.onExecute(request, response);
		}
		
		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");
			response.setStatus(200);
			
			String remoteAddr = getIpAddress(request);
			if (!IP_PAYWELL.contains(remoteAddr)) {
				logger.error("Remote IP Address IP_PAYWELL_NOTALLOW = " + remoteAddr);
			}
			
			logger.info("Remote IP Address PAYWELL " + remoteAddr);
			PaywellNotifyRequest requestObj = new PaywellNotifyRequest();
			boolean isMultipart = ServletFileUpload.isMultipartContent(request);
			if (isMultipart) {
				ServletFileUpload upload = new ServletFileUpload();
			    try {
			    	FileItemIterator iter = upload.getItemIterator(request);
			    	InputStream stream =null;
					while (iter.hasNext()) {
					    FileItemStream item = iter.next();
					    String name = item.getFieldName().toLowerCase();
						try {
							stream = item.openStream();
							if (item.isFormField()) {
								String value = Streams.asString(stream);
								switch (name) {
								case "merchantcode":
									requestObj.setMerchantCode(value);
									break;
								case "cartid":
									requestObj.setCartId(value);
									break;
								case "referenceid":
									requestObj.setReferenceId(value);
									break;
								case "amount":
									requestObj.setAmount(Double.parseDouble(value));
									break;
								case "amountfee":
									requestObj.setAmountFee(Double.parseDouble(value));
									break;
								case "currencycode":
									requestObj.setCurrencyCode(value);
									break;
								case "status":
									requestObj.setStatus(Integer.parseInt(value));
									break;
								case "requesttime":
									requestObj.setRequestTime(Long.parseLong(value));
									break;
								case "signature":
									requestObj.setSignature(value);
									break;
								default:
									break;
								}
							}
						} finally {
							if (stream != null)
								stream.close();
						}
					}
				} catch (FileUploadException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}

			}
			String res="";
			logger.info("Request notify paywell " + requestObj.toJson());
			try {
				RechargePayWellService service = new RechargePayWellServiceImpl();
				RechargePaywellResponse rechargeResponse = service.notification(requestObj);
				logger.info("Response notify paywell " + rechargeResponse.toJson());
				if (rechargeResponse.getCode() == 0) {
					res = new PayResponse(1, "success").toJson();
				} else {
					res = new PayResponse(0, rechargeResponse.getData()).toJson();
				}
			} catch (Exception e) {
				logger.error(e);
				res = new PayResponse(0, e.getMessage()).toJson();
			}
			response.getWriter().println(res);
		}
	}

	public static class OneClickServlet extends HttpServlet {
		private static final long serialVersionUID = 1L;

		protected void doGet(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			doPost(request, response);
		}

		protected void doPost(HttpServletRequest request, HttpServletResponse response)
				throws ServletException, IOException {
			this.onExecute(request, response);
		}

		private void onExecute(HttpServletRequest request, HttpServletResponse response) throws IOException {
			response.setContentType("application/json");
			response.setCharacterEncoding("UTF-8");
			response.setStatus(200);
			String userId = request.getParameter("userId");
			String username = request.getParameter("username");
			String nickname = request.getParameter("nickname");
			String customerName = request.getParameter("customerName");
			String bankCode = request.getParameter("bankCode");
			String channel = request.getParameter("channel");
			String ip = request.getParameter("ip");
			String res = "";
			long amount = 0;
			try {
				amount = Long.parseLong(request.getParameter("amount"));
			} catch (Exception e) {
				res = "{\"code\":99,\"message\":\"" + e.getMessage() + "\"}";
			}
			try {
				RechargeOneClickPayService service = new RechargeOneClickPayServiceImpl();
				RechargePaywellResponse rechargeResponse = service.createTransaction(userId, username,  nickname, amount, channel, customerName, bankCode, ip);
				if (rechargeResponse.getCode() == 0) {
					res = "{\"code\":1,\"message\":\"success\"}";
				} else {
					res = "{\"code\":0,\"message\":\"" + rechargeResponse.getData() + "\"}";
				}
			} catch (Exception e) {
				logger.error(e);
				res = BaseResponse.error(Constant.ERROR_SYSTEM, e.getMessage());
			}

			response.getWriter().println(res);
		}
	}

	public static void main(String[] args) {
		try {
			basePasth = VBeePath.initBasePath(JettyServer.class);
			JettyServer.initializeLogger();
			logger.info("STARTING WEBSERVICE PAY API .... !!!!");
			JettyServer.loadConfig();
			RMQApi.start(Consts.RMQ_CONFIG_FILE);
			// Config
			HazelcastLoader.start();
			 //add game3rd config
			GameThirdPartyInit.init();
			
			MongoDBConnectionFactory.init();
			GameCommon.init();
			
			PayUtils.init();
			Server server = new Server();
			ServerConnector connector = new ServerConnector(server);
			connector.setPort(HTTP_PORT);
			connector.setIdleTimeout(IDLE_TIMEOUT);
			HttpConfiguration https = new HttpConfiguration();
			ServletHandler handler = new ServletHandler();
			handler.addFilterWithMapping(CorsFilter.class, "/*", EnumSet.of(DispatcherType.REQUEST));
			handler.addServletWithMapping(PayPrinceNotifyServlet.class, "/payprince/notify");
			handler.addServletWithMapping(PayPrinceWithDrawNotifyServlet.class, "/payprince/withdraw/notify");
			handler.addServletWithMapping(PayWellNotifyServlet.class, "/paywell/notify");
//			handler.addServletWithMapping(OneClickServlet.class, "/oneclick");
			//handler.addServletWithMapping(PayOneClickDepositNotifyServlet.class, "/oneclick/notify");
			//TODO

			IPAccessHandler ipAccessHandler = new IPAccessHandler();
			ipAccessHandler.setHandler(handler);
			HandlerCollection handlerCollection = new HandlerCollection();
			handlerCollection.setHandlers(new Handler[] { ipAccessHandler });
			server.setHandler(handlerCollection);
			server.addConnector(connector);
			server.start();
			logger.info("WEBSERVICE PAY API Started ...!!!");
//			ScheduleMain.run();
			server.join();

		} catch (Exception e) {
			logger.error(("WEBSERVICE PAY API Start error: " + e.getMessage()));
			e.printStackTrace();
		}
	}

	private static void loadConfig() throws Exception {
		File file = new File(basePasth.concat("config/api_portal.xml"));
		DocumentBuilderFactory dFactory = DocumentBuilderFactory.newInstance();
		DocumentBuilder dBuilder = dFactory.newDocumentBuilder();
		org.w3c.dom.Document doc = dBuilder.parse(file);
		doc.getDocumentElement().normalize();
		NodeList nodeList = doc.getElementsByTagName("portal");
		Element el = (Element) nodeList.item(0);
		HTTP_PORT = Integer.parseInt(el.getElementsByTagName("http_port").item(0).getTextContent());
		SSL_PORT = Integer.parseInt(el.getElementsByTagName("ssl_port").item(0).getTextContent());
		IDLE_TIMEOUT = Integer.parseInt(el.getElementsByTagName("idle_timeout").item(0).getTextContent());
		Element cmds = (Element) el.getElementsByTagName("commands").item(0);
		NodeList cmdList = cmds.getElementsByTagName("command");
		HashMap<Integer, String> commandsMap = new HashMap<Integer, String>();
		for (int i = 0; i < cmdList.getLength(); ++i) {
			Element eCmd = (Element) cmdList.item(i);
			Integer id = Integer.parseInt(eCmd.getElementsByTagName("id").item(0).getTextContent());
			String path = eCmd.getElementsByTagName("path").item(0).getTextContent();
			logger.debug((id + " <-> " + path));
			System.out.println(id + " <-> " + path);
			commandsMap.put(id, path);
		}
		controller = new BaseController<>();
		controller.initCommands(commandsMap);
	}

}
