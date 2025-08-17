/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.hazelcast.core.HazelcastInstance
 *  com.hazelcast.core.IMap
 *  com.mongodb.BasicDBObject
 *  com.mongodb.Block
 *  com.mongodb.client.AggregateIterable
 *  com.mongodb.client.FindIterable
 *  com.mongodb.client.MongoCollection
 *  com.mongodb.client.MongoDatabase
 *  com.mongodb.client.result.UpdateResult
 *  com.vinplay.vbee.common.hazelcast.HazelcastClientFactory
 *  com.vinplay.vbee.common.messages.gamebai.LogNoHuGameBaiMessage
 *  com.vinplay.vbee.common.models.UserModel
 *  com.vinplay.vbee.common.models.cache.UserCacheModel
 *  com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory
 *  com.vinplay.vbee.common.pools.ConnectionPool
 *  com.vinplay.vbee.common.response.LogMoneyUserResponse
 *  com.vinplay.vbee.common.response.LogUserMoneyResponse
 *  com.vinplay.vbee.common.statics.Consts
 *  com.vinplay.vbee.common.utils.DateTimeUtils
 *  com.vinplay.vbee.common.utils.UserUtil
 *  org.bson.Document
 *  org.bson.conversions.Bson
 */
package com.vinplay.dal.dao.impl;

import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;
import com.mongodb.BasicDBObject;
import com.mongodb.Block;
import com.mongodb.client.AggregateIterable;
import com.mongodb.client.FindIterable;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import com.mongodb.client.result.UpdateResult;
import com.vinplay.dal.dao.LogMoneyUserDao;
import com.vinplay.dal.dao.impl.UserDaoImpl;
import com.vinplay.dal.entities.gamebai.TopGameBaiModel;
import com.vinplay.vbee.common.hazelcast.HazelcastClientFactory;
import com.vinplay.vbee.common.messages.gamebai.LogNoHuGameBaiMessage;
import com.vinplay.vbee.common.models.UserModel;
import com.vinplay.vbee.common.models.cache.UserCacheModel;
import com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory;
import com.vinplay.vbee.common.pools.ConnectionPool;
import com.vinplay.vbee.common.response.LogMoneyUserResponse;
import com.vinplay.vbee.common.response.LogUserMoneyResponse;
import com.vinplay.vbee.common.statics.Consts;
import com.vinplay.vbee.common.utils.DateTimeUtils;
import com.vinplay.vbee.common.utils.UserUtil;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.bson.Document;
import org.bson.conversions.Bson;

public class LogMoneyUserDaoImpl
implements LogMoneyUserDao {
    @Override
    public List<LogUserMoneyResponse> searchLogMoneyUser(String nickName, String userName, String moneyType, String serviceName, String actionName, String timeStart, String timeEnd, int page, int like, int totalRecord) {
        final ArrayList<LogUserMoneyResponse> results = new ArrayList<LogUserMoneyResponse>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        FindIterable iterable = null;
        BasicDBObject obj = new BasicDBObject();
        int numStart = (page - 1) * totalRecord;
        if (nickName != null && !nickName.equals("")) {
            conditions.put("nick_name", nickName);
        }
        if (userName != null && !userName.equals("")) {
            conditions.put("user_name", userName);
        }
        if (actionName != null && !actionName.equals("")) {
            conditions.put("action_name", actionName);
        }
        if (serviceName != null && !serviceName.equals("")) {
            conditions.put("service_name", serviceName);
        }
        if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
            obj.put("$gte", (Object)timeStart);
            obj.put("$lte", (Object)timeEnd);
            conditions.put("trans_time", obj);
        }

        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        if (moneyType.equals("vin")) {
            iterable = db.getCollection("log_money_user_vin").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(totalRecord);
        } else if (moneyType.equals("xu")) {
            iterable = db.getCollection("log_money_user_xu").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(totalRecord);
        }
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogUserMoneyResponse tranlogmoney = new LogUserMoneyResponse();
                tranlogmoney.nickName = document.getString((Object)"nick_name");
                tranlogmoney.serviceName = document.getString((Object)"service_name");
                tranlogmoney.currentMoney = document.getLong((Object)"current_money");
                tranlogmoney.moneyExchange = document.getLong((Object)"money_exchange");
                tranlogmoney.description = document.getString((Object)"description");
                tranlogmoney.transactionTime = document.getString((Object)"trans_time");
                tranlogmoney.actionName = document.getString((Object)"action_name");
                tranlogmoney.fee = document.getLong((Object)"fee");
                results.add(tranlogmoney);
            }
        });
        return results;
    }

    @Override
    public int countsearchLogMoneyUser(String nickName, String moneyType, String serviceName, String actionName, String timeStart, String timeEnd, int like) {
        int countRecord = 0;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        BasicDBObject obj = new BasicDBObject();
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        if (nickName != null && !nickName.equals("")) {
            if (like == 0) {
                conditions.put("nick_name", nickName);
            } else {
                conditions.put("nick_name", nickName);
            }
        }
        if (actionName != null && !actionName.equals("")) {
            conditions.put("action_name", actionName);
        }
        if (serviceName != null && !serviceName.equals("")) {
            conditions.put("service_name", serviceName);
        }
        if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
            obj.put("$gte", (Object)timeStart);
            obj.put("$lte", (Object)timeEnd);
            conditions.put("trans_time", obj);
        }
        if (moneyType.equals("vin")) {
            countRecord = (int)db.getCollection("log_money_user_vin").count((Bson)new Document(conditions));
        } else if (moneyType.equals("xu")) {
            countRecord = (int)db.getCollection("log_money_user_xu").count((Bson)new Document(conditions));
        }
        return countRecord;
    }

    @Override
    public List<LogMoneyUserResponse> getHistoryTransactionLogMoney(String nickName, int moneyType, int page) {
        int numStart = (page - 1) * 13;
        int numEnd = 13;
        List<LogMoneyUserResponse> result = this.getTransactionList(nickName, moneyType, numStart, 13);
        return result;
    }

    private Map<String, Object> buildConditionNapVin(String nickName) {
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        conditions.put("nick_name", nickName);
        return conditions;
    }

    private Map<String, Object> buildConditionTieuVin(String nickName) {
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        conditions.put("nick_name", nickName);
        return conditions;
    }

    private Map<String, Object> buildConditionTransaction(String nickName, int moneyType) {
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        conditions.put("nick_name", nickName);
        ArrayList<BasicDBObject> lstServerName = new ArrayList<BasicDBObject>();
        switch (moneyType) {
            case 4: {
                for (String action : Consts.NAP_XU) {
                    BasicDBObject query = new BasicDBObject("action_name", (Object)action);
                    lstServerName.add(query);
                }
                conditions.put("$or", lstServerName);
                conditions.put("money_exchange", (Object)new BasicDBObject("$gt", (Object)0));
            }
        }
        return conditions;
    }

    @Override
    public int countHistoryTransactionLogMoney(String nickName, int queryType) {
        int countRecord = 0;
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Map<String, Object> conditions = this.buildConditionTransaction(nickName, queryType);
        Map<String, Object> conditionNapVin = this.buildConditionNapVin(nickName);
        Map<String, Object> conditionTieuVin = this.buildConditionTieuVin(nickName);
        switch (queryType) {
            case 1: {
                countRecord = (int)db.getCollection("log_money_user_vin").count((Bson)new Document(conditions));
                break;
            }
            case 3: {
                countRecord = (int)db.getCollection("log_money_user_nap_vin").count((Bson)new Document(conditionNapVin));
                break;
            }
            case 5: {
                countRecord = (int)db.getCollection("log_money_user_tieu_vin").count((Bson)new Document(conditionTieuVin));
                break;
            }
            default: {
                countRecord = (int)db.getCollection("log_money_user_xu").count((Bson)new Document(conditions));
            }
        }
        return countRecord;
    }

    @Override
    public List<LogMoneyUserResponse> getTransactionList(String nickName, int queryType, int start, int end) {
        final ArrayList<LogMoneyUserResponse> results = new ArrayList<LogMoneyUserResponse>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Map<String, Object> conditions = this.buildConditionTransaction(nickName, queryType);
        Map<String, Object> conditionNapVin = this.buildConditionNapVin(nickName);
        Map<String, Object> conditionTieuVin = this.buildConditionTieuVin(nickName);
        FindIterable iterable = null;
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        switch (queryType) {
            case 1: {
                iterable = db.getCollection("log_money_user_vin").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(start).limit(end);
                break;
            }
            case 3: {
                iterable = db.getCollection("log_money_user_nap_vin").find((Bson)new Document(conditionNapVin)).sort((Bson)objsort).skip(start).limit(end);
                break;
            }
            case 5: {
                iterable = db.getCollection("log_money_user_tieu_vin").find((Bson)new Document(conditionTieuVin)).sort((Bson)objsort).skip(start).limit(end);
                break;
            }
            default: {
                iterable = db.getCollection("log_money_user_xu").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(start).limit(end);
            }
        }
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogMoneyUserResponse tranlogmoney = new LogMoneyUserResponse();
                tranlogmoney.transId = document.getLong((Object)"trans_id");
                tranlogmoney.serviceName = document.getString((Object)"service_name");
                tranlogmoney.currentMoney = document.getLong((Object)"current_money");
                tranlogmoney.moneyExchange = document.getLong((Object)"money_exchange");
                tranlogmoney.description = document.getString((Object)"description");
                tranlogmoney.transactionTime = document.getString((Object)"trans_time");
                results.add(tranlogmoney);
            }
        });
        return results;
    }

    @Override
    public Map<String, TopGameBaiModel> getTopGameBai(String gameName) {
        TopGameBaiModel model;
        HashMap<String, TopGameBaiModel> result = new HashMap<String, TopGameBaiModel>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection collection = db.getCollection("log_money_user_xu");
        Document conditionWin = new Document();
        conditionWin.put("action_name", (Object)gameName);
        conditionWin.put("money_exchange", (Object)new BasicDBObject("$gt", (Object)0));
        Document conditionWinWeek = new Document();
        conditionWinWeek.put("action_name", (Object)gameName);
        conditionWinWeek.put("money_exchange", (Object)new BasicDBObject("$gt", (Object)0));
        String startTime = "2016-10-17 00;00;00";
        BasicDBObject obj = new BasicDBObject();
        obj.put("$gte", (Object)"2016-10-17 00;00;00");
        conditionWinWeek.put("trans_time", (Object)obj);
        AggregateIterable iterableWin = collection.aggregate(Arrays.asList(new Document[]{new Document("$match", (Object)conditionWin), new Document("$group", (Object)new Document("_id", (Object)"$nick_name").append("money", (Object)new Document("$sum", (Object)"$money_exchange")).append("count", (Object)new Document("$sum", (Object)1)))}));
        final ArrayList<TopGameBaiModel> resultWin = new ArrayList();
        iterableWin.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                TopGameBaiModel top = new TopGameBaiModel();
                top.setNickName(document.getString((Object)"_id"));
                top.setWinCount(document.getInteger((Object)"count"));
                top.setMoneyWin(document.getLong((Object)"money"));
                resultWin.add(top);
            }
        });
        AggregateIterable iterableWinWeek = collection.aggregate(Arrays.asList(new Document[]{new Document("$match", (Object)conditionWinWeek), new Document("$group", (Object)new Document("_id", (Object)"$nick_name").append("money", (Object)new Document("$sum", (Object)"$money_exchange")).append("count", (Object)new Document("$sum", (Object)1)))}));
        final ArrayList<TopGameBaiModel> resultWinWeek = new ArrayList();
        iterableWinWeek.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                TopGameBaiModel top = new TopGameBaiModel();
                top.setNickName(document.getString((Object)"_id"));
                top.setWinCountThisWeek(document.getInteger((Object)"count"));
                top.setMoneyWinThisWeek(document.getLong((Object)"money"));
                resultWinWeek.add(top);
            }
        });
        Document conditionLost = new Document();
        conditionLost.put("action_name", (Object)gameName);
        conditionLost.put("money_exchange", (Object)new BasicDBObject("$lt", (Object)0));
        Document conditionLostWeek = new Document();
        conditionLostWeek.put("action_name", (Object)gameName);
        conditionLostWeek.put("money_exchange", (Object)new BasicDBObject("$lt", (Object)0));
        conditionLostWeek.put("trans_time", (Object)obj);
        AggregateIterable iterableLost = collection.aggregate(Arrays.asList(new Document[]{new Document("$match", (Object)conditionLost), new Document("$group", (Object)new Document("_id", (Object)"$nick_name").append("money", (Object)new Document("$sum", (Object)"$money_exchange")).append("count", (Object)new Document("$sum", (Object)1)))}));
        final ArrayList<TopGameBaiModel> resultLost = new ArrayList();
        iterableLost.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                TopGameBaiModel top = new TopGameBaiModel();
                top.setNickName(document.getString((Object)"_id"));
                top.setLostCount(document.getInteger((Object)"count"));
                top.setMoneyLost(document.getLong((Object)"money"));
                resultLost.add(top);
            }
        });
        AggregateIterable iterablLostWeek = collection.aggregate(Arrays.asList(new Document[]{new Document("$match", (Object)conditionLostWeek), new Document("$group", (Object)new Document("_id", (Object)"$nick_name").append("money", (Object)new Document("$sum", (Object)"$money_exchange")).append("count", (Object)new Document("$sum", (Object)1)))}));
        final ArrayList<TopGameBaiModel> resultLostWeek = new ArrayList();
        iterablLostWeek.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                TopGameBaiModel top = new TopGameBaiModel();
                top.setNickName(document.getString((Object)"_id"));
                top.setLostCountThisWeek(document.getInteger((Object)"count"));
                top.setMoneyLostThisWeek(document.getLong((Object)"money"));
                resultLostWeek.add(top);
            }
        });
        for (TopGameBaiModel top : resultWin) {
            top.setWinCountThisMonth(top.getWinCount());
            top.setWinCountThisYear(top.getWinCount());
            top.setMoneyWinThisMonth(top.getMoneyWin());
            top.setMoneyWinThisYear(top.getMoneyWin());
            result.put(top.getNickName(), top);
        }
        for (TopGameBaiModel top : resultWinWeek) {
            if (!result.containsKey(top.getNickName())) continue;
            model = (TopGameBaiModel)result.get(top.getNickName());
            model.setWinCountThisWeek(top.getWinCountThisWeek());
            model.setMoneyWinThisWeek(top.getMoneyWinThisWeek());
            result.put(top.getNickName(), model);
        }
        for (TopGameBaiModel top : resultLost) {
            if (result.containsKey(top.getNickName())) {
                model = (TopGameBaiModel)result.get(top.getNickName());
                model.setLostCount(top.getLostCount());
                model.setLostCountThisMonth(top.getLostCount());
                model.setLostCountThisYear(top.getLostCount());
                model.setMoneyLost(top.getMoneyLost());
                model.setMoneyLostThisMonth(top.getMoneyLost());
                model.setMoneyLostThisYear(top.getMoneyLost());
                result.put(top.getNickName(), model);
                continue;
            }
            top.setLostCountThisMonth(top.getLostCount());
            top.setLostCountThisYear(top.getLostCount());
            top.setMoneyLostThisMonth(top.getMoneyLost());
            top.setMoneyLostThisYear(top.getMoneyLost());
            result.put(top.getNickName(), top);
        }
        for (TopGameBaiModel top : resultLostWeek) {
            if (!result.containsKey(top.getNickName())) continue;
            model = (TopGameBaiModel)result.get(top.getNickName());
            model.setLostCountThisWeek(top.getLostCountThisWeek());
            model.setMoneyLostThisWeek(top.getMoneyLostThisWeek());
            result.put(top.getNickName(), model);
        }
        return result;
    }

    @Override
    public List<LogNoHuGameBaiMessage> getNoHuGameBaiHistory(int pageNumber, String gameName) {
        int pageSize = 10;
        int skipNumber = (pageNumber - 1) * 10;
        final ArrayList<LogNoHuGameBaiMessage> results = new ArrayList<LogNoHuGameBaiMessage>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        FindIterable iterable = null;
        Document conditions = new Document();
        if (gameName != null && !gameName.isEmpty()) {
            conditions.put("game_name", (Object)gameName);
        } else {
            conditions.put("game_name", (Object)new Document("$ne", (Object)"PokerTour"));
        }
        BasicDBObject sortCondtions = new BasicDBObject();
        sortCondtions.put("_id", -1);
        iterable = db.getCollection("log_no_hu_game_bai").find((Bson)conditions).sort((Bson)sortCondtions).skip(skipNumber).limit(10);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                LogNoHuGameBaiMessage entry = new LogNoHuGameBaiMessage(document.getString((Object)"nick_name"), document.getInteger((Object)"room").intValue(), document.getLong((Object)"pot_value").longValue(), document.getLong((Object)"money_win").longValue(), document.getString((Object)"game_name"), document.getString((Object)"description"), document.getString((Object)"tour_id"));
                entry.setCreateTime(document.getString((Object)"trans_time"));
                results.add(entry);
            }
        });
        return results;
    }

    @Override
    public int countNoHuGameBaiHistory() {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        Document conditions = new Document();
        long totalRows = db.getCollection("log_no_hu_game_bai").count((Bson)conditions);
        return (int)totalRows;
    }

    @Override
    public UserModel getUserByNickName(String nickname) throws SQLException {
        UserModel user = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT * FROM users WHERE nick_name=?");
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                user = UserUtil.parseResultSetToUserModel((ResultSet)rs);
            }
            rs.close();
            stm.close();
        }
        return user;
    }

    @Override
    public List<LogUserMoneyResponse> searchLogMoneyTranferUser(String nickName, String timeStart, String timeEnd, String type, int page) {
        final ArrayList<LogUserMoneyResponse> results = new ArrayList<LogUserMoneyResponse>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        FindIterable iterable = null;
        BasicDBObject obj = new BasicDBObject();
        BasicDBObject objsort = new BasicDBObject();
        objsort.put("_id", -1);
        int numStart = (page - 1) * 100;
        int numEnd = 100;
        conditions.put("action_name", "TransferMoney");
        if (!nickName.isEmpty()) {
            conditions.put("nick_name", nickName);
        }
        if (!timeStart.isEmpty() && !timeEnd.isEmpty()) {
            obj.put("$gte", (Object)timeStart);
            obj.put("$lte", (Object)timeEnd);
            conditions.put("trans_time", obj);
        }
        if (type.equals("1")) {
            iterable = db.getCollection("log_money_user_tieu_vin").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(100);
        } else if (type.equals("2")) {
            iterable = db.getCollection("log_money_user_nap_vin").find((Bson)new Document(conditions)).sort((Bson)objsort).skip(numStart).limit(100);
        }
        iterable.forEach((Block)new Block<Document>(){

            /*
             * WARNING - Removed try catching itself - possible behaviour change.
             */
            public void apply(Document document) {
                LogUserMoneyResponse tranlogmoney = new LogUserMoneyResponse();
                tranlogmoney.nickName = document.getString((Object)"nick_name");
                HazelcastInstance client = HazelcastClientFactory.getInstance();
                IMap<String, UserModel> userMap = client.getMap("users");
                if (userMap.containsKey((Object)tranlogmoney.nickName)) {
                    try {
                         userMap.lock(tranlogmoney.nickName);
                        UserCacheModel user = (UserCacheModel)userMap.get((Object)tranlogmoney.nickName);
                        tranlogmoney.userName = user.getUsername();
                    }
                    catch (Exception user) {
                    }
                    finally {
                         userMap.unlock(tranlogmoney.nickName);
                    }
                } else {
                    UserDaoImpl dao = new UserDaoImpl();
                    try {
                        UserModel user2 = dao.getUserByNickName(tranlogmoney.nickName);
                        tranlogmoney.userName = user2.getUsername();
                    }
                    catch (SQLException e) {
                        e.printStackTrace();
                    }
                }
                tranlogmoney.serviceName = document.getString((Object)"service_name");
                tranlogmoney.currentMoney = document.getLong((Object)"current_money");
                tranlogmoney.moneyExchange = document.getLong((Object)"money_exchange");
                tranlogmoney.description = document.getString((Object)"description");
                tranlogmoney.transactionTime = document.getString((Object)"trans_time");
                tranlogmoney.actionName = document.getString((Object)"action_name");
                tranlogmoney.fee = document.getLong((Object)"fee");
                results.add(tranlogmoney);
            }
        });
        return results;
    }

    @Override
    public boolean UpdateProcessLogChuyenTienDaiLy(String nickNameSend, String nickNameReceive, String timeLog, String Status) {
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("log_chuyen_tien_dai_ly");
        HashMap<String, Object> conditions = new HashMap<String, Object>();
        conditions.put("trans_time", timeLog);
        conditions.put("nick_name_send", nickNameSend);
        conditions.put("nick_name_receive", nickNameReceive);
        col.updateOne((Bson)new Document(conditions), (Bson)new Document("$set", (Object)new Document("process", (Object)Integer.parseInt(Status))));
        return true;
    }

    @Override
    public boolean UpdateProcessLogChuyenTienDaiLyMySQL(String nickNameSend, String nickNameReceive, String timeLog, String Status) throws SQLException {
        String sql = " UPDATE vinplay.log_tranfer_agent  SET process = ?,      update_time = ?  WHERE trans_time = ?        AND nick_name_send = ?        AND nick_name_receive = ? ";
        PreparedStatement stmt = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            stmt = conn.prepareStatement(" UPDATE vinplay.log_tranfer_agent  SET process = ?,      update_time = ?  WHERE trans_time = ?        AND nick_name_send = ?        AND nick_name_receive = ? ");
            stmt.setInt(1, Integer.parseInt(Status));
            stmt.setString(2, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            stmt.setString(3, timeLog);
            stmt.setString(4, nickNameSend);
            stmt.setString(5, nickNameReceive);
            stmt.executeUpdate();
            stmt.close();
        }
        return true;
    }

}

