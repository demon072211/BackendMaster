package com.archie.dao;

import java.util.List;

import javax.persistence.PersistenceContext;

import org.springframework.data.jpa.repository.*;
import org.springframework.stereotype.Repository;

import com.archie.entity.TxRank;

/**
 * Spring Data repository for the TxRank entity.
 */
@Repository
@PersistenceContext(name = "partnerEntityManagerFactory")
public interface TxRankRepository extends JpaRepository<TxRank, Long> {
	
	List<TxRank> findTop15ByOrderByAmountDesc();
}
