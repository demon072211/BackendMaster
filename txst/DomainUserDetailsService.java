package com.archie.security;

import java.util.List;
import java.util.Locale;
import java.util.Optional;
import java.util.stream.Collectors;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;
import org.springframework.transaction.annotation.Transactional;

import com.archie.domain.Userinfo;
import com.archie.repository.UserinfoRepository;

/**
 * @author Archie
 * @date Sep 18, 2020
 */
@Component("userDetailsService")
public class DomainUserDetailsService implements UserDetailsService {

    private final Logger log = LoggerFactory.getLogger(DomainUserDetailsService.class);

    //private final UserRepository userRepository;
    
    private final UserinfoRepository userRepository;
    
    private final PasswordEncoder passwordEncoder;
    
    public DomainUserDetailsService(UserinfoRepository userRepository ,PasswordEncoder passwordEncoder) {
        this.userRepository = userRepository;
        this.passwordEncoder =passwordEncoder;
    }
    

    @Override
    @Transactional
    public UserDetails loadUserByUsername(final String login) {
        String lowercaseLogin = login.toLowerCase(Locale.ENGLISH);
        Optional<Userinfo> usero = userRepository.findOneWithAuthoritiesByLoginname(login);
        if(!usero.isPresent()) {
        	throw new UsernameNotFoundException("Tài khoản không tồn tại");
        }else {
        	Userinfo user = usero.get();
        	return createSpringSecurityUser(lowercaseLogin, user);
		}
//        return userRepository.findOneWithAuthoritiesByLoginname(lowercaseLogin)
//            .map(user -> createSpringSecurityUser(lowercaseLogin, user))
//            .orElseThrow(() -> new UsernameNotFoundException("User " + lowercaseLogin + " was not found in the database"));

    }

    private org.springframework.security.core.userdetails.User createSpringSecurityUser(String lowercaseLogin, Userinfo user) {
        List<GrantedAuthority> grantedAuthorities = user.getAuthorities().stream()
            .map(authority -> new SimpleGrantedAuthority(authority.getName()))
            .collect(Collectors.toList());
        return new org.springframework.security.core.userdetails.User(user.getLoginname(),
        		getPassword(user.getPwd()),
            grantedAuthorities);
    }
    
    private String getPassword(String password) {
        return password;
    }
}
