package com.archie.dao;


import java.util.List;

import javax.persistence.PersistenceContext;

import org.springframework.data.jpa.repository.*;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;

import com.archie.entity.Taixiu;

/**
 * Spring Data repository for the Taixiu entity.
 */
@Repository
//@Transactional("partnerTransactionManager")
@PersistenceContext(name = "partnerEntityManagerFactory")
public interface TaixiuRepository extends JpaRepository<Taixiu, Long> {
	List<Taixiu> findTop100By();
	
	List<Taixiu> findTop100ByOrderByIdDesc();
	
}
