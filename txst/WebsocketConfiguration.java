package com.archie.config;

import com.archie.api.ChatboxApi;
import com.archie.security.AuthoritiesConstants;
import com.archie.security.jwt.TokenProvider;

import java.security.Principal;
import java.util.*;

import javax.servlet.ServletRequest;
import javax.servlet.http.HttpServletRequest;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.autoconfigure.task.TaskExecutionProperties;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.http.server.*;
import org.springframework.messaging.simp.config.ChannelRegistration;
import org.springframework.messaging.simp.config.MessageBrokerRegistry;
import org.springframework.security.authentication.AnonymousAuthenticationToken;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.util.StringUtils;
import org.springframework.web.socket.WebSocketHandler;
import org.springframework.web.socket.config.annotation.*;
import org.springframework.web.socket.server.HandshakeInterceptor;
import org.springframework.web.socket.server.support.DefaultHandshakeHandler;

import io.github.jhipster.config.JHipsterProperties;

@Configuration
@EnableWebSocketMessageBroker
public class WebsocketConfiguration implements WebSocketMessageBrokerConfigurer {
	
	
    public static final String IP_ADDRESS = "IP_ADDRESS";
    public static final String AUTHORIZATION_HEADER = "Authorization";

    private final TaskExecutionProperties taskExecutionProperties;
    
    private final JHipsterProperties propertiesConfig;

	public WebsocketConfiguration(JHipsterProperties jHipsterProperties,
			TaskExecutionProperties taskExecutionProperties) {
		this.propertiesConfig = jHipsterProperties;
		this.taskExecutionProperties = taskExecutionProperties;
	}
	
    @Override
    public void configureMessageBroker(MessageBrokerRegistry config) {
        config.enableSimpleBroker("/topic","/queue");//server-> client
        //config.setApplicationDestinationPrefixes("/ws");
        //config.setPreservePublishOrder(true);
    }

    @Override
    public void registerStompEndpoints(StompEndpointRegistry registry) {
        String[] allowedOrigins = Optional.ofNullable(
        		   propertiesConfig.getCors()
					        		.getAllowedOrigins())
					        		.map(origins ->  origins.toArray(new String[0]))
					        		.orElse(new String[0]);
        //@SendTo STOMP endpoints
        registry.addEndpoint("/websocket/ws-taixiu")
            .setHandshakeHandler(defaultHandshakeHandler())
            .setAllowedOrigins(allowedOrigins)
            .withSockJS()
            .setClientLibraryUrl("https://cdnjs.cloudflare.com/ajax/libs/sockjs-client/1.5.1/sockjs.min.js")
            .setInterceptors(httpSessionHandshakeInterceptor());
    }

	public static String getIpAddress(HttpServletRequest request) {
		String ipAddress = request.getHeader("X-FORWARDED-FOR");
		if (ipAddress == null) {
			ipAddress = request.getRemoteAddr();
		}
		String clientIp = null;
		if (ipAddress != null && !"".equals(ipAddress)) {
			String[] arrayIp = ipAddress.split(",");
			if(arrayIp.length>0) {
				clientIp = arrayIp[0].trim();
			}
		}
		return clientIp;
	}

	@Bean
	public HandshakeInterceptor httpSessionHandshakeInterceptor() {
		return new HandshakeInterceptor() {
			@Override
			public boolean beforeHandshake(ServerHttpRequest request, ServerHttpResponse response, WebSocketHandler wsHandler, Map<String, Object> attributes) throws Exception {
				
				if (request instanceof ServletServerHttpRequest) {
					ServletServerHttpRequest servletRequest = (ServletServerHttpRequest) request;
					attributes.put(IP_ADDRESS, servletRequest.getRemoteAddress());
				}
				return true;
			}

			@Override
			public void afterHandshake(ServerHttpRequest request, ServerHttpResponse response,
					WebSocketHandler wsHandler, Exception exception) {
			}
		};
	}
//	 
//    @Bean
//    public HandshakeInterceptor httpSessionHandshakeInterceptor() {
//        return new HandshakeInterceptor() {
//
//            @Override
//            public boolean beforeHandshake(ServerHttpRequest request, ServerHttpResponse response, WebSocketHandler wsHandler, Map<String, Object> attributes) throws Exception {
//                if (request instanceof ServletServerHttpRequest) {
////                	log.error("bearerToken1={}", request.getHeaders());
//                    ServletServerHttpRequest servletRequest = (ServletServerHttpRequest) request;
//                    getIpAddress(servletRequest.getServletRequest());
//                    attributes.put(IP_ADDRESS, servletRequest.getRemoteAddress());
//                    String loginname = doFilter(servletRequest.getServletRequest());
//                    attributes.put(LOGINNAME, loginname);
//                }
//                
////                else {
////                	log.error("bearerToken2={}",request.getHeaders());
////				}
////                if (request instanceof WebSocketFrame) {
////                	log.error("bearerToken3={}");
////                }
////                log.error("bearerToken uri={}",request.getURI());
////                try {
////                	log.error("bearerToken3={}",request.get);
////				} catch (Exception e) {
////					// TODO: handle exception
////				}
//                return true;
//            }
//
//            @Override
//            public void afterHandshake(ServerHttpRequest request, ServerHttpResponse response, WebSocketHandler wsHandler, Exception exception) {
//            	
//            }	
//        };
//    }

    private DefaultHandshakeHandler defaultHandshakeHandler() {
        return new DefaultHandshakeHandler() {
            @Override
            protected Principal determineUser(ServerHttpRequest request, WebSocketHandler wsHandler, Map<String, Object> attributes) {
                Principal principal = request.getPrincipal();
                if (principal == null) {
                    Collection<SimpleGrantedAuthority> authorities = new ArrayList<>();
                    authorities.add(new SimpleGrantedAuthority(AuthoritiesConstants.ANONYMOUS));
                    principal = new AnonymousAuthenticationToken("WebsocketConfiguration", "anonymous", authorities);
                }
                return principal;
            }
        };
    }

	@Override
	public void configureWebSocketTransport(WebSocketTransportRegistration registry) {
		registry.setMessageSizeLimit(2 * 64 * 1024); // default : 64 * 1024
		registry.setSendTimeLimit(10 * 10000); // default : 10 * 10000
		registry.setSendBufferSizeLimit(3 * 512 * 1024); // default : 512 * 1024
	}
    

	@Override
	public void configureClientOutboundChannel(ChannelRegistration registration) {
		registration.taskExecutor().corePoolSize(taskExecutionProperties.getPool().getCoreSize())
				.queueCapacity(taskExecutionProperties.getPool().getQueueCapacity())
				.maxPoolSize(taskExecutionProperties.getPool().getMaxSize());
		WebSocketMessageBrokerConfigurer.super.configureClientOutboundChannel(registration);
	}
    
}
