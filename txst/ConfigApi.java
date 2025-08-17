/**
 *
 */
package com.archie.api;

import com.archie.config.Constants;
import com.archie.schedule.BatchTaixiuBonus;
import com.archie.service.BotService;
import com.archie.service.ChatboxService;
import com.archie.service.dto.BaseResponse;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import javax.servlet.ServletRequest;

/**
 * @author Archie
 * @date Oct 6, 2020
 */
@RestController
@RequestMapping("/api/config")
public class ConfigApi {
    private final Logger log = LoggerFactory.getLogger(ConfigApi.class);

    @Autowired
    private BatchTaixiuBonus batchTx;
    
    @Autowired
    private ChatboxService chatboxService;
    
    @Autowired
    private BotService botService;

    @PostMapping("/active-bot")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<BaseResponse<Boolean>> activeBotTx(ServletRequest servletRequest) {
        log.debug("REST request activeBot");
        String ipAddress = servletRequest.getRemoteAddr();
        BaseResponse<Boolean> result = null;
        try {
        	boolean isAc = batchTx.setEnableBot();
			log.info("activeBot is set to {} , IP Address ={}", isAc, ipAddress);
			result = new BaseResponse<Boolean>(Constants.OK, "SUCCESS", isAc);
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    
    @PostMapping("/get-status-bot-game")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<BaseResponse<Boolean>> getStatusBotGame(ServletRequest servletRequest) {
        log.debug("REST request get-status-bot-chat");
        BaseResponse<Boolean> result = null;
        try {
        	boolean status = batchTx.isEnableBot();
            log.info("activeBot is status {} ", status);
			result = new BaseResponse<Boolean>(Constants.OK, "Success", status);
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    
    @PostMapping("/active-bot-chat")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<BaseResponse<Boolean>> activeBotChat(ServletRequest servletRequest) {
        String ipAddress = servletRequest.getRemoteAddr();
        BaseResponse<Boolean> result = null;
        try {
        	boolean isActive = chatboxService.setStatusBot();
			log.info("activeBot is set to {} , IP Address ={}", isActive, ipAddress);
			result = new BaseResponse<Boolean>(Constants.OK, "SUCCESS", isActive);
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    
    @PostMapping("/get-status-bot-chat")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<BaseResponse<Boolean>> getStatusBotChat(ServletRequest servletRequest) {
        log.debug("REST request get-status-bot-chat");
        BaseResponse<Boolean> result = null;
        try {
        	boolean status = chatboxService.getStatusBot();
            log.info("activeBotBat is status {} ", status);
			result = new BaseResponse<Boolean>(Constants.OK, "Success", status);
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }

    @GetMapping("/maintain")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Boolean> getMaintenanceStatus() {
        log.debug("REST request to check if the current system is in maintenance");
        return ResponseEntity.ok().body(batchTx.isMaintain());
    }

    @PostMapping("/maintain")
    @PreAuthorize("hasRole('ADMIN')")
    public ResponseEntity<BaseResponse<Boolean>> maintainance(@RequestParam Boolean activeBot,
                                                              ServletRequest servletRequest) {
        log.debug("REST request activeBot  : {}", activeBot);
        String ipAddress = servletRequest.getRemoteAddr();
        BaseResponse<Boolean> result = null;
        try {
            if (activeBot == null) {
                result = new BaseResponse<>(Constants.FAIL, "activeSystem is null or empty");
            } else {
            	boolean isActive = batchTx.setMaintain();
                //return money user
                log.info("isActiveBot is set to {} , IP Address ={}", isActive, ipAddress);
                result = new BaseResponse<Boolean>(Constants.OK, "Pls wait for this session finish", isActive);
            }
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    
    
    
    
    @PostMapping("/upload-bot-chat")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<BaseResponse<Boolean>> uploadBotChat(@RequestParam("files") MultipartFile file,
                                                              ServletRequest servletRequest) {
		log.info("REST request uploadfile botchat , ipaddress ={} ", servletRequest.getRemoteAddr());
        BaseResponse<Boolean> result = null;
        try {
        	boolean isSuccess = botService.uploadBotChatFile(file);
        	if(isSuccess) {
        		result = new BaseResponse<>(Constants.OK,  "Uploaded the file successfully: " + file.getOriginalFilename() ,isSuccess);
        	}else {
        		result = new BaseResponse<>(Constants.FAIL,  "" ,isSuccess);
			}
        	
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    
    
    @PostMapping("/upload-bot-game")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<BaseResponse<Boolean>> uploadBotGame(@RequestParam("files") MultipartFile file,
                                                              ServletRequest servletRequest) {
    	log.info("REST request uploadfile botgame , ipaddress ={} ", servletRequest.getRemoteAddr());
        BaseResponse<Boolean> result = null;
        try {
        	boolean isSuccess = botService.uploadBotChatFile(file);
        	if(isSuccess) {
        		result = new BaseResponse<>(Constants.OK,  "Uploaded the file successfully: " + file.getOriginalFilename() ,isSuccess);
        	}else {
        		result = new BaseResponse<>(Constants.FAIL,  "" ,isSuccess);
			}
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Boolean>>(result, HttpStatus.OK);
    }
    @PostMapping("/set-win-lose-rate")
    @PreAuthorize("hasRole('ADMIN')")
	public ResponseEntity<BaseResponse<Integer>> setWinLose(@RequestParam("code") Integer code,
			ServletRequest servletRequest) {
        BaseResponse<Integer> result = null;
        try {
        	Integer isSuccess = batchTx.setWinCount(code);
        	result = new BaseResponse<>(Constants.OK, " successfully ", isSuccess);
        } catch (Exception e) {
            result = new BaseResponse<>(Constants.FAIL, e.getMessage());
        }
        return new ResponseEntity<BaseResponse<Integer>>(result, HttpStatus.OK);
    }
}
