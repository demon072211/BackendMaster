package com.vinplay.vbee.rmq.minigame.processor;

import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.messages.BaseMessage;
import com.vinplay.vbee.common.messages.minigame.TransactionTaiXiuDetailMessage;
import com.vinplay.vbee.dao.impl.TaiXiuDaoImpl;
import java.sql.SQLException;

public class SaveTransactionDetailTaiXiuProcessor implements BaseProcessor<byte[], Boolean> {
	public Boolean execute(Param<byte[]> param) {
		byte[] body = (byte[]) param.get();
		TransactionTaiXiuDetailMessage message = (TransactionTaiXiuDetailMessage) BaseMessage.fromBytes((byte[]) body);
		TaiXiuDaoImpl dao = new TaiXiuDaoImpl();
		boolean success = false;
		try {
			success = dao.saveTransactionTaiXiuDetail(message);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return success;
	}
}
