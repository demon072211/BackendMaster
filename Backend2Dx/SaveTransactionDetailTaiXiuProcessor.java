/*
 * Decompiled with CFR 0.144.
 *
 * Could not load the following classes:
 *  com.vinplay.vbee.common.cp.BaseProcessor
 *  com.vinplay.vbee.common.cp.Param
 *  com.vinplay.vbee.common.messages.BaseMessage
 *  com.vinplay.vbee.common.messages.minigame.TransactionTaiXiuDetailMessage
 */
package com.vinplay.vbee.rmq.minigame.processor;

import com.vinplay.vbee.common.cp.BaseProcessor;
import com.vinplay.vbee.common.cp.Param;
import com.vinplay.vbee.common.messages.BaseMessage;
import com.vinplay.vbee.common.messages.minigame.TransactionTaiXiuDetailMessage;
import com.vinplay.vbee.dao.TaiXiuDao;
import com.vinplay.vbee.dao.impl.TaiXiuDaoImpl;
import com.vinplay.vbee.dao.impl.TaiXiuMD5DaoImpl;
import org.apache.log4j.Logger;

import java.sql.SQLException;

public class SaveTransactionDetailTaiXiuProcessor
        implements BaseProcessor<byte[], Boolean> {

    public Boolean execute(Param<byte[]> param) {
        byte[] body = (byte[])param.get();
        TransactionTaiXiuDetailMessage message = (TransactionTaiXiuDetailMessage)BaseMessage.fromBytes((byte[])body);
        TaiXiuDaoImpl dao = new TaiXiuDaoImpl();

        TaiXiuMD5DaoImpl daoMD5 = new TaiXiuMD5DaoImpl();
        boolean success = false;
        try {
            if(message.isMD5)
                success = daoMD5.saveTransactionTaiXiuDetail(message);
            else
                success = dao.saveTransactionTaiXiuDetail(message);
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
        return success;
    }
}

