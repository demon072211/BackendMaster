package com.archie.hazelcast;

import java.util.ArrayList;
import java.util.List;


import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;
import com.vinplay.vbee.common.models.UserModel;
import com.vinplay.vbee.common.models.cache.UserActiveModel;
import com.vinplay.vbee.common.models.cache.UserCacheModel;
import com.vinplay.vbee.common.models.cache.UserMoneyModel;
import com.vinplay.vbee.common.models.cache.UserVippointEventModel;

public class HazelcastUtils {
	

	public static IMap<String, UserCacheModel> getUserMap(String nickname) {
		return HazelcastClientFactory.getInstance().getMap("cache_user");
	}

	public static IMap<String, UserActiveModel> getActiveMap(String nickname) {
		return HazelcastClientFactory.getInstance().getMap("cache_user_active");
	}

	public static IMap<String, UserMoneyModel> getMoneyMap(String nickname) {
		return HazelcastClientFactory.getInstance().getMap("cache_user_money");
	}
	
    public static long getCurrentMoneyUserCache(String nickname) {
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap<String, UserModel> userMap = client.getMap("users");
        if (userMap.containsKey(nickname)) {
            UserCacheModel user = (UserCacheModel)userMap.get(nickname);
            return user.getCurrentMoney("vin");
        }
        return 0L;
    }

	public static IMap<String, UserVippointEventModel> getVPEventMap(String nickname) {
		return HazelcastClientFactory.getInstance().getMap("cache_user_vp_event");
	}

	public static List<IMap<String, UserCacheModel>> getAllUserMap() {
		ArrayList<IMap<String, UserCacheModel>> allMap = new ArrayList<IMap<String, UserCacheModel>>();
		allMap.add(getUserMap(""));
		return allMap;
	}

	public static List<IMap<String, UserMoneyModel>> getAllMoneyMap() {
		ArrayList<IMap<String, UserMoneyModel>> allMap = new ArrayList<IMap<String, UserMoneyModel>>();
		allMap.add(getMoneyMap(""));
		return allMap;
	}
}
