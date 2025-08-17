package com.archie.api;

import com.archie.entity.TxRank;
import com.archie.dao.TxRankRepository;
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
 * REST controller for managing {@link com.archie.domain.TxRank}.
 */
@RestController
@RequestMapping("/api")
public class TxRankApi {

    private final Logger log = LoggerFactory.getLogger(TxRankApi.class);

    private static final String ENTITY_NAME = "txRank";

    @Value("${jhipster.clientApp.name}")
    private String applicationName;

    private final TxRankRepository txRankRepository;

    public TxRankApi(TxRankRepository txRankRepository) {
        this.txRankRepository = txRankRepository;
    }

    /**
     * {@code POST  /tx-ranks} : Create a new txRank.
     *
     * @param txRank the txRank to create.
     * @return the {@link ResponseEntity} with status {@code 201 (Created)} and with body the new txRank, or with status {@code 400 (Bad Request)} if the txRank has already an ID.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PostMapping("/tx-ranks")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<TxRank> createTxRank(@RequestBody TxRank txRank) throws URISyntaxException {
        log.debug("REST request to save TxRank : {}", txRank);
        if (txRank.getId() != null) {
            throw new BadRequestAlertException("A new txRank cannot already have an ID", ENTITY_NAME, "idexists");
        }
        TxRank result = txRankRepository.save(txRank);
        return ResponseEntity.created(new URI("/api/tx-ranks/" + result.getId()))
            .headers(HeaderUtil.createEntityCreationAlert(applicationName, true, ENTITY_NAME, result.getId().toString()))
            .body(result);
    }

    /**
     * {@code PUT  /tx-ranks} : Updates an existing txRank.
     *
     * @param txRank the txRank to update.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the updated txRank,
     * or with status {@code 400 (Bad Request)} if the txRank is not valid,
     * or with status {@code 500 (Internal Server Error)} if the txRank couldn't be updated.
     * @throws URISyntaxException if the Location URI syntax is incorrect.
     */
    @PutMapping("/tx-ranks")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<TxRank> updateTxRank(@RequestBody TxRank txRank) throws URISyntaxException {
        log.debug("REST request to update TxRank : {}", txRank);
        if (txRank.getId() == null) {
            throw new BadRequestAlertException("Invalid id", ENTITY_NAME, "idnull");
        }
        TxRank result = txRankRepository.save(txRank);
        return ResponseEntity.ok()
            .headers(HeaderUtil.createEntityUpdateAlert(applicationName, true, ENTITY_NAME, txRank.getId().toString()))
            .body(result);
    }

    /**
     * {@code GET  /tx-ranks} : get all the txRanks.
     *
     * @param pageable the pagination information.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and the list of txRanks in body.
     */
    @GetMapping("/tx-ranks")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT') or hasRole('USER')")
    public ResponseEntity<List<TxRank>> getAllTxRanks(Pageable pageable) {
        log.debug("REST request to get a page of TxRanks");
        Page<TxRank> page = txRankRepository.findAll(pageable);
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(ServletUriComponentsBuilder.fromCurrentRequest(), page);
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

    /**
     * {@code GET  /tx-ranks/:id} : get the "id" txRank.
     *
     * @param id the id of the txRank to retrieve.
     * @return the {@link ResponseEntity} with status {@code 200 (OK)} and with body the txRank, or with status {@code 404 (Not Found)}.
     */
    @GetMapping("/tx-ranks/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT') or hasRole('USER')")
    public ResponseEntity<TxRank> getTxRank(@PathVariable Long id) {
        log.debug("REST request to get TxRank : {}", id);
        Optional<TxRank> txRank = txRankRepository.findById(id);
        return ResponseUtil.wrapOrNotFound(txRank);
    }

    /**
     * {@code DELETE  /tx-ranks/:id} : delete the "id" txRank.
     *
     * @param id the id of the txRank to delete.
     * @return the {@link ResponseEntity} with status {@code 204 (NO_CONTENT)}.
     */
    @DeleteMapping("/tx-ranks/{id}")
    @PreAuthorize("hasRole('ADMIN') or hasRole('CS') or hasRole('MKT')")
    public ResponseEntity<Void> deleteTxRank(@PathVariable Long id) {
        log.debug("REST request to delete TxRank : {}", id);
        txRankRepository.deleteById(id);
        return ResponseEntity.noContent().headers(HeaderUtil.createEntityDeletionAlert(applicationName, true, ENTITY_NAME, id.toString())).build();
    }
}
