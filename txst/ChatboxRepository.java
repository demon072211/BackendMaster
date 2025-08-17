package com.archie.dao;


import java.util.List;

import javax.persistence.PersistenceContext;

import org.springframework.data.jpa.repository.*;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;

import com.archie.entity.Chatbox;

/**
 * Spring Data  repository for the Chatbox entity.
 */
@Repository
//@Transactional("partnerTransactionManager")
@PersistenceContext(name = "partnerEntityManagerFactory")
public interface ChatboxRepository extends JpaRepository<Chatbox, Long> {
	
	List<Chatbox> findTop30ByOrderByIdDesc();
}
