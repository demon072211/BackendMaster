package com.archie.api;

import com.archie.entity.Chatbox;
import com.archie.service.ChatboxService;
import com.archie.service.dto.WsChatDto;
import com.archie.web.rest.errors.BadRequestAlertException;

import io.github.jhipster.web.util.HeaderUtil;
import io.github.jhipster.web.util.PaginationUtil;
import io.github.jhipster.web.util.ResponseUtil;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;
import org.springframework.http.ResponseEntity;
import org.springframework.messaging.handler.annotation.MessageMapping;
import org.springframework.messaging.handler.annotation.Payload;
import org.springframework.messaging.handler.annotation.SendTo;
import org.springframework.messaging.simp.stomp.StompHeaderAccessor;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.net.URISyntaxException;
import java.security.Principal;
import java.util.List;
import java.util.Optional;

/**
 * REST controller for managing {@link com.archie.domain.Chatbox}.
 */
@RestController
@RequestMapping("/api")
public class ChatboxApi {

    private final Logger log = LoggerFactory.getLogger(ChatboxApi.class);

    private static final String ENTITY_NAME = "chatbox";

    @Value("${jhipster.clientApp.name}")
    private String applicationName;

    private final ChatboxService chatboxService;

    public ChatboxApi(ChatboxService chatboxService) {
        this.chatboxService = chatboxService;
    }

    /**
     * {@code POST  /chatboxes} : Create a new chatbox.
     *
     * @param chatbox the chatbox to create.
     * @return the {@link ResponseEntity} with status {@code 201 (Created)} and with body the new chatbox, or with status {@code 400 (Bad Request)} if the chatbox has already an ID.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PostMapping("/chatboxes")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Chatbox> createChatbox(@RequestBody Chatbox chatbox) throws URISyntaxException {
        log.debug("REST request to save Chatbox : {}", chatbox);
        if (chatbox.getId() != null) {
            throw new BadRequestAlertException("A new chatbox cannot already have an ID", ENTITY_NAME, "idexists");
        }
        Chatbox result = chatboxService.save(chatbox);
        return ResponseEntity.created(new URI("/api/chatboxes/" + result.getId()))
            .headers(HeaderUtil.createEntityCreationAlert(applicationName, true, ENTITY_NAME, result.getId().toString()))
            .body(result);
    }
    
    @PostMapping("/xchatboxes")
	public WsChatDto sendMessage(@RequestBody WsChatDto chatbox) {
		//sendOneMessage(chat);
		return chatboxService.save(chatbox);
	}
	

    /**
     * {@code PUT  /chatboxes} : Updates an existing chatbox.
     *
     * @param chatbox the chatbox to update.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the updated chatbox,
     * or with status {@code 400 (Bad Request)} if the chatbox is not valid,
     * or with status {@code 500 (Internal Server Error)} if the chatbox couldn't be updated.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PutMapping("/chatboxes")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Chatbox> updateChatbox(@RequestBody Chatbox chatbox) throws URISyntaxException {
        log.debug("REST request to update Chatbox : {}", chatbox);
        if (chatbox.getId() == null) {
            throw new BadRequestAlertException("Invalid id", ENTITY_NAME, "idnull");
        }
        Chatbox result = chatboxService.save(chatbox);
        return ResponseEntity.ok()
            .headers(HeaderUtil.createEntityUpdateAlert(applicationName, true, ENTITY_NAME, chatbox.getId().toString()))
            .body(result);
    }

    /**
     * {@code GET  /chatboxes} : get all the chatboxes.
     *
     * @param pageable the pagination information.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and the list of chatboxes in body.
     */
    @GetMapping("/chatboxes")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<List<Chatbox>> getAllChatboxes(Pageable pageable) {
        log.debug("REST request to get a page of Chatboxes");
        Page<Chatbox> page = chatboxService.findAll(pageable);
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(ServletUriComponentsBuilder.fromCurrentRequest(), page);
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

    /**
     * {@code GET  /chatboxes/:id} : get the "id" chatbox.
     *
     * @param id the id of the chatbox to retrieve.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the chatbox, or with status {@code 404 (Not Found)}.
     */
    @GetMapping("/chatboxes/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Chatbox> getChatbox(@PathVariable Long id) {
        log.debug("REST request to get Chatbox : {}", id);
        Optional<Chatbox> chatbox = chatboxService.findOne(id);
        return ResponseUtil.wrapOrNotFound(chatbox);
    }

    /**
     * {@code DELETE  /chatboxes/:id} : delete the "id" chatbox.
     *
     * @param id the id of the chatbox to delete.
     * @return the {@link ResponseEntity} with status {@code 204 (NO_CONTENT)}.
     */
    @DeleteMapping("/chatboxes/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Void> deleteChatbox(@PathVariable Long id) {
        log.debug("REST request to delete Chatbox : {}", id);
        chatboxService.delete(id);
        return ResponseEntity.noContent().headers(HeaderUtil.createEntityDeletionAlert(applicationName, true, ENTITY_NAME, id.toString())).build();
    }
}
