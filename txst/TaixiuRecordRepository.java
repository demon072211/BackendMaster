package com.archie.dao;

import com.archie.entity.TaixiuRecord;
import com.archie.service.dto.TKPhienDTO;

import java.time.Instant;
import java.time.LocalDateTime;
import java.util.List;

import javax.persistence.PersistenceContext;
import javax.transaction.Transactional;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

/**
 * Spring Data repository for the TaixiuRecord entity.
 */
@Repository
@PersistenceContext(name = "partnerEntityManagerFactory")
public interface TaixiuRecordRepository extends JpaRepository<TaixiuRecord, Long> {

	Page<TaixiuRecord> findAllByLoginname(Pageable pageable, String loginname);

	List<TaixiuRecord> findAllByTaixiuId(long taixiuId);
	
	@Query("SELECT t  FROM  TaixiuRecord t where (:loginname is null or t.loginname=:loginname) "
			+ " and (:luotxo is null or t.taixiuId=:luotxo) "
			+ " and (:type is null or t.typed=:type) "
			+ " and (:status is null or t.status=:status) "
			+ " and (:userType is null or t.userType=:userType) "
			+ " and (:startTime is null or t.bettime>=:startTime) "
			+ " and (:endTime is null or t.bettime<=:endTime) ")
	Page<TaixiuRecord> filter(Pageable pageable, 
			@Param("loginname") String loginname, 
			@Param("luotxo") Long luotxo,
			@Param("type") Integer type, 
			@Param("status") Integer status, 
			@Param("userType") Integer userType, 
			@Param("startTime") Instant startTime,
			@Param("endTime") Instant endTime);
	
	@Query("SELECT new com.archie.service.dto.TKPhienDTO(s.taixiuId,s.loginname,s.betamount,s.typed,s.status,s.bettime,s.result,s.refundamount) FROM  "
			+ " TaixiuRecord s WHERE s.taixiuId=:taixiuId order by s.id desc")
	List<TKPhienDTO> findByTaixiuId(@Param("taixiuId") long taixiuId);

	@Modifying
	@Transactional
	@Query(value = "update taixiu_record  set winamount = (betamount - refundamount)  * (1 + :rate) , result =:result , status=1, description='Thắng'   where id in :idList", nativeQuery = true)
	int updateListBotWin(@Param("rate") float rate, @Param("result") String result, @Param("idList") List<Long> idList);
	
	@Modifying
	@Transactional
	@Query(value = "update taixiu_record  set winamount =0 , result =:result , description='Thua'  where id in :idList", nativeQuery = true)
	int updateListBotLose(@Param("idList") List<Long> idList, @Param("result") String result);
	
	@Query("select count(t) from TaixiuRecord t  where t.taixiuId =:taixiuId")
	Integer count(@Param("taixiuId") long taixiuId);
	
	
	@Modifying
	@Transactional
	@Query(value = "delete FROM  taixiu_record  where bettime <=:endTime and usertype =0 ", nativeQuery = true)
	int deleteListBot(@Param("endTime") LocalDateTime endTime);
	
}
