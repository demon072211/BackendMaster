package com.vinplay.api.processors;

import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.response.BaseResponse;
import javax.servlet.http.HttpServletRequest;

public class GetCurrentTimeServer
implements BaseProcessor<HttpServletRequest, String> {
	public String execute(Param<HttpServletRequest> param) {
        java.time.format.DateTimeFormatter formatter = java.time.format.DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        return BaseResponse.success("0",null, formatter.format(java.time.LocalDateTime.now()));
    }
}