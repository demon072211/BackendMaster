package com.archie.service.impl;

import com.archie.service.TaixiuService;
import com.archie.entity.Taixiu;
import com.archie.dao.TaixiuRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.time.LocalDateTime;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.Optional;
import java.util.concurrent.atomic.AtomicLong;

import javax.annotation.PostConstruct;

/**
 * Service Implementation for managing {@link Taixiu}.
 * @author Archie
 * @date Sep 18, 2020
 */
@Service
public class TaixiuServiceImpl implements TaixiuService {

	private final Logger log = LoggerFactory.getLogger(TaixiuServiceImpl.class);

	private final TaixiuRepository taixiuRepository;

	private AtomicLong taixiuOpening = new AtomicLong();
	
	private AtomicLong totalWinlose = new AtomicLong();

	private LinkedList<Taixiu> lastRecord = new LinkedList<Taixiu>();

	public TaixiuServiceImpl(TaixiuRepository taixiuRepository) {
		this.taixiuRepository = taixiuRepository;
	}

	@PostConstruct
	private void init() {
		try {
			lastRecord = new LinkedList<Taixiu>(taixiuRepository.findTop100ByOrderByIdDesc());
		} catch (Exception e) {
			log.error(e.getMessage());
			lastRecord = new LinkedList<Taixiu>();
		}
		
	}

	@Override
	public Taixiu save(Taixiu taixiu) {
		log.debug("Request to save Taixiu : {}", taixiu);
		return taixiuRepository.save(taixiu);
	}

	@Override
	@Transactional(readOnly = false)
	public Page<Taixiu> findAll(Pageable pageable) {
		log.debug("Request to get all Taixius");
		return taixiuRepository.findAll(pageable);
	}

	@Override
	@Transactional(readOnly = false)
	public Optional<Taixiu> findOne(Long id) {
		log.debug("Request to get Taixiu : {}", id);
		return taixiuRepository.findById(id);
	}

	@Override
	public void delete(Long id) {
		log.debug("Request to delete Taixiu : {}", id);
		taixiuRepository.deleteById(id);
	}

	@Override
	public Taixiu opennew() {
		Taixiu newOpen = new Taixiu();
		newOpen.setId(null);
		newOpen.setStatus(1);
		newOpen.setEndtime(null);
		newOpen.setOpentime(LocalDateTime.now());
		// save db
		Taixiu taixiuOpeningObj = taixiuRepository.save(newOpen);
		if(taixiuOpeningObj==null ||taixiuOpeningObj.getId() ==null) {
			return null;
		}
		taixiuOpening.getAndSet(taixiuOpeningObj.getId());
		return taixiuOpeningObj;
	}

	@Override
	public Taixiu updateOld(int[] result ,long resultAmount) {
		Optional<Taixiu> oldTaixiuOp = taixiuRepository.findById(taixiuOpening.get());
		if (oldTaixiuOp.isPresent()) {
			Taixiu oldTaixiu = oldTaixiuOp.get();
			oldTaixiu.setStatus(0);
			oldTaixiu.setEndtime(LocalDateTime.now());
			oldTaixiu.setResult(Arrays.toString(result));
			oldTaixiu.setResultAmount(resultAmount);
			if (lastRecord != null && !lastRecord.isEmpty()) {
				if (lastRecord.size() >= 100) {
					lastRecord.removeLast();
					lastRecord.addFirst(oldTaixiu);
				} else {
					lastRecord.addFirst(oldTaixiu);
				}
			}
			return taixiuRepository.save(oldTaixiu);
		}
		return null;
	}

	/**
	 * @return the taixiuOpening
	 */
	@Override
	public Long getTaixiuOpening() {
		return taixiuOpening.get();
	}


	@Override
	public LinkedList<Taixiu> getLast100Record() {
		return lastRecord;
	}

	@Override
	public void update(Long winloseAmount) {
		Optional<Taixiu> oldTaixiuOp = taixiuRepository.findById(taixiuOpening.get());
		if (oldTaixiuOp.isPresent()) {
			Taixiu oldTaixiu = oldTaixiuOp.get();
			oldTaixiu.setTwin(winloseAmount);
			taixiuRepository.save(oldTaixiu);
		}
		totalWinlose.getAndSet(winloseAmount);
	}

}
