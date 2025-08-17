package com.archie.service;

import com.archie.entity.Taixiu;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.util.LinkedList;
import java.util.Optional;

/**
 * Service Interface for managing {@link Taixiu}.
 */
public interface TaixiuService {
	
	Taixiu opennew();
	
	Taixiu updateOld(int[] result , long resultAmount);
	
	Long getTaixiuOpening();

    /**
     * Save a taixiu.
     *
     * @param taixiu the entity to save.
     * @return the persisted entity.
     */
    Taixiu save(Taixiu taixiu);
    
    void update(Long winloseAmount);

    /**
     * Get all the taixius.
     *
     * @param pageable the pagination information.
     * @return the list of entities.
     */
    Page<Taixiu> findAll(Pageable pageable);


    /**
     * Get the "id" taixiu.
     *
     * @param id the id of the entity.
     * @return the entity.
     */
    Optional<Taixiu> findOne(Long id);

    /**
     * Delete the "id" taixiu.
     *
     * @param id the id of the entity.
     */
    void delete(Long id);
    
    LinkedList<Taixiu> getLast100Record();
}
