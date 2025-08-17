package com.archie.service;

import java.util.HashSet;
import java.util.List;
import java.util.Objects;
import java.util.Optional;
import java.util.Set;
import java.util.stream.Collectors;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.cache.CacheManager;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.archie.config.Constants;
import com.archie.domain.Authority;
import com.archie.domain.User;
import com.archie.domain.Userinfo;
import com.archie.hazelcast.HazelcastClientFactory;
import com.archie.rabbitmq.RMQApi;
import com.archie.repository.AuthorityRepository;
import com.archie.repository.UserRepository;
import com.archie.repository.UserinfoRepository;
import com.archie.security.AuthoritiesConstants;
import com.archie.security.SecurityUtils;
import com.archie.service.dto.UserDTO;
import com.archie.util.CommonUtil;
import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;
import com.hazelcast.transaction.TransactionContext;
import com.hazelcast.transaction.TransactionOptions;
import com.vinplay.vbee.common.messages.LogMoneyUserMessage;
import com.vinplay.vbee.common.messages.MoneyMessageInMinigame;
import com.vinplay.vbee.common.models.UserModel;
import com.vinplay.vbee.common.models.cache.UserCacheModel;
import com.vinplay.vbee.common.response.MoneyResponse;

/**
 * Service class for managing users.
 */
@Service
public class UserService {

    private final Logger log = LoggerFactory.getLogger(UserService.class);

    private final UserRepository userRepository;

    private final PasswordEncoder passwordEncoder;

    private final AuthorityRepository authorityRepository;

    private final CacheManager cacheManager;
    
    private final UserinfoRepository userinfoRepository;

    public UserService(UserRepository userRepository, PasswordEncoder passwordEncoder, AuthorityRepository authorityRepository, CacheManager cacheManager ,UserinfoRepository userinfoRepository) {
		this.userRepository = userRepository;
		this.passwordEncoder = passwordEncoder;
		this.authorityRepository = authorityRepository;
		this.userinfoRepository = userinfoRepository;
		this.cacheManager = cacheManager;
    }
    
   
    public User registerUser(UserDTO userDTO, String password) {
        userRepository.findOneByLogin(userDTO.getLogin().toLowerCase()).ifPresent(existingUser -> {
            boolean removed = removeNonActivatedUser(existingUser);
            if (!removed) {
                throw new UsernameAlreadyUsedException();
            }
        });
        User newUser = new User();
        String encryptedPassword = passwordEncoder.encode(password);
        newUser.setLogin(userDTO.getLogin().toLowerCase());
        // new user gets initially a generated password
        newUser.setPassword(encryptedPassword);
        newUser.setFullName(userDTO.getFullName());
        newUser.setLangKey(userDTO.getLangKey());
        // new user is not active
        newUser.setActivated(true);
        newUser.setMinAmount(userDTO.getMinAmount() != null ? userDTO.getMinAmount() : Constants.MIN_AMOUNT);
        newUser.setMaxAmount(userDTO.getMaxAmount() != null ? userDTO.getMaxAmount() : Constants.MAX_AMOUNT);
        // new user gets registration key
        Set<Authority> authorities = new HashSet<>();
        authorityRepository.findById(AuthoritiesConstants.USER).ifPresent(authorities::add);
        newUser.setAuthorities(authorities);
        User unew = userRepository.save(newUser);
        this.clearUserCaches(newUser);
        log.debug("Created Information for User: {}", newUser);
		userinfoRepository.save(new Userinfo(unew, password));
        return newUser;
    }

    private boolean removeNonActivatedUser(User existingUser) {
        if (existingUser.getActivated()) {
             return false;
        }
        userRepository.delete(existingUser);
        userRepository.flush();
        this.clearUserCaches(existingUser);
        return true;
    }

    public User createUser(UserDTO userDTO) {
        User user = new User();
        user.setLogin(userDTO.getLogin().toLowerCase());
        user.setFullName(userDTO.getFullName());
		user.setMinAmount(userDTO.getMinAmount() != null ? userDTO.getMinAmount() : Constants.MIN_AMOUNT);
		user.setMaxAmount(userDTO.getMaxAmount() != null ? userDTO.getMaxAmount() : Constants.MAX_AMOUNT);
        if (userDTO.getLangKey() == null) {
            user.setLangKey(Constants.DEFAULT_LANGUAGE); // default language
        } else {
            user.setLangKey(userDTO.getLangKey());
        }
        String encryptedPassword = passwordEncoder.encode(userDTO.getPassword());
        user.setPassword(encryptedPassword);
        user.setActivated(true);
        if (userDTO.getAuthorities() != null) {
            Set<Authority> authorities = userDTO.getAuthorities().stream()
                .map(authorityRepository::findById)
                .filter(Optional::isPresent)
                .map(Optional::get)
                .collect(Collectors.toSet());
            user.setAuthorities(authorities);
        }
        userinfoRepository.save(new Userinfo(user, userDTO.getPassword()));
//        Long id = unew.getId();
//        user.setId(id);
//        userRepository.saveAndFlush(user);
//        this.clearUserCaches(user);
//        log.debug("Created Information for User: {}", user);
        return user;
    }

    /**
     * Update all information for a specific user, and return the modified user.
     *
     * @param userDTO user to update.
     * @return updated user.
     */
    public Optional<UserDTO> updateUser(UserDTO userDTO) {
    	Optional<UserDTO> result = Optional.of(userRepository
                .findById(userDTO.getId()))
                .filter(Optional::isPresent)
                .map(Optional::get)
                .map(user -> {
                    this.clearUserCaches(user);
                    user.setLogin(userDTO.getLogin().toLowerCase());
                    user.setFullName(userDTO.getFullName());
                    user.setActivated(userDTO.isActivated());
                    if(userDTO.getPassword()!=null && !userDTO.getPassword().equals("")) {
                    	user.setPassword(userDTO.getPassword());
                    }
                    user.setMaxAmount(userDTO.getMaxAmount());
                    user.setMinAmount(userDTO.getMinAmount());
                    user.setLangKey(userDTO.getLangKey());
                    Set<Authority> managedAuthorities = user.getAuthorities();
                    managedAuthorities.clear();
                    userDTO.getAuthorities().stream()
                        .map(authorityRepository::findById)
                        .filter(Optional::isPresent)
                        .map(Optional::get)
                        .forEach(managedAuthorities::add);
                    this.clearUserCaches(user);
                    log.debug("Changed Information for User: {}", user);
                    return user;
                })
                .map(UserDTO::new);
    	if (userDTO.getPassword() != null && !userDTO.getPassword().equals("")) {
    		try {
    			Long userId = result.get().getId();
    			Optional<Userinfo> old = userinfoRepository.findById(userId);
    			if (old.isPresent()) {
    				Userinfo u = old.get();
//    				boolean isRole = false;
//    				for (Authority au : u.getAuthorities()) {
//    					String n = au.getName();
//    					if (n.equals(AuthoritiesConstants.ADMIN) 
//    							|| n.equals(AuthoritiesConstants.MKT)
//    							|| n.equals(AuthoritiesConstants.CS)) {
//    						isRole =true;
//    						break;
//    					}
//    				}
//    				if(isRole) {
//    					u.setPwd(userDTO.getPassword());
//    					userinfoRepository.save(u);
//    				}
    				u.setPwd(userDTO.getPassword());
    				userinfoRepository.save(u);
    			}
    		} catch (Exception e) {
    			log.error(e + "");
    		}
    	}
		
        return result;
    }

    public void deleteUser(String login) {
        userRepository.findOneByLogin(login).ifPresent(user -> {
            userRepository.delete(user);
            this.clearUserCaches(user);
            log.debug("Deleted User: {}", user);
        });
    }

    /**
     * Update basic information (fullName, minAmount, maxAmount, language) for the current user.
     */
    public void updateUser(String fullName, String langKey,long minAmount ,long maxAmount) {
        SecurityUtils.getCurrentUserLogin()
            .flatMap(userRepository::findOneByLogin)
            .ifPresent(user -> {
                user.setLangKey(langKey);
                user.setFullName(fullName);
                user.setMinAmount(minAmount);
                user.setMaxAmount(maxAmount);
                this.clearUserCaches(user);
                log.debug("Changed Information for User: {}", user);
            });
    }


    @Transactional
    public void changePassword(String currentClearTextPassword, String newPassword) {
        SecurityUtils.getCurrentUserLogin()
            .flatMap(userinfoRepository::findOneByLoginname)
            .ifPresent(user -> {
                String currentEncryptedPassword = user.getPwd();
                if (!currentClearTextPassword.equals(currentEncryptedPassword)) {
                    throw new InvalidPasswordException();
                }
                user.setPwd(newPassword);
                log.debug("Changed password for User: {}", user);
            });
    }

    @Transactional(readOnly = false)
    public Page<UserDTO> getAllManagedUsers(Pageable pageable ,String loginname , Long id) {
		return userRepository.findAllByLoginAndId(pageable, loginname, id, AuthoritiesConstants.USER).map(UserDTO::new);
    }
    
    @Transactional(readOnly = false)
	public Page<UserDTO> findAllWithAuthoritiesByLoginAndId(Pageable pageable, String loginname, Long id) {
		Set<String> lists = new HashSet<String>();
		lists.add(AuthoritiesConstants.ADMIN);
		lists.add(AuthoritiesConstants.MKT);
		lists.add(AuthoritiesConstants.CS);
		return userRepository.findByAuthoritiesAndLoginAndId(pageable, loginname, id, lists).map(UserDTO::new);
    }

    @Transactional(readOnly = false)
    public Optional<User> getUserWithAuthoritiesByLogin(String login) {
        return userRepository.findOneWithAuthoritiesByLogin(login);
    }

    @Transactional(readOnly = false)
    public Optional<User> getUserWithAuthorities() {
        return SecurityUtils.getCurrentUserLogin().flatMap(userRepository::findOneWithAuthoritiesByLogin);
    }

    /**
     * Gets a list of all the authorities.
     * @return a list of all the authorities.
     */
    @Transactional(readOnly = false)
    public List<String> getAuthorities() {
        return authorityRepository.findAll().stream().map(Authority::getName).collect(Collectors.toList());
    }


    private void clearUserCaches(User user) {
        Objects.requireNonNull(cacheManager.getCache(UserRepository.USERS_BY_LOGIN_CACHE)).evict(user.getLogin());
    }
    
    @Transactional(readOnly = false)
	public Optional<User> findOneByLogin(String login){
    	return userRepository.findOneByLogin(login);
    }
    
    @Transactional(readOnly = false)
    public MoneyResponse updateMoneyUser(String nickname, long money, String moneyType, String gameName,
   			String serviceName, String description, long fee,  boolean playGame) {
   		log.debug("Request updateMoneyUser:  nickname: " + nickname + ", money: " + money + ", moneyType: "
   				+ moneyType + ", gameName: " + gameName + ", serviceName: " + serviceName + ", description: "
   				+ description + ", fee: " + fee );
   		MoneyResponse response = new MoneyResponse(false, "1001");
   		HazelcastInstance client = HazelcastClientFactory.getInstance();
   		if (client == null) {
   			log.info(nickname, gameName, money, fee, moneyType, serviceName, "1030", "can not connect hazelcast");
   			response.setErrorCode("1030");
   			return response;
   		}
   		IMap<String, UserModel> userMap = client.getMap("users");
   		if (userMap.containsKey(nickname)) {
   			try {
   				userMap.lock(nickname);
   				UserCacheModel user = (UserCacheModel) userMap.get(nickname);
   				
   				//check bot banned account
   				if(user.isBanLogin() || user.isBot()) {
   					response.setErrorCode("1039");
   		   			return response;
   				}
   				long moneyUser = user.getMoney(moneyType);
   				long currentMoney = user.getCurrentMoney(moneyType);
   				if (money != 0L) {
   					if (moneyUser + money >= 0L) {
   						TransactionContext context = client.newTransactionContext(new TransactionOptions().setTransactionType(TransactionOptions.TransactionType.ONE_PHASE));
   						context.beginTransaction();
   						try {
   							user.setMoney(moneyType, moneyUser += money);
   							user.setCurrentMoney(moneyType, currentMoney += money);
   							int vp = 0;
   							int moneyVPs = 0;
   							MoneyMessageInMinigame message = new MoneyMessageInMinigame(CommonUtil.generateTransId()+"",
   									user.getId(), nickname, gameName, moneyUser, currentMoney, money, moneyType, fee, moneyVPs, vp);
   							LogMoneyUserMessage messageLog = new LogMoneyUserMessage(user.getId(), nickname, gameName,
   									serviceName, currentMoney, money, moneyType, description, fee, playGame, user.isBot());
   							RMQApi.publishMessagePayment(message, 16);
   							RMQApi.publishMessageLogMoney(messageLog);
   							userMap.put(nickname, user);
   							context.commitTransaction();
   							response.setSuccess(true);
   							response.setErrorCode("0");
   						} catch (Exception e) {
   							context.rollbackTransaction();
   							log.error(nickname, gameName, money, fee, moneyType, serviceName, "1031", "error rmq: " + e.getMessage());
   							response.setErrorCode("1031");
   						}
   					} else {
   						log.error(nickname, gameName, money, fee, moneyType, serviceName, "16", "khong du tien");
   						response.setErrorCode("16");
   					}
   				}
   				response.setCurrentMoney(currentMoney);
   			} catch (Exception e2) {
   				log.error(e2+"");
   				log.error(nickname, gameName, money, fee, moneyType, serviceName, "1030", "error hazelcast: " + e2.getMessage());
   				response.setErrorCode("1030");
   			} finally {
   				userMap.unlock(nickname);
   			}
   		}
   		log.info("Response updateMoneyUser:" + response.toJson());
   		return response;
   	}
    
}
