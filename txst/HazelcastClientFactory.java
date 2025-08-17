package com.archie.hazelcast;

import com.hazelcast.client.HazelcastClient;
import com.hazelcast.client.config.ClientConfig;
import com.hazelcast.client.config.ClientNetworkConfig;
import com.hazelcast.config.GroupConfig;
import com.hazelcast.core.HazelcastInstance;
import com.vinplay.vbee.common.statics.Consts;

import java.io.BufferedReader;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;


public class HazelcastClientFactory {
	private static String ADDRESS = "127.0.0.1";
	private static String GROUP_NAME = "vinplay";
	private static String GROUP_PASS = "vinplay@123";
	private static HazelcastInstance instance;
	private static ClientConfig cfg;

	public static void start() throws IOException {
		try (BufferedReader br = Files.newBufferedReader(Paths.get(Consts.HAZELCAST_CONFIG_FILE))) {
			Properties prop = new Properties();
			prop.load(br);
			ADDRESS = prop.getProperty("address");
			GROUP_NAME = prop.getProperty("group_name");
			GROUP_PASS = prop.getProperty("group_pass");
			initDefault();
		}

	}

	public static void initDefault() {
		ArrayList<String> address = new ArrayList<String>();
		address.add(ADDRESS);
		init(address, GROUP_NAME, GROUP_PASS);
	}

	public static void init(List<String> address, String groupName, String groupPassword) {
		GroupConfig groupConfig = new GroupConfig();
		ClientNetworkConfig clientNetworkConfig = new ClientNetworkConfig();
		groupConfig.setName(groupName);
		groupConfig.setPassword(groupPassword);
		cfg.setGroupConfig(groupConfig);
		for (String addr : address) {
			clientNetworkConfig.addAddress(new String[] { addr });
		}
		cfg.setNetworkConfig(clientNetworkConfig);
		instance = HazelcastClient.newHazelcastClient(cfg);
	}

	public static void reconnect() {
		instance = HazelcastClient.newHazelcastClient(cfg);
	}

	public static HazelcastInstance getInstance() {
		if (!instance.getLifecycleService().isRunning()) {
			reconnect();
		}
		return instance;
	}

	static {
		cfg = new ClientConfig();
	}
}
