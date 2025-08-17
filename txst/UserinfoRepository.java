package com.archie.repository;

import com.archie.domain.Userinfo;

import java.util.Optional;

import org.springframework.data.jpa.repository.EntityGraph;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

/**
 * Spring Data  repository for the Userinfo entity.
 */
@Repository
public interface UserinfoRepository extends JpaRepository<Userinfo, Long> {
	
	Optional<Userinfo> findOneByLoginname(String loginname);
	
	Optional<Userinfo> findOneByNickName(String nickName);

    @EntityGraph(attributePaths = "authorities")
    Optional<Userinfo> findOneWithAuthoritiesByLoginname(String loginname);
    
    @EntityGraph(attributePaths = "authorities")
    Optional<Userinfo> findOneWithAuthoritiesByNickName(String nickName);
}
