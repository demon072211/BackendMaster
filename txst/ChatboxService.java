package com.archie.service;

import com.archie.entity.Chatbox;
import com.archie.service.dto.WsChatDto;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.List;
import java.util.Optional;

/**
 * Service Interface for managing {@link Chatbox}.
 */
public interface ChatboxService {

    /**
     * Save a chatbox.
     *
     * @param chatbox the entity to save.
     * @return the persisted entity.
     */
    Chatbox save(Chatbox chatbox);
    
    WsChatDto save(WsChatDto chatbox);
     
    /**
     * Get all the chatboxes.
     *
     * @param pageable the pagination information.
     * @return the list of entities.
     */
    Page<Chatbox> findAll(Pageable pageable);


    /**
     * Get the "id" chatbox.
     *
     * @param id the id of the entity.
     * @return the entity.
     */
    Optional<Chatbox> findOne(Long id);

    /**
     * Delete the "id" chatbox.
     *
     * @param id the id of the entity.
     */
    void delete(Long id);
    
    boolean setStatusBot();
    
    boolean getStatusBot();
    
    List<WsChatDto> findAll();
}
