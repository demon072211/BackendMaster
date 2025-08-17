package com.archie.service;

import com.archie.entity.TaixiuRecord;
import com.archie.service.dto.TKTaiXiuDTO;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.web.websocket.dto.WsResponse;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import java.time.Instant;
import java.util.List;
import java.util.Optional;

/**
 * Service Interface for managing {@link TaixiuRecord}.
 */
public interface TaixiuRecordService {
	/**
	 * Save a taixiu bet Record.
	 *
	 * @param taixiuRecord the entity to save.
	 * @return the persisted entity.
	 */
	WsResponse<TaiXiuBetDTO> save(TaiXiuBetDTO taixiuRecord) throws Exception;

	/**
	 * Save a taixiuRecord.
	 *
	 * @param taixiuRecord the entity to save.
	 * @return the persisted entity.
	 */
	TaixiuRecord save(TaixiuRecord taixiuRecord);
	
	
	List<TaixiuRecord> saveAll(List<TaixiuRecord> lstData);

	/**
	 * Get all the taixiuRecords.
	 *
	 * @param pageable the pagination information.
	 * @return the list of entities.
	 * 
	 */
	Page<TaixiuRecord> filter(Pageable pageable, String loginname, Long luotxo, Integer type, Integer status,
			Integer userType, Instant starttime, Instant enTime);

	Page<TaixiuRecord> findAll(Pageable pageable);

	Page<TaixiuRecord> findByLoginname(Pageable pageable, String loginname);

	/**
	 * Get the "id" taixiuRecord.
	 *
	 * @param id the id of the entity.
	 * @return the entity.
	 */
	Optional<TaixiuRecord> findOne(Long id);

	/**
	 * Delete the "id" taixiuRecord.
	 *
	 * @param id the id of the entity.
	 */
	void delete(Long id);

	List<TaixiuRecord> findAllByTaiXiuId(long id);

	TKTaiXiuDTO findAllByPhienId(long id);
}
