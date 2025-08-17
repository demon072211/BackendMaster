/**
 * 
 */
package com.archie.service.impl;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashSet;
import java.util.Iterator;
import java.util.List;
import java.util.SplittableRandom;

import javax.annotation.PostConstruct;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import com.archie.service.BotService;
import com.archie.service.UserinfoService;

/**
 * @author Archie
 * @date Sep 30, 2020
 */
@Service
public class BotServiceImpl implements BotService{
	
	private final Logger log = LoggerFactory.getLogger(BotServiceImpl.class);
	
	private final SplittableRandom rdom = new SplittableRandom();
	
	private String[] botname = {};
	//private String[] message = {};
	
	private String[] botnameTai = {};
	 private String[] botnameXiu = {};
	
	private List<String> message = new ArrayList<>();
	
	private List<String> messageToFile = new ArrayList<>();
	
	private static final int PUT_SIZE = 0;
	
	@Autowired UserinfoService uService;
	
	private static final String UPLOADED_FOLDER = "/var/app/upload/";
	
	@PostConstruct
	public void init() {
		initName();
		initMessage();
	}
	
	private void initName() {
		try (BufferedReader br = Files.newBufferedReader(Paths.get(UPLOADED_FOLDER + "nameBot.txt"))) {
			botname = br.readLine().split(",");
		} catch (IOException e) {
			log.error("can't read text file");
		}
		int leng = botname.length;
		if (botname != null && leng > 50) {
			botnameTai = new String[leng / 2];
			botnameXiu = new String[leng / 2];
			System.arraycopy(botname, 0, botnameTai, 0, botnameTai.length);
			System.arraycopy(botname, botnameTai.length, botnameXiu, 0, botnameXiu.length);
		}
	}

	private void initMessage() {
		message.clear();
		try (BufferedReader br = Files.newBufferedReader(Paths.get(UPLOADED_FOLDER + "message.txt"))) {
			String line;
			while ((line = br.readLine()) != null) {
				message.add(line);
			}
		} catch (IOException e) {
			e.printStackTrace();
			log.error(e.getMessage());
		}
	}

	@Override
	public String getNamBotTai() {
		if (botnameTai != null && botnameTai.length > 0) {
			int rh = rdom.nextInt(botnameTai.length);
			String loginname = botnameTai[rh];
			// uService.save(loginname);
			return loginname;
		} else {
			return "";
		}
	}

	@Override
	public String getNamBotXiu() {
		if (botnameXiu != null && botnameXiu.length > 0) {
			int rh = rdom.nextInt(botnameXiu.length);
			String loginname = botnameXiu[rh];
			// uService.save(loginname);
			return loginname;
		} else {
			return "";
		}
	}

	@Override
	public String getNamBot() {
		if (botname != null && botname.length > 0) {
			int rh = rdom.nextInt(botname.length - 1);
			String loginname = botname[rh];
			// uService.save(loginname);
			return loginname;
		} else {
			return "";
		}

	}

	@Override
	public void addBot(long Amount, int type) {
		// TODO Auto-generated method stub
		
	}
//	public static void main(String[] args) {
//		SplittableRandom rdom = new SplittableRandom();
//		String[] a1= {"nguyen","hoang","vu","phan","tran","pham","dang","bui","do","ly"};
//		String [] a2= {"van1","conga","duc","vu","minh","thi","thu","hoa","miu","hai","tam","phuc","luan",""};
//		String [] a3= {"1","12","89","188","","","1994","","2020","","","","78","","87","64","1902","1601",""};
//		int t=0;
//		List<String> r =new ArrayList<>();
//		for (int i = 0; i < a1.length-1; i++) {
//			for (int j = 0; j < a2.length-1; j++) {
//				for (int j2 = 0; j2 < a3.length-1; j2++) {
//					r.add(a1[i]+a2[j]+a3[j2]);
//				}
//			}
//		}
//		List<Integer> ran =new ArrayList<>();
//		for (int i = 0; i <= 300; i++) {
//			int k= rdom.nextInt(r.size());
//			while(ran.contains(k)) {
//				k= rdom.nextInt(r.size());
//			}
//			ran.add(k);
//			System.out.print(r.get(k)+",");
//		}
//		System.out.println(ran.size());
//	}
	@Override
	public String getMessage() {
		if(message!=null) {
			int size = message.size();
			if (size > 2) {
				int rm = rdom.nextInt(size - 1);
				return message.get(rm);
			} else {
				return null;
			}
		}else {
			return null;
		}
		
	}

	@Override
	public boolean uploadBotChatFile(MultipartFile file) {
		boolean result =false;
		try {
			if (file.isEmpty()) {
			    throw new IOException("Failed to store empty file");
			}
			byte[] bytes = file.getBytes();
            Path path = Paths.get(UPLOADED_FOLDER + "message.txt");
            File fOld = new File(UPLOADED_FOLDER + "message.txt");
            if(fOld.exists() && fOld.isFile()) {
            	fOld.deleteOnExit();
            }
            Files.write(path, bytes);
            result= true;
		} catch (Exception e) {
			log.error(e + "");
			result= false;
		}
		if(result) {
			initMessage();
		}
		return result;
	}

	@Override
	public boolean uploadBotGameFile(MultipartFile file) {
		try {
			if (file.isEmpty()) {
			    throw new IOException("Failed to store empty file");
			}
			File fOld = new File(UPLOADED_FOLDER + "nameBot.txt");
            if(fOld.exists() && fOld.isFile()) {
            	fOld.deleteOnExit();
            }
			byte[] bytes = file.getBytes();
            Path path = Paths.get(UPLOADED_FOLDER + "nameBot.txt");
            Files.write(path, bytes);
			initName();
		} catch (Exception e) {
			log.error(e + "");
			return false;
		}
		return true;
	}

	@Override
	public void writeToFile(String message) {
		if (message == null || message.equals(""))
			return;
		this.messageToFile.add(message);
		if (messageToFile.size() >= PUT_SIZE) {
			List<String> lstSync = Collections.synchronizedList(messageToFile);
			try (FileWriter fw = new FileWriter(UPLOADED_FOLDER + "message.txt", true);
					BufferedWriter bw = new BufferedWriter(fw);
					PrintWriter out = new PrintWriter(bw)) {
				synchronized (lstSync) {
					Iterator<String> iterator = lstSync.iterator();
					while (iterator.hasNext()) {
						out.println(iterator.next());
						iterator.remove();
					}
				}
			} catch (IOException e) {
				log.error("" + e);
			}
		}
	}
	
}
