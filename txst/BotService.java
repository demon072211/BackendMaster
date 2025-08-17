/**
 * 
 */
package com.archie.service;

import org.springframework.web.multipart.MultipartFile;

/**
 * @author Archie
 * @date Sep 30, 2020
 */
public interface BotService {
	public String getNamBotTai();

	public String getNamBotXiu();

	public String getNamBot();

	public void addBot(long Amount, int type);

	public String getMessage();

	public boolean uploadBotChatFile(MultipartFile file);

	public boolean uploadBotGameFile(MultipartFile file);

	public void writeToFile(String message);

}
