package com.archie.api;

import java.util.List;

import javax.servlet.ServletRequest;
import javax.servlet.http.HttpServletRequest;
import javax.validation.Valid;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.util.StringUtils;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.archie.entity.TaixiuRecord;
import com.archie.security.jwt.TokenProvider;
import com.archie.service.TaixiuRecordService;
import com.archie.service.dto.ApiResponse;
import com.archie.service.dto.TKTaiXiuDTO;
import com.archie.service.dto.TaiXiuBetDTO;
import com.archie.web.websocket.dto.WsResponse;

/**
 * REST controller for managing {@link com.archie.domain.TaixiuRecord}.
 */
@RestController
@RequestMapping("/api/tx")
public class TaixiuRecordApi {

    private final Logger log = LoggerFactory.getLogger(TaixiuRecordApi.class);

    @Value("${jhipster.clientApp.name}")
    private String applicationName;
    
    @Autowired
    private TokenProvider tokenProvider;
    
    public static final String AUTHORIZATION_HEADER = "Authorization";

    public static final String AUTHORIZATION_TOKEN = "access_token";
    
    private final TaixiuRecordService taixiuRecordService;

    public TaixiuRecordApi(TaixiuRecordService taixiuRecordService) {
        this.taixiuRecordService = taixiuRecordService;
    }

    @PostMapping("/taixiu-bet")
    public ResponseEntity<WsResponse<TaiXiuBetDTO>> taixiuBet(@Valid @RequestBody TaiXiuBetDTO taixiuRecord,ServletRequest servletRequest) {
        log.debug("REST request to save taixiuBet : {}", taixiuRecord);
        WsResponse<TaiXiuBetDTO> result = null;
		try {
			String loginname = doFilter(servletRequest);
			taixiuRecord.setUsername(loginname);
			result = taixiuRecordService.save(taixiuRecord);
		} catch (Exception e) {
			result = null;
		}
        return new ResponseEntity<WsResponse<TaiXiuBetDTO>>(result, HttpStatus.OK);
    }
    
    private String doFilter(ServletRequest servletRequest) throws Exception {
		HttpServletRequest httpServletRequest = (HttpServletRequest) servletRequest;
		String jwt = resolveToken(httpServletRequest);
		if (StringUtils.hasText(jwt) && this.tokenProvider.validateToken(jwt)) {
			// get username
			return this.tokenProvider.getLoginname(jwt);
		}
		return jwt;
	}
	
	private String resolveToken(HttpServletRequest request) {
		String bearerToken = request.getHeader(AUTHORIZATION_HEADER);
		if (StringUtils.hasText(bearerToken) && bearerToken.startsWith("Bearer ")) {
			return bearerToken.substring(7);
		}
		String jwt = request.getParameter(AUTHORIZATION_TOKEN);
		if (StringUtils.hasText(jwt)) {
			return jwt;
		}
		return null;
	}
    

	@PostMapping("/lichsucuoc")
	public ResponseEntity<ApiResponse<List<TaixiuRecord>>> getAllTaixiuRecords(Pageable pageable,
			HttpServletRequest request) {
		log.debug("REST request to get a page of TaixiuRecords");
		String loginname = this.tokenProvider.getLoginname(resolveToken(request));
		ApiResponse<List<TaixiuRecord>> response = null;
		if (loginname != null && !loginname.equals("")) {
			Page<TaixiuRecord> page = taixiuRecordService.findByLoginname(pageable, loginname);
			if (page != null) {
				response = new ApiResponse<List<TaixiuRecord>>("SUCCES", page.getTotalPages(), page.getContent());
				return ResponseEntity.ok().body(response);
			}
		}
		return ResponseEntity.ok().body(null);

	}

    @PostMapping("/thongkephien/{taixiuId}")
	public ResponseEntity<TKTaiXiuDTO> getAllTaixiuRecords(@PathVariable Long taixiuId) {
		log.debug("REST request to get a page of TaixiuRecords");
		TKTaiXiuDTO result = null;
		try {
			result = taixiuRecordService.findAllByPhienId(taixiuId);
		} catch (Exception e) {
			log.error(e.getMessage());
			result = new TKTaiXiuDTO();
		}
		return ResponseEntity.ok().body(result);
	}

}
