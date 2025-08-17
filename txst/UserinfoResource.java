package com.archie.web.rest;

import java.util.List;
import java.util.Optional;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;

import com.archie.domain.Userinfo;
import com.archie.security.AuthoritiesConstants;
import com.archie.service.UserinfoService;

import io.github.jhipster.web.util.PaginationUtil;
import io.github.jhipster.web.util.ResponseUtil;

/**
 * REST controller for managing {@link com.archie.domain.Userinfo}.
 */
@RestController
@RequestMapping("/api")
public class UserinfoResource {

    private final Logger log = LoggerFactory.getLogger(UserinfoResource.class);

    private final UserinfoService userinfoService;

    public UserinfoResource(UserinfoService userinfoService) {
        this.userinfoService = userinfoService;
    }

    /**
     * {@code GET  /userinfos} : get all the userinfos.
     *
     * @param pageable the pagination information.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and the list of userinfos in body.
     */
    @GetMapping("/userinfos")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<List<Userinfo>> getAllUserinfos(Pageable pageable) {
        log.debug("REST request to get a page of Userinfos");
        Page<Userinfo> page = userinfoService.findAll(pageable);
        page.forEach(u->{
        	u.setPwd("******");
        });
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(ServletUriComponentsBuilder.fromCurrentRequest(), page);
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

    /**
     * {@code GET  /userinfos/:id} : get the "id" userinfo.
     *
     * @param id the id of the userinfo to retrieve.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the userinfo, or with status {@code 404 (Not Found)}.
     */
    @GetMapping("/userinfos/{id}")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<Userinfo> getUserinfo(@PathVariable Long id) {
        log.debug("REST request to get Userinfo : {}", id);
        Optional<Userinfo> userinfo = userinfoService.findOne(id);
        userinfo.get().setPwd("******");
        return ResponseUtil.wrapOrNotFound(userinfo);
    }
}
