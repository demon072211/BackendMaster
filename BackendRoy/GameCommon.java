package com.vinplay.usercore.utils;

import java.io.BufferedReader;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.sql.SQLException;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.Map;

import org.json.JSONException;
import org.json.JSONObject;

import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;
import com.vinplay.payment.entities.Bank;
import com.vinplay.usercore.dao.BankDao;
import com.vinplay.usercore.dao.GameConfigDao;
import com.vinplay.usercore.dao.impl.BankDaoImpl;
import com.vinplay.usercore.dao.impl.GameConfigDaoImpl;
import com.vinplay.usercore.entities.AttendanceConfig;
import com.vinplay.usercore.service.AttendanceService;
import com.vinplay.usercore.service.impl.AttendanceServiceImpl;
import com.vinplay.vbee.common.exceptions.KeyNotFoundException;
import com.vinplay.vbee.common.hazelcast.HazelcastClientFactory;
import com.vinplay.vbee.common.statics.Consts;

public class GameCommon {
    public static final String SUCCESS = "1";
    public static final String ERROR = "-1";
    public static final String VIN = "VIN";
    public static final String MESSAGE_TYPE = "1";
    public static final String TOTAL_MESSAGE = "1";
    public static final String MESSAGE_INDEX = "1";
    public static final String IS_MORE = "0";
    public static final String CONTENT_TYPE = "0";
    public static final int OPEN = 0;
    public static final int CLOSE = 1;
    public static final int ON = 1;
    public static final int OFF = 0;
    
    public static List<Bank> LIST_BANK_NAME = new ArrayList<>();
    public static List<String> IP_BLACK_LIST = new ArrayList<>();
    public static String BANK_JSON = "";
    
    public static final int[] EXP_VIP = {80, 800, 4500, 8600, 50000, 1000000};
    public static final int[] HOAN_TRA_SPORT = {50, 50, 60, 70, 80, 100};// chia 10.000
    public static final int[] HOAN_TRA_CASINO = {30, 30, 40, 50, 60, 80};// chia 10.000
    public static final int[] HOAN_TRA_GAME = {10, 10, 15, 20, 30, 50};  // chia 10.000
    
	public static String initPayment() throws IOException {
		StringBuilder fullStr = new StringBuilder();
		try (BufferedReader br = Files.newBufferedReader(Paths.get(Consts.PAYMENT_CONFIG_FILE))) {
			String line;
			while ((line = br.readLine()) != null) {
				fullStr.append(line);
			}
		}
		return fullStr.toString();
	}
	
    public static void init() throws SQLException, JSONException, ParseException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap<String,String> map = instance.getMap(Consts.CACHE_CONFIG);
        GameConfigDao dao = new GameConfigDaoImpl();
        //get all web wap andr ios
        Map<String, String> mapConfig = dao.getGameConfig();
        //get web
        JSONObject cfObj = new JSONObject(mapConfig.get("web"));
        map.put("STATUS_GAME", String.valueOf(cfObj.getInt("status_game")));
        //get: admin
        map.put("ADMIN", dao.getGameCommon("admin"));
        //get: game_common
        String commons = dao.getGameCommon("game_common");
        map.put("COMMONS", commons);
        JSONObject commonObj = new JSONObject(commons);
        String hotline = commonObj.getString("hotline");
        String email = commonObj.getString("email");
        String facebook = commonObj.getString("facebook");
        String web = commonObj.getString("web");
        map.put("HU_GAME_BAI", dao.getGameCommon("game_bai"));
        String configpay;
		try {
			configpay = initPayment();
		} catch (IOException e1) {
			configpay = dao.getGameCommon("payment_config");
		}
        map.put(CacheConfigName.PAYMENTCONFIGCACHE, configpay);
        
        String gg_firebase = dao.getGameCommon("gg_firebase");
        map.put("GGFIREBASE", gg_firebase);
        
        String social = dao.getGameCommon("social");
        map.put("SOCIAL", social);

        map.put("HOT_LINE", hotline);
        map.put("EMAIL", email);
        map.put("FACEBOOK", facebook);
        map.put("WEB", web);
        map.put("SMS_OTP", commonObj.getString("sms_otp"));
        map.put("BANNER", commonObj.getJSONArray("banner").toString());
        map.put("BANNER_TOUR", commonObj.getJSONArray("banner_tour").toString());
        map.put("PASSWORD_DEFAULT", commonObj.getString("password_default"));
        map.put("IAP_KEY", commonObj.getString("iap_key"));
        map.put("UPDATE_BOT_VIN", String.valueOf(commonObj.getInt("bot_vin")));
        map.put("UPDATE_BOT_XU", String.valueOf(commonObj.getInt("bot_xu")));
        map.put("UPDATE_USER_VIN", String.valueOf(commonObj.getInt("user_vin")));
        map.put("UPDATE_USER_XU", String.valueOf(commonObj.getInt("user_xu")));
        map.put("VIN_PLUS", dao.getGameCommon("vin_plus"));
        
        //ratio return money
		String gameRefundRate = dao.getGameCommon("game_refund_rate");
		JSONObject refundRateObj = new JSONObject(gameRefundRate);
		map.put("EXP_VIP", refundRateObj.getString("EXP_VIP"));
		map.put("HOAN_TRA_SPORT", refundRateObj.getString("HOAN_TRA_SPORT"));
		map.put("HOAN_TRA_CASINO", refundRateObj.getString("HOAN_TRA_CASINO"));
		map.put("HOAN_TRA_EGAME", refundRateObj.getString("HOAN_TRA_EGAME"));
        
        JSONObject alertObj = new JSONObject(dao.getGameCommon("alert"));
        map.put("ALERT_URL", alertObj.getString("alert_url"));
        map.put("COUNT_FAIL", alertObj.getString("count_fail"));
        map.put("DISCONNECT_GROUP_NUMBER", alertObj.getString("disconnect_group_number"));
        map.put("PENDING_GROUP_NUMBER", alertObj.getString("pending_group_number"));
        map.put("FREEZE_MONEY_GROUP_NUMBER", alertObj.getString("freeze_money_group_number"));
        map.put("MEGA_CARD_GROUP_NUMBER", alertObj.getString("mega_card_group_number"));

        String telegramToken = alertObj.getString("Telegram_boot_token");
        String telegramChatId = alertObj.getString("Telegram_chat_id");
        map.put("Telegram_boot_token", telegramToken);
        map.put("Telegram_chat_id", telegramChatId);

		String ipBlackList = dao.getGameCommon("ip_black_list");
		if (ipBlackList != null) {
			IP_BLACK_LIST = Arrays.asList(ipBlackList.split(","));
		}
//		JSONObject listBank = new JSONObject(dao.getGameCommon("bank"));
//		BANK_JSON = listBank.toString();
//		//LIST_BANK_NAME = Arrays.asList(listBank.getString("bank").split(","));
		BankDao bankDao = new BankDaoImpl();
		try {
			LIST_BANK_NAME = bankDao.findAll();
		} catch (Exception e) {
			
		}
		StringBuilder bankStr = new StringBuilder();
		if (LIST_BANK_NAME != null && !LIST_BANK_NAME.isEmpty()) {
			LIST_BANK_NAME.forEach(bank -> {
				bankStr.append(bank.getBank_name().trim()).append(",");
			});
		}
		BANK_JSON = String.format("{\"bank\":\"%s\"}", bankStr.substring(0, bankStr.length()-1));
		
		JSONObject shotfishConfig = new JSONObject(dao.getGameCommon("shotfish"));
        map.put(CacheConfigName.SHOTFISHCONFIGCACHE, shotfishConfig.toString());
        JSONObject telegramBotConfig = new JSONObject(dao.getGameCommon("telegrambot"));
        map.put(CacheConfigName.TELEGRAMBOTCONFIGCACHE, telegramBotConfig.toString());
        
        //Set cached attendance configuration
        AttendanceService attendanceService = new AttendanceServiceImpl();
        AttendanceConfig attendanceConfig = new AttendanceConfig();
        try{
        	attendanceConfig = attendanceService.getConfigLastest();
        }catch (Exception e) {
        	attendanceService = null;
		}
        map.put(CacheConfigName.ATTENDANCE_CONFIG, attendanceConfig == null ? "" : attendanceConfig.toJson());
    }
    
    public static String getValueStr(String key) throws KeyNotFoundException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey(key)) {
            return (String)map.get(key);
        }
        throw new KeyNotFoundException();
    }

    public static int getValueInt(String key) throws KeyNotFoundException, NumberFormatException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey(key)) {
            return Integer.parseInt((String)map.get(key));
        }
        throw new KeyNotFoundException();
    }

    public static double getValueDouble(String key) throws KeyNotFoundException, NumberFormatException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey(key)) {
            return Double.parseDouble((String)map.get(key));
        }
        throw new KeyNotFoundException();
    }

    public static long getValueLong(String key) throws KeyNotFoundException, NumberFormatException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey(key)) {
            return Long.parseLong((String)map.get(key));
        }
        throw new KeyNotFoundException();
    }

    public static String getHuVangGameBai() throws KeyNotFoundException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey("HU_GAME_BAI")) {
            return (String)map.get("HU_GAME_BAI");
        }
        throw new KeyNotFoundException();
    }

    public static List<String> getPhoneAlert() throws KeyNotFoundException {
        HazelcastInstance instance = HazelcastClientFactory.getInstance();
        IMap map = instance.getMap("cacheConfig");
        if (map.containsKey("LIST_PHONE_ALERT")) {
            String[] split;
            ArrayList<String> res = new ArrayList<String>();
            String[] arr = split = ((String)map.get("LIST_PHONE_ALERT")).split(",");
            for (String m : split) {
                if (m.isEmpty()) continue;
                res.add(m);
            }
            return res;
        }
        throw new KeyNotFoundException();
    }

}

