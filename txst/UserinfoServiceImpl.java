package com.archie.service.impl;

import com.archie.service.UserinfoService;
import com.archie.domain.Userinfo;
import com.archie.repository.UserinfoRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.Optional;

/**
 * Service Implementation for managing {@link Userinfo}.
 */
@Service
@Transactional
public class UserinfoServiceImpl implements UserinfoService {

    private final Logger log = LoggerFactory.getLogger(UserinfoServiceImpl.class);

    private final UserinfoRepository userinfoRepository;

    public UserinfoServiceImpl(UserinfoRepository userinfoRepository) {
        this.userinfoRepository = userinfoRepository;
    }

    @Override
    @Transactional(readOnly = false)
    public Page<Userinfo> findAll(Pageable pageable) {
        log.debug("Request to get all Userinfos");
        return userinfoRepository.findAll(pageable);
    }


    @Override
    @Transactional(readOnly = false)
    public Optional<Userinfo> findOne(Long id) {
        log.debug("Request to get Userinfo : {}", id);
        return userinfoRepository.findById(id);
    }

    @Override
    public void delete(Long id) {
        log.debug("Request to delete Userinfo : {}", id);
        userinfoRepository.deleteById(id);
    }
}
