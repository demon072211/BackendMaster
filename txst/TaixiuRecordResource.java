package com.archie.web.rest;

import com.archie.entity.TaixiuRecord;
import com.archie.security.AuthoritiesConstants;
import com.archie.service.TaixiuRecordService;
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
import java.time.Instant;
import java.util.List;
import java.util.Optional;

/**
 * REST controller for managing {@link com.archie.domain.TaixiuRecord}.
 */
@RestController
@RequestMapping("/api")
public class TaixiuRecordResource {

    private final Logger log = LoggerFactory.getLogger(TaixiuRecordResource.class);

    private static final String ENTITY_NAME = "taixiuRecord";

    @Value("${jhipster.clientApp.name}")
    private String applicationName;

    private final TaixiuRecordService taixiuRecordService;

    public TaixiuRecordResource(TaixiuRecordService taixiuRecordService) {
        this.taixiuRecordService = taixiuRecordService;
    }

    /**
     * {@code POST  /taixiu-records} : Create a new taixiuRecord.
     *
     * @param taixiuRecord the taixiuRecord to create.
     * @return the {@link ResponseEntity} with status {@code 201 (Created)} and with body the new taixiuRecord, or with status {@code 400 (Bad Request)} if the taixiuRecord has already an ID.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PostMapping("/taixiu-records")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<TaixiuRecord> createTaixiuRecord(@RequestBody TaixiuRecord taixiuRecord) throws URISyntaxException {
        log.debug("REST request to save TaixiuRecord : {}", taixiuRecord);
        if (taixiuRecord.getId() != null) {
            throw new BadRequestAlertException("A new taixiuRecord cannot already have an ID", ENTITY_NAME, "idexists");
        }
        TaixiuRecord result = taixiuRecordService.save(taixiuRecord);
        return ResponseEntity.created(new URI("/api/taixiu-records/" + result.getId()))
            .headers(HeaderUtil.createEntityCreationAlert(applicationName, true, ENTITY_NAME, result.getId().toString()))
            .body(result);
    }

    /**
     * {@code PUT  /taixiu-records} : Updates an existing taixiuRecord.
     *
     * @param taixiuRecord the taixiuRecord to update.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the updated taixiuRecord,
     * or with status {@code 400 (Bad Request)} if the taixiuRecord is not valid,
     * or with status {@code 500 (Internal Server Error)} if the taixiuRecord couldn't be updated.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PutMapping("/taixiu-records")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<TaixiuRecord> updateTaixiuRecord(@RequestBody TaixiuRecord taixiuRecord) throws URISyntaxException {
        log.debug("REST request to update TaixiuRecord : {}", taixiuRecord);
        if (taixiuRecord.getId() == null) {
            throw new BadRequestAlertException("Invalid id", ENTITY_NAME, "idnull");
        }
        TaixiuRecord result = taixiuRecordService.save(taixiuRecord);
        return ResponseEntity.ok()
            .headers(HeaderUtil.createEntityUpdateAlert(applicationName, true, ENTITY_NAME, taixiuRecord.getId().toString()))
            .body(result);
    }

    /**
     * {@code GET  /taixiu-records} : get all the taixiuRecords.
     *
     * @param pageable the pagination information.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and the list of taixiuRecords in body.
     */
    @GetMapping("/taixiu-records")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<List<TaixiuRecord>> getAllTaixiuRecords(Pageable pageable,@RequestParam(required = false) String loginname , 
    		@RequestParam(required = false) Long luotxo,
    		@RequestParam(required = false) Integer type,
    		@RequestParam(required = false) Integer status,
    		@RequestParam(required = false) Integer userType,
    		@RequestParam(required = false) Instant starttime ,
    		@RequestParam(required = false) Instant endTime) {
        log.debug("REST request to get a page of TaixiuRecords");
		Page<TaixiuRecord> page = taixiuRecordService.filter(pageable, loginname, luotxo, type, status, userType,
				starttime, endTime);
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(ServletUriComponentsBuilder.fromCurrentRequest(), page);
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

    /**
     * {@code GET  /taixiu-records/:id} : get the "id" taixiuRecord.
     *
     * @param id the id of the taixiuRecord to retrieve.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the taixiuRecord, or with status {@code 404 (Not Found)}.
     */
    @GetMapping("/taixiu-records/{id}")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<TaixiuRecord> getTaixiuRecord(@PathVariable Long id) {
        log.debug("REST request to get TaixiuRecord : {}", id);
        Optional<TaixiuRecord> taixiuRecord = taixiuRecordService.findOne(id);
        return ResponseUtil.wrapOrNotFound(taixiuRecord);
    }

    /**
     * {@code DELETE  /taixiu-records/:id} : delete the "id" taixiuRecord.
     *
     * @param id the id of the taixiuRecord to delete.
     * @return the {@link ResponseEntity} with status {@code 204 (NO_CONTENT)}.
     */
    @DeleteMapping("/taixiu-records/{id}")
    @PreAuthorize("hasAuthority(\"" + AuthoritiesConstants.ADMIN + "\")")
    public ResponseEntity<Void> deleteTaixiuRecord(@PathVariable Long id) {
        log.debug("REST request to delete TaixiuRecord : {}", id);
        taixiuRecordService.delete(id);
        return ResponseEntity.noContent().headers(HeaderUtil.createEntityDeletionAlert(applicationName, true, ENTITY_NAME, id.toString())).build();
    }
}
