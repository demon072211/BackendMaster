package com.archie.config;

/**
 * Application constants.
 */
public final class Constants {

    // Regex for acceptable logins
    public static final String LOGIN_REGEX = "^(?>[a-zA-Z0-9!$&*+=?^_`{|}~.-]+@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*)|(?>[_.@A-Za-z0-9-]+)$";

    public static final String SYSTEM_ACCOUNT = "system";
    public static final String DEFAULT_LANGUAGE = "vi";
    public static final String ANONYMOUS_USER = "anonymoususer";
	public static final int OK = 0;
	public static final int FAIL = 98;
	public static final int SYSTEM_ERROR = 99;
	public static final String SUCCESS ="SUCCESS";
	
	
	public static final int MAX_AMOUNT = 99999999;
	public static final int MIN_AMOUNT = 0;
	
	public static final int PENDING = 0;
	public static final int WAITING = 3;
	public static final int TAI = 1;//11-17 
	public static final int XIU = 2;//4-10 
	
	public static final int REAL = 1;
	public static final int BOT = 0;
	
	public static final int CMD_18S = 5;
	public static final int CMD_17S = 1;
	public static final int CMD_5S = 2;
	public static final int CMD_BET = 3;
	public static final int CMD_WIN_USER = 4;
	public static final int CMD_REFUND_USER = 7;
	public static final int CMD_HISTORY = 6;
	public static final int CMD_TXRECORD_HISTORY = 8;
	public static final int CMD_THONGKE_PHIEN = 9;
	public static final int CMD_CHAT = 10;
	public static final int CMD_CHAT_ALL = 11;
	public static final Integer CMD_MAINTAIN = 12;
	public static final Integer CMD_USER_BET = 13;
	public static final Integer CMD_RANK_TX = 14;
	public static final Integer CMD_DIS_TX = 20;
	
	public static final float rate = 0.98f;
	public static final int EXIST = -1;
	
	public static final int STATUS_FINISH = 1;
	public static final int MIN_BALANCE_CHAT = 20000;
	
	public static final String POINT = ":";
	
	public static final int USERTYPE_NORMAL = 1;
	public static final int STATUS_ACTIVE = 1;
    private Constants() {
    }
}
