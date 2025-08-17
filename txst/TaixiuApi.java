package com.archie.api;

import com.archie.entity.Taixiu;
import com.archie.security.AuthoritiesConstants;
import com.archie.service.TaixiuService;
import com.archie.web.rest.errors.BadRequestAlertException;

import io.github.jhipster.web.util.HeaderUtil;
import io.github.jhipster.web.util.PaginationUtil;
import io.github.jhipster.web.util.ResponseUtil;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpHeaders;
import org.springframework.web.servlet.support.ServletUriComponentsBuilder;
import org.springframework.http.ResponseEntity;
import org.springframework.security.access.prepost.PreAuthorize;
import org.springframework.web.bind.annotation.*;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.List;
import java.util.Optional;

/**
 * REST controller for managing {@link com.archie.domain.Taixiu}.
 */
@RestController
@RequestMapping("/api/tx")
public class TaixiuApi {

    private final Logger log = LoggerFactory.getLogger(TaixiuApi.class);

    private static final String ENTITY_NAME = "taixiu";

    @Value("${jhipster.clientApp.name}")
    private String applicationName;

    private final TaixiuService taixiuService;

    public TaixiuApi(TaixiuService taixiuService) {
        this.taixiuService = taixiuService;
    }

    /**
     * {@code POST  /taixius} : Create a new taixiu.
     *
     * @param taixiu the taixiu to create.
     * @return the {@link ResponseEntity} with status {@code 201 (Created)} and with body the new taixiu, or with status {@code 400 (Bad Request)} if the taixiu has already an ID.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PostMapping("/taixius")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<Taixiu> createTaixiu(@RequestBody Taixiu taixiu) throws URISyntaxException {
        log.debug("REST request to save Taixiu : {}", taixiu);
        if (taixiu.getId() != null) {
            throw new BadRequestAlertException("A new taixiu cannot already have an ID", ENTITY_NAME, "idexists");
        }
        Taixiu result = taixiuService.save(taixiu);
        return ResponseEntity.created(new URI("/api/taixius/" + result.getId()))
            .headers(HeaderUtil.createEntityCreationAlert(applicationName, true, ENTITY_NAME, result.getId().toString()))
            .body(result);
    }

    /**
     * {@code PUT  /taixius} : Updates an existing taixiu.
     *
     * @param taixiu the taixiu to update.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the updated taixiu,
     * or with status {@code 400 (Bad Request)} if the taixiu is not valid,
     * or with status {@code 500 (Internal Server Error)} if the taixiu couldn't be updated.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PutMapping("/taixius")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<Taixiu> updateTaixiu(@RequestBody Taixiu taixiu) throws URISyntaxException {
        log.debug("REST request to update Taixiu : {}", taixiu);
        if (taixiu.getId() == null) {
            throw new BadRequestAlertException("Invalid id", ENTITY_NAME, "idnull");
        }
        Taixiu result = taixiuService.save(taixiu);
        return ResponseEntity.ok()
            .headers(HeaderUtil.createEntityUpdateAlert(applicationName, true, ENTITY_NAME, taixiu.getId().toString()))
            .body(result);
    }

    /**
     * {@code GET  /taixius} : get all the taixius.
     *
     * @param pageable the pagination information.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and the list of taixius in body.
     */
    @GetMapping("/taixius")
    public ResponseEntity<List<Taixiu>> getAllTaixius(Pageable pageable) {
        log.debug("REST request to get a page of Taixius");
        Page<Taixiu> page = taixiuService.findAll(pageable);
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(ServletUriComponentsBuilder.fromCurrentRequest(), page);
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

    /**
     * {@code GET  /taixius/:id} : get the "id" taixiu.
     *
     * @param id the id of the taixiu to retrieve.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the taixiu, or with status {@code 404 (Not Found)}.
     */
    @GetMapping("/taixius/{id}")
    public ResponseEntity<Taixiu> getTaixiu(@PathVariable Long id) {
        log.debug("REST request to get Taixiu : {}", id);
        Optional<Taixiu> taixiu = taixiuService.findOne(id);
        return ResponseUtil.wrapOrNotFound(taixiu);
    }

    /**
     * {@code DELETE  /taixius/:id} : delete the "id" taixiu.
     *
     * @param id the id of the taixiu to delete.
     * @return the {@link ResponseEntity} with status {@code 204 (NO_CONTENT)}.
     */
    @DeleteMapping("/taixius/{id}")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<Void> deleteTaixiu(@PathVariable Long id) {
        log.debug("REST request to delete Taixiu : {}", id);
        taixiuService.delete(id);
        return ResponseEntity.noContent().headers(HeaderUtil.createEntityDeletionAlert(applicationName, true, ENTITY_NAME, id.toString())).build();
    }
}
