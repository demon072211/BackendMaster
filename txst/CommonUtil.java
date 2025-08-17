/**
 * 
 */
package com.archie.util;

import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * @author Archie
 * @date Sep 19, 2020
 */
public class CommonUtil {
	public static int ids = 100000;
	private static long oldTransId = 0L;

	public static synchronized long generateTransId() {
		long transId = System.currentTimeMillis();
		while (transId == oldTransId) {
			transId = System.currentTimeMillis();
		}
		oldTransId = transId;
		return oldTransId;
	}

	public synchronized static int getids() {
		ids++;
		if (ids > 999999) {
			ids = 100000;
		}
		return ids;
	}

	public static String getCurDate(String type) {
		if (type == null) {
			type = "yyyy-MM-dd HH:mm:ss";
		}
		try {
			String strdate = "";
			Date currentTime = new Date();
			SimpleDateFormat format0 = new SimpleDateFormat(type);
			strdate = format0.format(currentTime);
			return strdate;
		} catch (Exception ex) {
			ex.printStackTrace();
			return null;
		}
	}
}
