package com.archie.repository;

import com.archie.domain.User;

import org.springframework.cache.annotation.Cacheable;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.EntityGraph;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;
import java.util.Set;

import javax.transaction.Transactional;

/**
 * Spring Data JPA repository for the {@link User} entity.
 */
@Repository
public interface UserRepository extends JpaRepository<User, Long> {

    String USERS_BY_LOGIN_CACHE = "usersByLogin";

    Optional<User> findOneByLogin(String login);

    @EntityGraph(attributePaths = "authorities")
    @Cacheable(cacheNames = USERS_BY_LOGIN_CACHE)
    Optional<User> findOneWithAuthoritiesByLogin(String login);

//    Page<User> findAllByLoginNot(Pageable pageable, String login);
    
    @Query(value = "select u from User u join u.authorities x where (:login is null or u.login=:login) and (:id is null or u.id=:id) and x.name=:role ")
	Page<User> findAllByLoginAndId(Pageable pageable, 
			@Param("login") String login, 
			@Param("id") Long id,
			@Param("role") String role);
    
    @Query(value = "select u from User u join u.authorities x where (:login is null or u.login=:login) and (:id is null or u.id=:id) and x.name in :authorities ")
   	Page<User> findByAuthoritiesAndLoginAndId(Pageable pageable, 
   			@Param("login") String login, 
   			@Param("id") Long id ,
   			@Param("authorities") Set<String> authorities);
    
    
    @Modifying
	@Transactional
	@Query(value = "update tx_user  set total_winamount = total_winamount + :betamount * :rate  where login in :loginList", nativeQuery = true)
	int updateReportBotWin(@Param("rate") float rate,  @Param("loginList") List<String> loginList);

}
