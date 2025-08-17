package com.archie.service.impl;

import com.archie.service.BotService;
import com.archie.service.ChatboxService;
import com.archie.service.dto.WsChatDto;
import com.archie.util.CommonUtil;
import com.archie.config.Constants;
import com.archie.entity.Chatbox;
import com.archie.domain.Userinfo;
import com.archie.dao.ChatboxRepository;
import com.archie.repository.UserinfoRepository;
import com.archie.schedule.AsyncComponent;
import com.archie.schedule.BatchTaixiuBonus;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.scheduling.annotation.Async;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.SplittableRandom;
import java.util.concurrent.ConcurrentLinkedQueue;

import javax.annotation.PostConstruct;

/**
 * @author Archie
 * @date Oct 17, 2020
 */
@Service
public class ChatboxServiceImpl implements ChatboxService {

    private final Logger log = LoggerFactory.getLogger(ChatboxServiceImpl.class);

    private final ChatboxRepository chatboxRepository;
    
    @Autowired
    private BatchTaixiuBonus batch;
    
    private ConcurrentLinkedQueue<WsChatDto> lstDataPro =new ConcurrentLinkedQueue<WsChatDto>();
    
    @Autowired 
    private BotService botService;
    
    @Autowired 
    private UserinfoRepository userReposit;
    
	@Autowired
	private AsyncComponent asyncComponent;
	//private SimpMessagingTemplate template;
    
    private final SplittableRandom random = new SplittableRandom();
    
    public ChatboxServiceImpl(ChatboxRepository chatboxRepository) {
        this.chatboxRepository = chatboxRepository;
    }
	private boolean isActive = true;
    
    /**
	 * @return the lstData
	 */
    @Override
	public List<WsChatDto> findAll() {
    	if(lstDataPro==null ||lstDataPro.isEmpty()) {
    		init();
    	}
		return new ArrayList<WsChatDto>(lstDataPro);
	}

	@PostConstruct
	public void init() {
//		try {
//			List<Chatbox> re = chatboxRepository.findTop30ByOrderByIdDesc();
//			lstData.clear();
//			int i = re.size() - 1;
//			while (i >= 0) {
//				lstData.add(new WsChatDto(re.get(i)));
//				i--;
//			}
//		} catch (Exception e) {
//			log.error("Error " + e);
//			lstData = new LinkedList<WsChatDto>();
//		}
		try {
			List<Chatbox> re = chatboxRepository.findTop30ByOrderByIdDesc();
			lstDataPro.clear();
			int i = re.size() - 1;
			while (i >= 0) {
				lstDataPro.add(new WsChatDto(re.get(i)));
				i--;
			}
		} catch (Exception e) {
			log.error("Error " + e);
			lstDataPro = new ConcurrentLinkedQueue<WsChatDto>();
		}
	}
    
    @Override
	public Chatbox save(Chatbox chatbox) {
		return chatboxRepository.save(chatbox);
	}
    
    @Async("taskExecutor")
	public WsChatDto saveDb(WsChatDto input) {
		log.debug("Request to save Chatbox : {}", input);
		// save to file
		if(input.getCmd()!=1) {
			botService.writeToFile(input.getM());
		}
		input.setCmd(Constants.CMD_CHAT);
		Chatbox c = chatboxRepository.save(new Chatbox(input));
		input.setId(c.getId());
		addChatbox(input);
		return input;
	}
    
	public void addChatbox(WsChatDto input) {
		if (lstDataPro != null && !lstDataPro.isEmpty()) {
			if (lstDataPro.size() >= 30) {
				lstDataPro.poll();
				lstDataPro.add(input);
			} else {
				lstDataPro.add(input);
			}
		}else {
			lstDataPro.add(input);
		}
	}

    @Override
    @Transactional(readOnly = false)
    public Page<Chatbox> findAll(Pageable pageable) {
        log.debug("Request to get all Chatboxes");
        return chatboxRepository.findAll(pageable);
    }


    @Override
    @Transactional(readOnly = false)
    public Optional<Chatbox> findOne(Long id) {
        log.debug("Request to get Chatbox : {}", id);
        return chatboxRepository.findById(id);
    }

    @Override
    public void delete(Long id) {
        log.debug("Request to delete Chatbox : {}", id);
        chatboxRepository.deleteById(id);
    }

	@Override
	public WsChatDto save(WsChatDto chatbox) {
		String loginname =chatbox.getU();
		//check balance
		Optional<Userinfo> re = userReposit.findOneByNickName(loginname);
		if (!re.isPresent()) {
			return null;
		}
		if(chatbox.getM()==null ||chatbox.getM().equals("")) {
			log.error("Messsage is null orr empty");
			return null;
		}
		chatbox.setDt(CommonUtil.getCurDate("yyyy-MM-dd HH:sss"));
		
		return saveDb(chatbox);
	}

	@Scheduled(fixedRate = 3000)
	public void botChatAuto() {
		if (!isActive || batch.isMaintain())
			return;
		int ran = random.nextInt(3);
		int k = 0;
		while (k < ran) {
			k++;
			String mesage = botService.getMessage();
			String name = botService.getNamBot();
			if (mesage == null || mesage.equals("") || name == null || name.equals(""))
				continue;
			WsChatDto ob = new WsChatDto(name, mesage);
			addChatbox(ob);
			asyncComponent.sendMess(ob);
		}
		
	}
	
//	@Scheduled(fixedRate = 3000)
//	public void botsChatAuto() {
//		if (!isActive)
//			return;
//		int ran = random.nextInt(3);
//		int k = 0;
//		while (k < ran) {
//			k++;
//			String mesage = botService.getMessage();
//			String name = botService.getNamBot();
//			if (mesage == null || mesage.equals("") || name == null || name.equals(""))
//				continue;
//			WsChatDto ob = new WsChatDto(name, mesage);
//			addChatbox(ob);
//			sendMess(ob);
//		}
//		
//	}
	
	@Override
	public boolean setStatusBot() {
		if(this.isActive) {
			this.isActive = false;
		}else {
			this.isActive = true;
		}
		return this.isActive;
	}

	@Override
	public boolean getStatusBot() {
		return this.isActive;
	}

}
