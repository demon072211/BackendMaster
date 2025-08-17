package com.archie.config;

import com.archie.security.AuthoritiesConstants;
import org.springframework.context.annotation.Configuration;
import org.springframework.messaging.simp.SimpMessageType;
import org.springframework.security.config.annotation.web.messaging.MessageSecurityMetadataSourceRegistry;
import org.springframework.security.config.annotation.web.socket.AbstractSecurityWebSocketMessageBrokerConfigurer;

@Configuration
public class WebsocketSecurityConfiguration extends AbstractSecurityWebSocketMessageBrokerConfigurer {

    @Override
    protected void configureInbound(MessageSecurityMetadataSourceRegistry messages) {
        messages
            .nullDestMatcher().authenticated()
            .simpDestMatchers("/topic/chats").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/topic/backoffice").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/topic/bet").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)//for bet
            .simpDestMatchers("/topic/maintainstatus").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/queue/tx").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/topic/public").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/topic/lichsuphien").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .simpDestMatchers("/topic/ranktx").hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            //.simpDestMatchers("/topic/tracker").hasAuthority(AuthoritiesConstants.ADMIN)
            // matches any destination that starts with /topic/
            // (i.e. cannot send messages directly to /topic/)
            // (i.e. cannot subscribe to /topic/messages/* to get messages sent to
            // /topic/messages-user<id>)
            // message types other than MESSAGE and SUBSCRIBE
            .simpTypeMatchers(SimpMessageType.MESSAGE, SimpMessageType.SUBSCRIBE ).hasAnyAuthority(AuthoritiesConstants.USER, AuthoritiesConstants.ADMIN)
            .anyMessage().authenticated();
            // catch all
            //.anyMessage().denyAll();
    }

    /**
     * Disables CSRF for Websockets.
     */
    @Override
    protected boolean sameOriginDisabled() {
        return true;
    }
    
}
