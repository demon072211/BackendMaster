package com.archie.service;

import com.archie.domain.Userinfo;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.Optional;

/**
 * Service Interface for managing {@link Userinfo}.
 */
public interface UserinfoService {

    /**
     * Save a userinfo.
     *
     * @param userinfo the entity to save.
     * @return the persisted entity.
     */
    //void save(String loginname);

    /**
     * Get all the userinfos.
     *
     * @param pageable the pagination information.
     * @return the list of entities.
     */
    Page<Userinfo> findAll(Pageable pageable);


    /**
     * Get the "id" userinfo.
     *
     * @param id the id of the entity.
     * @return the entity.
     */
    Optional<Userinfo> findOne(Long id);

    /**
     * Delete the "id" userinfo.
     *
     * @param id the id of the entity.
     */
    void delete(Long id);
}
