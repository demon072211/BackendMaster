/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.mongodb.BasicDBObject
 *  com.mongodb.Block
 *  com.mongodb.client.AggregateIterable
 *  com.mongodb.client.FindIterable
 *  com.mongodb.client.MongoCollection
 *  com.mongodb.client.MongoDatabase
 *  com.mongodb.client.result.UpdateResult
 *  com.vinplay.vbee.common.exceptions.KeyNotFoundException
 *  com.vinplay.vbee.common.messages.dvt.RechargeByBankMessage
 *  com.vinplay.vbee.common.messages.dvt.RechargeByCardMessage
 *  com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory
 *  com.vinplay.vbee.common.pools.ConnectionPool
 *  com.vinplay.vbee.common.utils.VinPlayUtils
 *  org.bson.Document
 *  org.bson.conversions.Bson
 */
package com.vinplay.dichvuthe.dao.impl;

import com.mongodb.BasicDBObject;
import com.mongodb.Block;
import com.mongodb.client.AggregateIterable;
import com.mongodb.client.FindIterable;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import com.mongodb.client.result.UpdateResult;
import com.vinplay.dichvuthe.dao.RechargeDao;
import com.vinplay.dichvuthe.entities.NganLuongModel;
import com.vinplay.dichvuthe.response.LogApiOtpConfirmResponse;
import com.vinplay.dichvuthe.response.LogApiOtpRequestResponse;
import com.vinplay.dichvuthe.response.LogSMS8x98Response;
import com.vinplay.dichvuthe.response.LogSMSPlusCheckMoResponse;
import com.vinplay.dichvuthe.response.LogSMSPlusResponse;
import com.vinplay.iap.lib.Purchase;
import com.vinplay.usercore.entities.LogApiOtpConfirm;
import com.vinplay.usercore.entities.LogApiOtpRequest;
import com.vinplay.usercore.entities.LogRechargeBankNL;
import com.vinplay.usercore.entities.LogRechargeBankNapas;
import com.vinplay.usercore.entities.LogSMS8x98;
import com.vinplay.usercore.entities.LogSMSPlus;
import com.vinplay.usercore.entities.LogSMSPlusCheckMO;
import com.vinplay.usercore.response.LogRechargeBankNLResponse;
import com.vinplay.usercore.response.LogRechargeBankNapasResponse;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.vbee.common.exceptions.KeyNotFoundException;
import com.vinplay.vbee.common.messages.dvt.RechargeByBankMessage;
import com.vinplay.vbee.common.messages.dvt.RechargeByCardMessage;
import com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory;
import com.vinplay.vbee.common.pools.ConnectionPool;
import com.vinplay.vbee.common.utils.VinPlayUtils;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.bson.Document;
import org.bson.conversions.Bson;

public class RechargeDaoImpl
implements RechargeDao {
    @Override
    public List<RechargeByCardMessage> getListCardPending(String startTime, String endTime) throws NumberFormatException, KeyNotFoundException {
        final ArrayList<RechargeByCardMessage> results = new ArrayList<RechargeByCardMessage>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        FindIterable iterable = null;
        Document conditions = new Document();
        conditions.put("code", (Object)30);
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        iterable = db.getCollection("dvt_recharge_by_card").find((Bson)conditions);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                RechargeByCardMessage message = new RechargeByCardMessage(document.getString((Object)"nick_name"), document.getString((Object)"reference_id"), document.getString((Object)"provider"), document.getString((Object)"serial"), document.getString((Object)"pin"), document.getInteger((Object)"amount").intValue(), document.getInteger((Object)"status").intValue(), document.getString((Object)"message"), document.getInteger((Object)"code").intValue(), 0, document.getString((Object)"time_log"), (String)null, document.getString((Object)"partner"), document.getString((Object)"platform"), document.getString((Object)"user_mega"));
                results.add(message);
            }
        });
        return results;
    }

    @Override
    public List<RechargeByCardMessage> getListCardPending() throws NumberFormatException, KeyNotFoundException {
        final ArrayList<RechargeByCardMessage> results = new ArrayList<RechargeByCardMessage>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        FindIterable iterable = null;
        Document conditions = new Document();
        conditions.put("code", (Object)30);
        conditions.put("time_log", (Object)new BasicDBObject("$gte", (Object)VinPlayUtils.parseDateTimeToString((Date)VinPlayUtils.subtractDay((Date)new Date(), (int)GameCommon.getValueInt("TIME_RECHECK_RECHARGE")))));
        iterable = db.getCollection("dvt_recharge_by_card").find((Bson)conditions);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                RechargeByCardMessage message = new RechargeByCardMessage(document.getString((Object)"nick_name"), document.getString((Object)"reference_id"), document.getString((Object)"provider"), document.getString((Object)"serial"), document.getString((Object)"pin"), document.getInteger((Object)"amount").intValue(), document.getInteger((Object)"status").intValue(), document.getString((Object)"message"), document.getInteger((Object)"code").intValue(), 0, document.getString((Object)"time_log"), (String)null, document.getString((Object)"partner"), document.getString((Object)"platform"), document.getString((Object)"user_mega"));
                results.add(message);
            }
        });
        return results;
    }

    @Override
    public boolean updateSMS(String requestId, int code, String des, int smsType) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = null;
        col = smsType == 2 ? db.getCollection("dvt_recharge_by_sms_plus") : db.getCollection("dvt_recharge_by_sms");
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("code", (Object)code);
        updateFields.append("description", (Object)des);
        col.updateOne((Bson)new Document("request_id", (Object)requestId), (Bson)new Document("$set", (Object)updateFields));
        return true;
    }

    @Override
    public RechargeByCardMessage getPendingCardByReferenceId(String referenceId) {
        RechargeByCardMessage result = null;
        Document conditions = new Document();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        conditions.put("reference_id", (Object)referenceId);
        Document dc = (Document)db.getCollection("dvt_recharge_by_card").find((Bson)conditions).first();
        if (dc != null) {
            result = new RechargeByCardMessage(dc.getString((Object)"nick_name"), dc.getString((Object)"reference_id"), dc.getString((Object)"provider"), dc.getString((Object)"serial"), dc.getString((Object)"pin"), dc.getInteger((Object)"amount").intValue(), dc.getInteger((Object)"status").intValue(), dc.getString((Object)"message"), dc.getInteger((Object)"code").intValue(), 0, dc.getString((Object)"time_log"), (String)null, dc.getString((Object)"partner"), dc.getString((Object)"platform"), dc.getString((Object)"user_mega"));
        }
        return result;
    }

    @Override
    public boolean updateRechargeByCard(String transId, String responseCode, String description,String amountReceive) throws Exception {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("status", (Object) Integer.parseInt(String.valueOf(responseCode)));
        updateFields.append("message", (Object)description);
        updateFields.append("amount", (Object) Integer.parseInt(String.valueOf(amountReceive)));
        updateFields.append("update_time", (Object)VinPlayUtils.getCurrentDateTime());
        db.getCollection("dvt_recharge_by_card").updateOne((Bson)new Document("reference_id", (Object)transId), (Bson)new Document("$set", (Object)updateFields));
        return true;
    }

    @Override
    public boolean insertLogUpdateCardPending(String reference_id, String nick_name, String provider, String serial, String pin, String amount, String status, String message, String code, String time_log, String money, String actor) throws Exception {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("log_update_card_pending");
        Document doc = new Document();
        doc.append("reference_id", (Object)reference_id);
        doc.append("nick_name", (Object)nick_name);
        doc.append("provider", (Object)provider);
        doc.append("serial", (Object)serial);
        doc.append("pin", (Object)pin);
        doc.append("amount", (Object)amount);
        doc.append("status", (Object)status);
        doc.append("message", (Object)message);
        doc.append("code", (Object)code);
        doc.append("time_log", (Object)time_log);
        doc.append("plus_money_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("money", (Object)money);
        doc.append("actor", (Object)actor);
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean updateCard(String id, int amount, int status, String message, int code) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("amount", (Object)amount);
        updateFields.append("status", (Object)status);
        updateFields.append("message", (Object)message);
        updateFields.append("code", (Object)code);
        updateFields.append("update_time", (Object)VinPlayUtils.getCurrentDateTime());
        db.getCollection("dvt_recharge_by_card").updateOne((Bson)new Document("reference_id", (Object)id), (Bson)new Document("$set", (Object)updateFields));
        return true;
    }

    @Override
    public RechargeByBankMessage getRechargeByBank(String transId) {
        RechargeByBankMessage result = null;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("trans_id", (Object)transId);
        Document dc = (Document)db.getCollection("dvt_recharge_by_bank").find((Bson)conditions).first();
        if (dc != null) {
            result = new RechargeByBankMessage(dc.getString((Object)"nick_name"), dc.getLong((Object)"money").longValue(), dc.getString((Object)"bank"), transId, dc.getString((Object)"amount"), dc.getString((Object)"order_info"), dc.getString((Object)"ticket_no"));
        }
        return result;
    }

    @Override
    public boolean logRechargeByBank(RechargeByBankMessage message) throws Exception {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_bank");
        Document doc = new Document();
        doc.append("nick_name", (Object)message.getNickname());
        doc.append("money", (Object)message.getMoney());
        doc.append("bank", (Object)message.getBank());
        doc.append("trans_id", (Object)message.getTransId());
        doc.append("amount", (Object)message.getAmount());
        doc.append("order_info", (Object)message.getOrderInfo());
        doc.append("ticket_no", (Object)message.getTicketNo());
        doc.append("trans_time", (Object)message.getCreateTime());
        doc.append("response_code", (Object)"");
        doc.append("description", (Object)"");
        doc.append("amount_receive", (Object)"");
        doc.append("transaction_no", (Object)"");
        doc.append("message", (Object)"");
        doc.append("update_time", (Object)"");
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean updateRechargeByBank(String transId, String responseCode, String description, String transactionNo, String message, String amountReceive) throws Exception {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("response_code", (Object)responseCode);
        updateFields.append("description", (Object)description);
        updateFields.append("transaction_no", (Object)transactionNo);
        updateFields.append("message", (Object)message);
        updateFields.append("amount_receive", (Object)amountReceive);
        updateFields.append("update_time", (Object)VinPlayUtils.getCurrentDateTime());
        db.getCollection("dvt_recharge_by_bank").updateOne((Bson)new Document("trans_id", (Object)transId), (Bson)new Document("$set", (Object)updateFields));
        return true;
    }

    @Override
    public boolean insertLogRechargeByBankError(String txnResponseCode, String version, String command, String merchTxnRef, String merchantID, String orderInfo, String currency, String amount, String locale, String cardType, String transactionNo, String message, String secureHash, String description) throws Exception {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_bank_error");
        Document doc = new Document();
        doc.append("trans_id", (Object)merchTxnRef);
        doc.append("response_code", (Object)txnResponseCode);
        doc.append("version", (Object)version);
        doc.append("command", (Object)command);
        doc.append("merchant_id", (Object)merchantID);
        doc.append("order_info", (Object)orderInfo);
        doc.append("currency_code", (Object)currency);
        doc.append("amount", (Object)amount);
        doc.append("locale", (Object)locale);
        doc.append("card_type", (Object)cardType);
        doc.append("transaction_no", (Object)transactionNo);
        doc.append("message", (Object)message);
        doc.append("secure_hash", (Object)secureHash);
        doc.append("description", (Object)description);
        doc.append("trans_time", (Object)VinPlayUtils.getCurrentDateTime());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean logRechargeByNL(String nickname, String email, String mobile, String ip, String orderCode, int totalAmount, int taxAmount, int discountAmount, int feeShipping, String paymentMethod, String bank, String errorCodeSend, String descVP, String token, String checkoutUrl, String timeLimit, String descNL) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("ngan_luong_transaction");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("email", (Object)email);
        doc.append("mobile", (Object)mobile);
        doc.append("ip", (Object)ip);
        doc.append("order_code", (Object)orderCode);
        doc.append("total_amount", (Object)totalAmount);
        doc.append("tax_amount", (Object)taxAmount);
        doc.append("discount_amount", (Object)discountAmount);
        doc.append("fee_shipping", (Object)feeShipping);
        doc.append("payment_method", (Object)paymentMethod);
        doc.append("bank", (Object)bank);
        doc.append("error_code_send", (Object)errorCodeSend);
        doc.append("desc_vp", (Object)descVP);
        doc.append("token", (Object)token);
        doc.append("checkout_url", (Object)checkoutUrl);
        doc.append("time_limit", (Object)timeLimit);
        doc.append("desc_nl", (Object)descNL);
        doc.append("trans_time", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("error_code_return", (Object)"");
        doc.append("desc_return", (Object)"");
        doc.append("update_time", (Object)"");
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean updateRechargeByNL(String token, String errorCodeReturn, String descReturn) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("error_code_return", (Object)errorCodeReturn);
        updateFields.append("desc_return", (Object)descReturn);
        updateFields.append("update_time", (Object)VinPlayUtils.getCurrentDateTime());
        UpdateResult result = db.getCollection("ngan_luong_transaction").updateOne((Bson)new Document("token", (Object)token), (Bson)new Document("$set", (Object)updateFields));
        return result.isModifiedCountAvailable();
    }

    @Override
    public boolean logRechargeByNLError(String token, String errorCodeReturn, String descReturn) {
        return true;
    }

    @Override
    public NganLuongModel getNLTrans(String token) {
        NganLuongModel result = null;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("token", (Object)token);
        ArrayList<String> listErr = new ArrayList<String>();
        listErr.add("");
        listErr.add("81");
        conditions.put("error_code_return", (Object)new BasicDBObject("$in", listErr));
        Document dc = (Document)db.getCollection("ngan_luong_transaction").find((Bson)conditions).first();
        if (dc != null) {
            result = new NganLuongModel(dc.getString((Object)"nick_name"), dc.getInteger((Object)"total_amount"), dc.getString((Object)"order_code"), dc.getString((Object)"bank"));
        }
        return result;
    }

    @Override
    public LogRechargeBankNapasResponse getLogNapas(String nickname, String bank, String transId, String ip, String transNo, String status, String startTime, String endTime, int page) {
        String pattern;
        final ArrayList<LogRechargeBankNapas> records = new ArrayList<LogRechargeBankNapas>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        num.add(1, 0L);
        num.add(2, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!bank.isEmpty()) {
            conditions.put("bank", bank);
        }
        if (!transId.isEmpty()) {
            pattern = ".*" + transId + ".*";
            conditions.put("trans_id", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!ip.isEmpty()) {
            conditions.put("ticket_no", ip);
        }
        if (!transNo.isEmpty()) {
            pattern = ".*" + transNo + ".*";
            conditions.put("transaction_no", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!status.isEmpty()) {
            conditions.put("response_code", status);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("trans_time", (Object)obj);
        }
        FindIterable iterable = db.getCollection("dvt_recharge_by_bank").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogRechargeBankNapas model = new LogRechargeBankNapas();
                model.nickname = document.getString((Object)"nick_name");
                model.money = document.getLong((Object)"money");
                model.bank = document.getString((Object)"bank");
                model.transId = document.getString((Object)"trans_id");
                model.ticketNo = document.getString((Object)"ticket_no");
                model.transTime = document.getString((Object)"trans_time");
                model.responseCode = document.getString((Object)"response_code");
                model.description = document.getString((Object)"description");
                model.transactionNo = document.getString((Object)"transaction_no");
                model.updateTime = document.getString((Object)"update_time");
                records.add(model);
            }
        });
        FindIterable iterable2 = db.getCollection("dvt_recharge_by_bank").find((Bson)new Document(conditions));
        iterable2.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogRechargeBankNapas model = new LogRechargeBankNapas();
                model.money = document.getLong((Object)"money");
                model.responseCode = document.getString((Object)"response_code");
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
                if (model.responseCode.equals("0")) {
                    long numSuccess = (Long)num.get(1) + 1L;
                    num.set(1, numSuccess);
                    long moneySuccess = (Long)num.get(2) + model.money;
                    num.set(2, moneySuccess);
                }
            }
        });
        LogRechargeBankNapasResponse res = new LogRechargeBankNapasResponse(true, "0", (Long)num.get(0) / 50L + 1L, (Long)num.get(1), (Long)num.get(2), records);
        return res;
    }

    @Override
    public LogRechargeBankNLResponse getLogNL(String nickname, String bank, String transId, String ip, String transNo, String status, String startTime, String endTime, int page) {
        String pattern;
        final ArrayList<LogRechargeBankNL> records = new ArrayList<LogRechargeBankNL>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        num.add(1, 0L);
        num.add(2, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!bank.isEmpty()) {
            conditions.put("bank", bank);
        }
        if (!transId.isEmpty()) {
            pattern = ".*" + transId + ".*";
            conditions.put("order_code", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!ip.isEmpty()) {
            conditions.put("ip", ip);
        }
        if (!transNo.isEmpty()) {
            pattern = ".*" + transNo + ".*";
            conditions.put("token", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!status.isEmpty()) {
            conditions.put("error_code_return", status);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("trans_time", (Object)obj);
        }
        FindIterable iterable = db.getCollection("ngan_luong_transaction").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogRechargeBankNL model = new LogRechargeBankNL();
                model.nickname = document.getString((Object)"nick_name");
                model.email = document.getString((Object)"email");
                model.mobile = document.getString((Object)"mobile");
                model.ip = document.getString((Object)"ip");
                model.orderCode = document.getString((Object)"order_code");
                model.totalAmount = document.getInteger((Object)"total_amount");
                model.bank = document.getString((Object)"bank");
                model.token = document.getString((Object)"token");
                model.transTime = document.getString((Object)"trans_time");
                model.errorCodeReturn = document.getString((Object)"error_code_return");
                model.descReturn = document.getString((Object)"desc_return");
                model.updateTime = document.getString((Object)"update_time");
                records.add(model);
            }
        });
        FindIterable iterable2 = db.getCollection("ngan_luong_transaction").find((Bson)new Document(conditions));
        iterable2.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogRechargeBankNL model = new LogRechargeBankNL();
                model.totalAmount = document.getInteger((Object)"total_amount");
                model.errorCodeReturn = document.getString((Object)"error_code_return");
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
                if (model.errorCodeReturn.equals("00")) {
                    long numSuccess = (Long)num.get(1) + 1L;
                    num.set(1, numSuccess);
                    long moneySuccess = (Long)num.get(2) + (long)model.totalAmount;
                    num.set(2, moneySuccess);
                }
            }
        });
        LogRechargeBankNLResponse res = new LogRechargeBankNLResponse(true, "0", (Long)num.get(0) / 50L + 1L, (Long)num.get(1), (Long)num.get(2), records);
        return res;
    }

    @Override
    public boolean saveLogIAP(Purchase pc, String nickname, int amount, int code, String des) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_iap");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("amount", (Object)amount);
        doc.append("code", (Object)code);
        doc.append("description", (Object)des);
        doc.append("trans_time", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("order_id", (Object)pc.getOrderId());
        doc.append("package_name", (Object)pc.getPackageName());
        doc.append("product_id", (Object)pc.getSku());
        doc.append("purchase_time", (Object)pc.getPurchaseTime());
        doc.append("purchase_state", (Object)pc.getPurchaseState());
        doc.append("developer_payload", (Object)pc.getDeveloperPayload());
        doc.append("token", (Object)pc.getToken());
        doc.append("signature", (Object)pc.getSignature());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean checkOrderId(String orderId) {
        boolean res = false;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("order_id", (Object)orderId);
        conditions.put("code", (Object)0);
        Document dc = (Document)db.getCollection("dvt_recharge_by_iap").find((Bson)conditions).first();
        if (dc != null) {
            res = true;
        }
        return res;
    }

    @Override
    public long getTotalRechargeIapInday(String nickname, Calendar cal) throws ParseException {
        long res = 0L;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        BasicDBObject obj = new BasicDBObject();
        Document conditions = new Document();
        if (nickname != null && !nickname.equals("")) {
            conditions.put("nick_name", (Object)nickname);
        }
        conditions.put("code", (Object)0);
        String timeStart = VinPlayUtils.getDateTimeStr((Date)VinPlayUtils.getDateTimeFromDate((String)VinPlayUtils.getDateFromDateTime((String)VinPlayUtils.getDateTimeStr((Date)cal.getTime()))));
        cal.add(5, 1);
        String timeEnd = VinPlayUtils.getDateTimeStr((Date)VinPlayUtils.getDateTimeFromDate((String)VinPlayUtils.getDateFromDateTime((String)VinPlayUtils.getDateTimeStr((Date)cal.getTime()))));
        obj.put("$gte", (Object)timeStart);
        obj.put("$lt", (Object)timeEnd);
        conditions.put("trans_time", (Object)obj);
        Document dc = (Document)db.getCollection("dvt_recharge_by_iap").aggregate(Arrays.asList(new Document[]{new Document("$match", (Object)conditions), new Document("$group", (Object)new Document("_id", null).append("money", (Object)new Document("$sum", (Object)"$amount")))})).first();
        if (dc != null) {
            res = dc.getInteger((Object)"money").intValue();
        }
        return res;
    }

    @Override
    public boolean checkRequestIdSMS(String requestId) {
        boolean res = false;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("request_id", (Object)requestId);
        Document dc = (Document)db.getCollection("dvt_recharge_by_sms").find((Bson)conditions).first();
        if (dc != null) {
            res = true;
        }
        return res;
    }

    @Override
    public boolean checkRequestIdSMSPlus(String requestId) {
        boolean res = false;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("request_id", (Object)requestId);
        Document dc = (Document)db.getCollection("dvt_recharge_by_sms_plus").find((Bson)conditions).first();
        if (dc != null) {
            res = true;
        }
        return res;
    }

    @Override
    public boolean saveLogRechargeBySMS(String nickname, String mobile, String moMessage, int amount, String shortCode, String requestId, String requestTime, int code, String des, int money) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("mobile", (Object)mobile);
        doc.append("message_MO", (Object)moMessage);
        doc.append("amount", (Object)amount);
        doc.append("money", (Object)money);
        doc.append("short_code", (Object)shortCode);
        doc.append("request_id", (Object)requestId);
        doc.append("time_request", (Object)requestTime);
        doc.append("code", (Object)code);
        doc.append("description", (Object)des);
        doc.append("time_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean saveLogRechargeBySMSPlus(String nickname, String mobile, String moMessage, int amount, String shortCode, String errorCode, String errorMessage, String requestId, String requestTime, int code, String des, int money) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms_plus");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("mobile", (Object)mobile);
        doc.append("message_MO", (Object)moMessage);
        doc.append("amount", (Object)amount);
        doc.append("money", (Object)money);
        doc.append("short_code", (Object)shortCode);
        doc.append("error_code", (Object)errorCode);
        doc.append("error_message", (Object)errorMessage);
        doc.append("request_id", (Object)requestId);
        doc.append("time_request", (Object)requestTime);
        doc.append("code", (Object)code);
        doc.append("description", (Object)des);
        doc.append("time_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean saveLogRechargeBySMSPlusCheckMO(String mobile, String moMessage, int amount, String shortCode, int code, String des) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms_plus_check_mo");
        Document doc = new Document();
        doc.append("mobile", (Object)mobile);
        doc.append("message_MO", (Object)moMessage);
        doc.append("amount", (Object)amount);
        doc.append("short_code", (Object)shortCode);
        doc.append("code", (Object)code);
        doc.append("description", (Object)des);
        doc.append("time_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public LogSMS8x98Response getLogSMS8x98(String nickname, String mobile, int amount, String shortCode, String requestId, int code, String startTime, String endTime, int page) {
        final ArrayList<LogSMS8x98> records = new ArrayList<LogSMS8x98>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        num.add(1, 0L);
        num.add(2, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms");
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            String pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!mobile.isEmpty()) {
            conditions.put("mobile", mobile);
        }
        if (amount >= 0) {
            conditions.put("amount", amount);
        }
        if (!shortCode.isEmpty()) {
            conditions.put("short_code", shortCode);
        }
        if (!requestId.isEmpty()) {
            conditions.put("request_id", requestId);
        }
        if (code >= 0) {
            conditions.put("code", code);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        FindIterable iterable = col.find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                String nickname = document.getString((Object)"nick_name");
                String mobile = document.getString((Object)"mobile");
                String moMessage = document.getString((Object)"message_MO");
                int amount = document.getInteger((Object)"amount");
                String shortCode = document.getString((Object)"short_code");
                String requestId = document.getString((Object)"request_id");
                String requestTime = document.getString((Object)"time_request");
                int code = document.getInteger((Object)"code");
                String des = document.getString((Object)"description");
                int money = document.getInteger((Object)"money");
                String timeLog = document.getString((Object)"time_log");
                LogSMS8x98 model = new LogSMS8x98(nickname, mobile, moMessage, amount, shortCode, requestId, requestTime, code, des, money, timeLog);
                records.add(model);
            }
        });
        FindIterable iterable2 = col.find((Bson)new Document(conditions));
        iterable2.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                int amount = document.getInteger((Object)"amount");
                int code = document.getInteger((Object)"code");
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
                if (code == 0) {
                    long numSuccess = (Long)num.get(1) + 1L;
                    num.set(1, numSuccess);
                    long moneySuccess = (Long)num.get(2) + (long)amount;
                    num.set(2, moneySuccess);
                }
            }
        });
        LogSMS8x98Response res = new LogSMS8x98Response(true, "0", (Long)num.get(0) / 50L + 1L, (Long)num.get(1), (Long)num.get(2), records);
        return res;
    }

    @Override
    public LogSMSPlusResponse getLogSMSPlus(String nickname, String mobile, int amount, String requestId, int code, String startTime, String endTime, int page) {
        final ArrayList<LogSMSPlus> records = new ArrayList<LogSMSPlus>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        num.add(1, 0L);
        num.add(2, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms_plus");
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            String pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!mobile.isEmpty()) {
            conditions.put("mobile", mobile);
        }
        if (amount >= 0) {
            conditions.put("amount", amount);
        }
        if (!requestId.isEmpty()) {
            conditions.put("request_id", requestId);
        }
        if (code >= 0) {
            conditions.put("code", code);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        FindIterable iterable = col.find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                String nickname = document.getString((Object)"nick_name");
                String mobile = document.getString((Object)"mobile");
                String moMessage = document.getString((Object)"message_MO");
                int amount = document.getInteger((Object)"amount");
                String shortCode = document.getString((Object)"short_code");
                String errorCode = document.getString((Object)"error_code");
                String errorMessage = document.getString((Object)"error_message");
                String requestId = document.getString((Object)"request_id");
                String requestTime = document.getString((Object)"time_request");
                int code = document.getInteger((Object)"code");
                String des = document.getString((Object)"description");
                int money = document.getInteger((Object)"money");
                String timeLog = document.getString((Object)"time_log");
                LogSMSPlus model = new LogSMSPlus(nickname, mobile, moMessage, amount, shortCode, errorCode, errorMessage, requestId, requestTime, code, des, money, timeLog);
                records.add(model);
            }
        });
        FindIterable iterable2 = col.find((Bson)new Document(conditions));
        iterable2.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                int amount = document.getInteger((Object)"amount");
                int code = document.getInteger((Object)"code");
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
                if (code == 0) {
                    long numSuccess = (Long)num.get(1) + 1L;
                    num.set(1, numSuccess);
                    long moneySuccess = (Long)num.get(2) + (long)amount;
                    num.set(2, moneySuccess);
                }
            }
        });
        LogSMSPlusResponse res = new LogSMSPlusResponse(true, "0", (Long)num.get(0) / 50L + 1L, (Long)num.get(1), (Long)num.get(2), records);
        return res;
    }

    @Override
    public List<String> getListSmsIdNearly() {
        final ArrayList<String> res = new ArrayList<String>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms");
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        FindIterable iterable = col.find().sort((Bson)objsort).skip(0).limit(1000);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                res.add(document.getString((Object)"request_id"));
            }
        });
        return res;
    }

    @Override
    public List<String> getListSmsPlusIdNearly() {
        final ArrayList<String> res = new ArrayList<String>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms_plus");
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        FindIterable iterable = col.find().sort((Bson)objsort).skip(0).limit(1000);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                res.add(document.getString((Object)"request_id"));
            }
        });
        return res;
    }

    @Override
    public LogSMSPlusCheckMoResponse getLogSMSPlusCheckMO(String mobile, int amount, int code, String startTime, String endTime, int page) {
        final ArrayList<LogSMSPlusCheckMO> records = new ArrayList<LogSMSPlusCheckMO>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_sms_plus_check_mo");
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!mobile.isEmpty()) {
            conditions.put("mobile", mobile);
        }
        if (amount >= 0) {
            conditions.put("amount", amount);
        }
        if (code >= 0) {
            conditions.put("code", code);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        FindIterable iterable = col.find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(numEnd);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                String mobile = document.getString((Object)"mobile");
                String moMessage = document.getString((Object)"message_MO");
                int amount = document.getInteger((Object)"amount");
                String shortCode = document.getString((Object)"short_code");
                int code = document.getInteger((Object)"code");
                String des = document.getString((Object)"description");
                String timeLog = document.getString((Object)"time_log");
                LogSMSPlusCheckMO model = new LogSMSPlusCheckMO(mobile, moMessage, amount, shortCode, code, des, timeLog);
                records.add(model);
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
            }
        });
        LogSMSPlusCheckMoResponse res = new LogSMSPlusCheckMoResponse(true, "0", (Long)num.get(0) / 50L + 1L, records);
        return res;
    }

    @Override
    public boolean saveLogRequestApiOTP(String nickname, String mobile, int amount, String errorCode, String errorMessage, String requestId, String transId, int code, String redirectURL) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_otp_request");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("mobile", (Object)mobile);
        doc.append("amount", (Object)amount);
        doc.append("error_code", (Object)errorCode);
        doc.append("error_message", (Object)errorMessage);
        doc.append("request_id", (Object)requestId);
        doc.append("trans_id", (Object)transId);
        doc.append("code", (Object)code);
        doc.append("redirect_url", (Object)redirectURL);
        doc.append("time_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public boolean saveLogConfirmApiOTP(String nickname, String mobile, int amount, String otp, String errorCode, String errorMessage, String requestId, String transId, int code, String des, int money) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_otp_confirm");
        Document doc = new Document();
        doc.append("nick_name", (Object)nickname);
        doc.append("mobile", (Object)mobile);
        doc.append("amount", (Object)amount);
        doc.append("otp", (Object)otp);
        doc.append("error_code", (Object)errorCode);
        doc.append("error_message", (Object)errorMessage);
        doc.append("request_id", (Object)requestId);
        doc.append("trans_id", (Object)transId);
        doc.append("code", (Object)code);
        doc.append("description", (Object)des);
        doc.append("money", (Object)money);
        doc.append("time_log", (Object)VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
        return true;
    }

    @Override
    public LogApiOtpConfirmResponse getApiOtpConfirm(String nickname, String mobile, int amount, String requestId, int code, String startTime, String endTime, int page) {
        final ArrayList<LogApiOtpConfirm> records = new ArrayList<LogApiOtpConfirm>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        num.add(1, 0L);
        num.add(2, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_otp_confirm");
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            String pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!mobile.isEmpty()) {
            conditions.put("mobile", mobile);
        }
        if (amount >= 0) {
            conditions.put("amount", amount);
        }
        if (!requestId.isEmpty()) {
            conditions.put("request_id", requestId);
        }
        if (code >= 0) {
            conditions.put("code", code);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        FindIterable iterable = col.find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                String nickname = document.getString((Object)"nick_name");
                String mobile = document.getString((Object)"mobile");
                int amount = document.getInteger((Object)"amount");
                String otp = document.getString((Object)"otp");
                String errorCode = document.getString((Object)"error_code");
                String errorMessage = document.getString((Object)"error_message");
                String requestId = document.getString((Object)"request_id");
                String transId = document.getString((Object)"trans_id");
                int code = document.getInteger((Object)"code");
                String des = document.getString((Object)"description");
                int money = document.getInteger((Object)"money");
                String timeLog = document.getString((Object)"time_log");
                LogApiOtpConfirm model = new LogApiOtpConfirm(nickname, mobile, amount, otp, errorCode, errorMessage, requestId, transId, code, des, money, timeLog);
                records.add(model);
            }
        });
        FindIterable iterable2 = col.find((Bson)new Document(conditions));
        iterable2.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                int amount = document.getInteger((Object)"amount");
                int code = document.getInteger((Object)"code");
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
                if (code == 0) {
                    long numSuccess = (Long)num.get(1) + 1L;
                    num.set(1, numSuccess);
                    long moneySuccess = (Long)num.get(2) + (long)amount;
                    num.set(2, moneySuccess);
                }
            }
        });
        LogApiOtpConfirmResponse res = new LogApiOtpConfirmResponse(true, "0", (Long)num.get(0) / 50L + 1L, (Long)num.get(1), (Long)num.get(2), records);
        return res;
    }

    @Override
    public LogApiOtpRequestResponse getApiOtpRequest(String nickname, String mobile, int amount, String requestId, int code, String startTime, String endTime, int page) {
        final ArrayList<LogApiOtpRequest> records = new ArrayList<LogApiOtpRequest>();
        final ArrayList<Long> num = new ArrayList<Long>();
        num.add(0, 0L);
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("dvt_recharge_by_otp_request");
        int numStart = (page - 1) * 50;
        int numEnd = 50;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        if (!nickname.isEmpty()) {
            String pattern = ".*" + nickname + ".*";
            conditions.put("nick_name", (Object)new BasicDBObject().append("$regex", (Object)pattern).append("$options", (Object)"i"));
        }
        if (!mobile.isEmpty()) {
            conditions.put("mobile", mobile);
        }
        if (amount >= 0) {
            conditions.put("amount", amount);
        }
        if (!requestId.isEmpty()) {
            conditions.put("request_id", requestId);
        }
        if (code >= 0) {
            conditions.put("code", code);
        }
        if (!startTime.isEmpty() && !endTime.isEmpty()) {
            BasicDBObject obj = new BasicDBObject();
            obj.put("$gte", (Object)startTime);
            obj.put("$lte", (Object)endTime);
            conditions.put("time_log", (Object)obj);
        }
        FindIterable iterable = col.find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(50);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                String nickname = document.getString((Object)"nick_name");
                String mobile = document.getString((Object)"mobile");
                int amount = document.getInteger((Object)"amount");
                String errorCode = document.getString((Object)"error_code");
                String errorMessage = document.getString((Object)"error_message");
                String requestId = document.getString((Object)"request_id");
                String transId = document.getString((Object)"trans_id");
                int code = document.getInteger((Object)"code");
                String redirectUrl = document.getString((Object)"redirect_url");
                String timeLog = document.getString((Object)"time_log");
                LogApiOtpRequest model = new LogApiOtpRequest(nickname, mobile, amount, errorCode, errorMessage, requestId, transId, code, redirectUrl, timeLog);
                records.add(model);
                long count = (Long)num.get(0) + 1L;
                num.set(0, count);
            }
        });
        LogApiOtpRequestResponse res = new LogApiOtpRequestResponse(true, "0", (Long)num.get(0) / 50L + 1L, records);
        return res;
    }

    @Override
    public boolean isAgent(String nickName) throws SQLException {
        boolean result = false;
        String sql = " SELECT *  FROM vinplay_admin.useragent  WHERE nickname = ? ";
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpool_admin");
        PreparedStatement stmt = null;
        ResultSet rs = null;
        try {
            stmt = conn.prepareStatement(" SELECT *  FROM vinplay_admin.useragent  WHERE nickname = ? ");
            stmt.setString(1, nickName);
            rs = stmt.executeQuery();
            while (rs.next()) {
                result = true;
            }
            rs.close();
            stmt.close();
        }
        catch (SQLException e) {
            e.printStackTrace();
            throw e;
        }
        finally {
            if (conn != null) {
                conn.close();
            }
        }
        return result;
    }

    @Override
    public Document getRechargeByGachthe(String transId) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("request_id", transId);
        return db.getCollection("dvt_recharge_by_gachthe").find(conditions).first();
    }

    @Override
    public Document getRechargeByGachthe(String nickname, String serial, String pin) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("nick_name", nickname);
        conditions.put("serial", serial);
        conditions.put("pin", pin);
        conditions.put("code", 30);
        return db.getCollection("dvt_recharge_by_gachthe").find(conditions).first();
    }

    @Override
    public boolean UpdateGachtheTransctions(String transId, int code, String message) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        conditions.put("request_id", transId);
        BasicDBObject updateFields = new BasicDBObject();
        updateFields.append("code", code);
        updateFields.append("description", message);
        db.getCollection("dvt_recharge_by_gachthe").updateOne(conditions, new Document("$set", updateFields));
        return true;
    }

    @Override
    public boolean saveLogRechargeByGachThe(String nickname, String serial, String pin, long amount, String requestId,
                                            String requestTime, int code, String des, long money, String provider, String platform,
                                            long currentMoney, long addMoney, int userId, String username, String partner, String client) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection<Document> col = db.getCollection("dvt_recharge_by_gachthe");
        Document doc = new Document();
        doc.append("nick_name", nickname);
        doc.append("serial", serial);
        doc.append("pin", pin);
        doc.append("amount", amount);
        doc.append("money", money);
        doc.append("provider", provider);
        doc.append("platform", platform);
        doc.append("request_id", requestId);
        doc.append("time_request", requestTime);
        doc.append("code", code);
        doc.append("description", des);
        doc.append("time_log", VinPlayUtils.getCurrentDateTime());
        doc.append("create_time", new Date());
        doc.append("is_sent", false);
        doc.append("current_money", currentMoney);
        doc.append("add_money", addMoney);
        doc.append("user_id", userId);
        doc.append("username", username);
        doc.append("partner", partner);
        doc.append("client", client);
        col.insertOne(doc);
        return true;
    }

}

