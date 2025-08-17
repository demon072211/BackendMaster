/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.mongodb.BasicDBObject
 *  com.mongodb.Block
 *  com.mongodb.client.FindIterable
 *  com.mongodb.client.MongoCollection
 *  com.mongodb.client.MongoDatabase
 *  com.vinplay.vbee.common.models.StatusUser
 *  com.vinplay.vbee.common.models.TopCaoThu
 *  com.vinplay.vbee.common.models.UserAdminInfo
 *  com.vinplay.vbee.common.models.UserModel
 *  com.vinplay.vbee.common.models.cache.UserCacheModel
 *  com.vinplay.vbee.common.models.userMission.MissionObj
 *  com.vinplay.vbee.common.models.userMission.UserMissionCacheModel
 *  com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory
 *  com.vinplay.vbee.common.pools.ConnectionPool
 *  com.vinplay.vbee.common.response.UserInfoModel
 *  com.vinplay.vbee.common.utils.DateTimeUtils
 *  com.vinplay.vbee.common.utils.UserUtil
 *  org.bson.Document
 *  org.bson.conversions.Bson
 */
package com.vinplay.usercore.dao.impl;

import com.mongodb.BasicDBObject;
import com.mongodb.Block;
import com.mongodb.client.FindIterable;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import com.vinplay.usercore.dao.UserDao;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.vbee.common.models.*;
import com.vinplay.vbee.common.models.cache.UserCacheModel;
import com.vinplay.vbee.common.models.userMission.MissionObj;
import com.vinplay.vbee.common.models.userMission.UserMissionCacheModel;
import com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory;
import com.vinplay.vbee.common.pools.ConnectionPool;
import com.vinplay.vbee.common.response.UserInfoModel;
import com.vinplay.vbee.common.utils.DateTimeUtils;
import com.vinplay.vbee.common.utils.UserUtil;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import org.bson.Document;
import org.bson.conversions.Bson;

public class UserDaoImpl
implements UserDao {

    public boolean checkActiveFirstEvent(int userId) throws SQLException {
        boolean active_first_event = false;
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        String sql = "SELECT active_first_event FROM users WHERE id="+userId;
        PreparedStatement stm = conn.prepareStatement(sql);
        ResultSet rs = stm.executeQuery();
        if (rs.next()) {
            active_first_event = rs.getBoolean("active_first_event");
        }
        rs.close();
        stm.close();
        if (conn != null) {
            conn.close();
        }
        return active_first_event;
    }

    public String getRefCodeByUserId(int userId) throws SQLException {
        String ref_code = "";
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        try {
            String sql = "SELECT ref_code FROM users WHERE id=" + userId;
            PreparedStatement stm = conn.prepareStatement(sql);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                ref_code = rs.getString("ref_code");
            }
            rs.close();
            stm.close();
        }catch (Exception e){

        }finally{
            ConnectionPool.getInstance().releaseConnection(conn);
        }
        return ref_code;
    }

    public long getValueEventByRef(String ref_code) throws SQLException {
        long moneyEvent = 0;
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        try {
            String sql = "SELECT money FROM PriorityRefInfo WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setString(1, ref_code);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                moneyEvent = rs.getLong("money");
            }
            rs.close();
            stm.close();
        }catch (Exception e){

        }finally{
            ConnectionPool.getInstance().releaseConnection(conn);
        }
        return moneyEvent;
    }

    public void InsertLogMoneyPromotion(String nick_name,String ref_code, String description, long money){
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        MongoCollection col = db.getCollection("log_money_promotion");;
        Document doc = new Document();
        doc.append("nick_name", (Object)nick_name);
        doc.append("ref_code", (Object)ref_code);
        doc.append("description", (Object)description);
        doc.append("money", (Object)money);
       // doc.append("create_time", (Object)new Date());
        col.insertOne((Object)doc);
    }
    @Override
    public boolean checkUsername(String username) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            int cnt;
            String sql = "SELECT COUNT(1) as cnt FROM users WHERE user_name=? OR nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT COUNT(1) as cnt FROM users WHERE user_name=? OR nick_name=?");
            stm.setString(1, username);
            stm.setString(2, username);
            ResultSet rs = stm.executeQuery();
            if (rs.next() && (cnt = rs.getInt("cnt")) == 1) {
                res = true;
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public boolean checkNickname(String nickname) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            int cnt;
            String sql = "SELECT COUNT(1) as cnt FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT COUNT(1) as cnt FROM users WHERE nick_name=?");
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next() && (cnt = rs.getInt("cnt")) == 1) {
                res = true;
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public int checkAgent(String nickname) throws SQLException {
        int res = -1;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT dai_ly FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT dai_ly FROM users WHERE nick_name=?");
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                res = rs.getInt("dai_ly");
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public boolean checkNicknameExist(String nickname) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            int cnt;
            String sql = "SELECT COUNT(1) as cnt FROM users WHERE nick_name=? OR user_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT COUNT(1) as cnt FROM users WHERE nick_name=? OR user_name=?");
            stm.setString(1, nickname);
            stm.setString(2, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next() && (cnt = rs.getInt("cnt")) == 1) {
                res = true;
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public boolean updateMoney(int userId, long money, String moneyType) throws SQLException {
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        CallableStatement call = null;
        try {
            call = conn.prepareCall("CALL update_money_db(?,?,?)");
            int param = 1;
            call.setInt(param++, userId);
            call.setLong(param++, money);
            call.setString(param++, moneyType);
            call.executeUpdate();
        }
        catch (SQLException e) {
            throw e;
        }
        finally {
            if (call != null) {
                call.close();
            }
            if (conn != null) {
                conn.close();
            }
        }
        return true;
    }

    @Override
    public boolean updateRechargeMoney(int userId, long money) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "update users set recharge_money = recharge_money + ? where id=?";
            PreparedStatement stm = conn.prepareStatement("update users set recharge_money = recharge_money + ? where id=?");
            stm.setLong(1, money);
            stm.setInt(2, userId);
            if (stm.executeUpdate() == 1) {
                res = true;
            }
            stm.close();
        }
        return res;
    }

    @Override
    public UserModel getUserByUserName(String username) throws SQLException {
        UserModel user = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM users WHERE user_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT * FROM users WHERE user_name=?");
            stm.setString(1, username);
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
    public UserModel getUserByFBId(String fbId) throws SQLException {
        UserModel user = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM users WHERE facebook_id=?";
            PreparedStatement stm = conn.prepareStatement("SELECT * FROM users WHERE facebook_id=?");
            stm.setString(1, fbId);
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
    public UserModel getUserByGGId(String ggId) throws SQLException {
        UserModel user = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM users WHERE google_id=?";
            PreparedStatement stm = conn.prepareStatement("SELECT * FROM users WHERE google_id=?");
            stm.setString(1, ggId);
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
    public long getMoneyUser(String nickname, String moneyType) throws SQLException {
        long money = 0L;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT " + moneyType + " FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                money = rs.getLong(moneyType);
            }
            rs.close();
            stm.close();
        }
        return money;
    }

    @Override
    public long getCurrentMoney(String nickname, String moneyType) throws SQLException {
        long money = 0L;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT " + moneyType + "_total FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                money = rs.getLong(moneyType + "_total");
            }
            rs.close();
            stm.close();
        }
        return money;
    }

    @Override
    public int getIdByNickname(String nickname) throws SQLException {
        int userId = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT id FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT id FROM users WHERE nick_name=?");
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                userId = rs.getInt("id");
            }
            rs.close();
            stm.close();
        }
        return userId;
    }

    @Override
    public int getIdByUsername(String username) throws SQLException {
        int userId = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT id FROM users WHERE user_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT id FROM users WHERE user_name=?");
            stm.setString(1, username);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                userId = rs.getInt("id");
            }
            rs.close();
            stm.close();
        }
        return userId;
    }

    @Override
    public boolean restoreMoneyByAdmin(int userId, long moneyUse, long moneyTotal, long moneySafe, String moneyType) throws SQLException {
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        CallableStatement call = null;
        try {
            call = conn.prepareCall("CALL update_money_cache(?,?,?,?,?)");
            int param = 1;
            call.setInt(param++, userId);
            call.setLong(param++, moneyUse);
            call.setLong(param++, moneyTotal);
            call.setLong(param++, moneySafe);
            call.setString(param++, moneyType);
            call.executeUpdate();
        }
        catch (SQLException e) {
            throw e;
        }
        finally {
            if (call != null) {
                call.close();
            }
            if (conn != null) {
                conn.close();
            }
        }
        return true;
    }

    @Override
    public boolean checkMobile(String mobile) throws SQLException {
        boolean res = false;
        int cnt = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT COUNT(1) as cnt FROM users WHERE mobile=?";
            PreparedStatement stm = conn.prepareStatement("SELECT COUNT(1) as cnt FROM users WHERE mobile=?");
            stm.setString(1, mobile);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                cnt = rs.getInt("cnt");
            }
            rs.close();
            stm.close();
        }
        res = cnt >= 1;
        return res;
    }

    @Override
    public boolean checkMobileDaiLy(String mobile) throws SQLException {
        boolean res = false;
        int status = -1;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT status FROM users WHERE mobile=? AND dai_ly <> 0";
            PreparedStatement stm = conn.prepareStatement("SELECT status FROM users WHERE mobile=? AND dai_ly <> 0");
            stm.setString(1, mobile);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                status = rs.getInt("status");
            }
            rs.close();
            stm.close();
        }
        if (status >= 0 && StatusUser.checkStatus((int)status, (int)4)) {
            res = true;
        }
        return res;
    }

    @Override
    public boolean checkMobileSecurity(String mobile) throws SQLException {
        boolean res = false;
        int status = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT status FROM users WHERE mobile=?";
            PreparedStatement stm = conn.prepareStatement("SELECT status FROM users WHERE mobile=?");
            stm.setString(1, mobile);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                status = rs.getInt("status");
                if ((status & 16) == 0) continue;
                res = true;
                break;
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public boolean checkEmailSecurity(String email) throws SQLException {
        boolean res = false;
        int status = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT status FROM users WHERE email=?";
            PreparedStatement stm = conn.prepareStatement("SELECT status FROM users WHERE email=?");
            stm.setString(1, email);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                status = rs.getInt("status");
                if ((status & 32) == 0) continue;
                res = true;
                break;
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public List<TopCaoThu> getTopCaoThu(String date, String moneyType, int num) {
        final ArrayList<TopCaoThu> results = new ArrayList<TopCaoThu>();
        MongoDatabase db = MongoDBConnectionFactory.getDB();
        FindIterable iterable = null;
        Document conditions = new Document();
        conditions.put("date", (Object)date);
        conditions.put("money_win", (Object)new BasicDBObject("$gt", (Object)0));
        BasicDBObject sortCondtions = new BasicDBObject();
        sortCondtions.put("money_win", -1);
        iterable = moneyType.equals("vin") ? db.getCollection("top_user_play_game_vin").find((Bson)conditions).sort((Bson)sortCondtions).limit(num) : db.getCollection("top_user_play_game_xu").find((Bson)conditions).sort((Bson)sortCondtions).limit(num);
        iterable.forEach((Block)new Block<Document>(){

            public void apply(Document document) {
                results.add(new TopCaoThu(document.getString((Object)"nick_name"), document.getLong((Object)"money_win").longValue()));
            }
        });
        return results;
    }

    @Override
    public UserModel getUserNormalByNickName(String nickName) throws SQLException {
        UserModel user = null;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM users WHERE nick_name=? and dai_ly=0";
            PreparedStatement stm = conn.prepareStatement("SELECT * FROM users WHERE nick_name=? and dai_ly=0");
            stm.setString(1, nickName);
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
    public boolean updateStatusDailyByNickName(String nickName, int status) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "update users set dai_ly='" + status + "' where nick_name='" + nickName + "'";
            PreparedStatement stm = conn.prepareStatement(sql);
            if (stm.executeUpdate() == 1) {
                res = true;
            }
            stm.close();
        }
        return res;
    }

    @Override
    public List<UserAdminInfo> searchUserAdmin(String userName, String nickName, String phone, String field, String sort, String daily, String timeStart, String timeEnd, int page, int totalrecord, String bot, String like, String emailAddress) throws SQLException {
        ArrayList<UserAdminInfo> result = new ArrayList<UserAdminInfo>();
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "select * from users where 1=1";
            int num_start = (page - 1) * totalrecord;
            int index = 1;
            String limit = " LIMIT " + num_start + ", " + totalrecord + "";
            if (like.equals("1")) {
                if (userName != null && !userName.equals("")) {
                    sql = sql + " AND user_name like ?";
                }
                if (nickName != null && !nickName.equals("")) {
                    sql = sql + " AND nick_name like ?";
                }
                if (emailAddress != null && !emailAddress.equals("")) {
                    sql = sql + " AND email like ?";
                }
            } else {
                if (userName != null && !userName.equals("")) {
                    sql = sql + " AND user_name =?";
                }
                if (nickName != null && !nickName.equals("")) {
                    sql = sql + " AND nick_name=?";
                }
                if (emailAddress != null && !emailAddress.equals("")) {
                    sql = sql + " AND email = ?";
                }
            }
            if (phone != null && !phone.equals("")) {
                sql = sql + " AND mobile=?";
            }
            if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
                sql = sql + " AND create_time BETWEEN ? AND ? ";
            }
            if (daily != null && !daily.equals("")) {
                sql = sql + " AND dai_ly=?";
            }
            if (bot != null && !bot.equals("")) {
                sql = sql + " AND is_bot=?";
            }
            if (field != null && !field.equals("")) {
                if (field.equals("1")) {
                    sql = sql + " order by vin_total";
                }
                if (field.equals("2")) {
                    sql = sql + " order by xu_total";
                }
                if (field.equals("3")) {
                    sql = sql + " order by safe";
                }
                if (field.equals("4")) {
                    sql = sql + " order by vip_point";
                }
                if (field.equals("5")) {
                    sql = sql + " order by vip_point_save";
                }
                if (field.equals("6")) {
                    sql = sql + " order by recharge_money";
                }
                if (sort.equals("1")) {
                    sql = sql + " ASC";
                }
                if (sort.equals("2")) {
                    sql = sql + " DESC";
                }
                sql = sql + limit;
            } else {
                sql = sql + " order by id DESC" + limit;
            }
            PreparedStatement stm = conn.prepareStatement(sql);
            if (userName != null && !userName.equals("")) {
                if (like.equals("1")) {
                    stm.setString(index, '%' + userName + '%');
                } else {
                    stm.setString(index, userName);
                }
                ++index;
            }
            if (nickName != null && !nickName.equals("")) {
                if (like.equals("1")) {
                    stm.setString(index, '%' + nickName + '%');
                } else {
                    stm.setString(index, nickName);
                }
                ++index;
            }
            if (emailAddress != null && !emailAddress.equals("")) {
                if (like.equals("1")) {
                    stm.setString(index, '%' + emailAddress + '%');
                } else {
                    stm.setString(index, emailAddress);
                }
                ++index;
            }
            if (phone != null && !phone.equals("")) {
                stm.setString(index, phone);
                ++index;
            }
            if (daily != null && !daily.equals("")) {
                stm.setInt(index, Integer.parseInt(daily));
                ++index;
            }
            if (bot != null && !bot.equals("")) {
                stm.setInt(index, Integer.parseInt(bot));
                ++index;
            }
            if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
                stm.setString(index, timeStart);
                stm.setString(index + 1, timeEnd);
                ++index;
            }
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                String username = rs.getString("user_name");
                String nickname = rs.getString("nick_name");
                String email = rs.getString("email");
                String mobile = rs.getString("mobile");
                long vinTotal = rs.getLong("vin_total");
                long xuTotal = rs.getLong("xu_total");
                long safe = rs.getLong("safe");
                long rechargeMoney = rs.getLong("recharge_money");
                int vippoint = rs.getInt("vip_point");
                int status = rs.getInt("status");
                String identification = rs.getString("identification");
                int vippointSave = rs.getInt("vip_point_save");
                long loginOtp = rs.getLong("login_otp");
                boolean bots = rs.getInt("is_bot") == 1;
                String sCreateTime = rs.getString("create_time");
                String sSecurityTime = rs.getString("security_time");
                String facebookId = rs.getString("facebook_id");
                String googleId = rs.getString("google_id");
                String birthday = rs.getString("birthday");
                UserAdminInfo user = new UserAdminInfo(username, nickname, email, mobile, identification, vinTotal, xuTotal, safe, rechargeMoney, vippoint, vippointSave, loginOtp, bots, sCreateTime, sSecurityTime, status, googleId, facebookId, birthday);
                result.add(user);
            }
            rs.close();
            stm.close();
        }
        return result;
    }

    @Override
    public int countSearchUserAdmin(String userName, String nickName, String phone, String field, String sort, String daily, String timeStart, String timeEnd, String bot) throws SQLException {
        int cnt = 0;
        String order = "";
        String sort2 = "";
        String sql = "";
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String query = "select count(*) as cnt from users where 1=1";
            String condition = "";
            if (userName != null && !userName.equals("")) {
                condition = condition + " AND user_name like '%" + userName + "%'";
            }
            if (nickName != null && !nickName.equals("")) {
                condition = condition + " AND nick_name like '%" + nickName + "%'";
            }
            if (phone != null && !phone.equals("")) {
                condition = condition + " AND mobile = '" + phone + "'";
            }
            if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
                condition = condition + " AND create_time BETWEEN '" + timeStart + "' AND '" + timeEnd + "'";
            }
            if (daily != null && !daily.equals("")) {
                condition = condition + " AND dai_ly=" + Integer.parseInt(daily);
            }
            if (bot != null && !bot.equals(null)) {
                condition = condition + " AND is_bot=" + Integer.parseInt(bot);
            }
            if (field != null && !field.equals("")) {
                if (field.equals("1")) {
                    order = order + " order by vin_total";
                }
                if (field.equals("2")) {
                    order = order + " order by xu_total";
                }
                if (field.equals("3")) {
                    order = order + " order by safe";
                }
                if (field.equals("4")) {
                    order = order + " order by vip_point";
                }
                if (field.equals("5")) {
                    order = order + " order by vip_point_save";
                }
                if (field.equals("6")) {
                    order = order + " order by recharge_money";
                }
                if (sort.equals("1")) {
                    sort2 = sort2 + " ASC";
                }
                if (sort.equals("2")) {
                    sort2 = sort2 + " DESC";
                }
                sql = "select count(*) as cnt from users where 1=1" + condition + order + sort2;
            } else {
                order = " order by id DESC";
                sql = "select count(*) as cnt from users where 1=1" + condition + order;
            }
            PreparedStatement stm = conn.prepareStatement(sql);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                cnt = rs.getInt("cnt");
            }
            rs.close();
            stm.close();
        }
        return cnt;
    }

    @Override
    public boolean insertBot(String un, String nn, String pw, long vin, long xu, int status) throws SQLException {
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        CallableStatement call = null;
        try {
            call = conn.prepareCall("CALL insert_bot(?,?,?,?,?,?)");
            int param = 1;
            call.setString(param++, un);
            call.setString(param++, nn);
            call.setString(param++, pw);
            call.setLong(param++, vin);
            call.setLong(param++, xu);
            call.setInt(param++, status);
            call.executeUpdate();
        }
        catch (SQLException e) {
            throw e;
        }
        finally {
            if (call != null) {
                call.close();
            }
            if (conn != null) {
                conn.close();
            }
        }
        return true;
    }

    @Override
    public int checkBotByNickname(String nickname) throws SQLException {
        int res = 0;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT is_bot FROM users WHERE nick_name=?";
            PreparedStatement stm = conn.prepareStatement("SELECT is_bot FROM users WHERE nick_name=?");
            stm.setString(1, nickname);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                res = rs.getInt("is_bot");
            }
            rs.close();
            stm.close();
        }
        return res;
    }

    @Override
    public List<UserInfoModel> checkPhoneByUser(String phone) throws SQLException {
        ArrayList<UserInfoModel> user = new ArrayList<UserInfoModel>();
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT user_name,nick_name,recharge_money,status,mobile FROM users WHERE mobile in (" + phone + ")";
            PreparedStatement stm = conn.prepareStatement(sql);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                UserInfoModel model = new UserInfoModel();
                model.nickName = rs.getString("nick_name");
                model.userName = rs.getString("user_name");
                model.rechargeMoney = rs.getLong("recharge_money");
                model.mobile = rs.getString("mobile");
                if ((rs.getInt("status") & 16) != 0) {
                    model.isHasSercurityMobile = true;
                }
                user.add(model);
            }
            rs.close();
            stm.close();
        }
        return user;
    }

    @Override
    public void resetUserMission() throws Exception {
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String[] matchMaxVin = GameCommon.getValueStr("MATCH_MAX_VIN").split(",");
            String sqlVin = " UPDATE user_mission_vin SET level = 1,      match_win = 0,      match_max = ?,      received_reward_level = 0,      update_time = ? ";
            PreparedStatement stmVin = conn.prepareStatement(" UPDATE user_mission_vin SET level = 1,      match_win = 0,      match_max = ?,      received_reward_level = 0,      update_time = ? ");
            stmVin.setInt(1, Integer.parseInt(matchMaxVin[0]));
            stmVin.setString(2, DateTimeUtils.getCurrentTime());
            stmVin.executeUpdate();
            String[] matchMaxXu = GameCommon.getValueStr("MATCH_MAX_XU").split(",");
            String sqlXu = " UPDATE user_mission_xu SET level = 1,      match_win = 0,      match_max = ?,      received_reward_level = 0,      update_time = ? ";
            PreparedStatement stmXu = conn.prepareStatement(" UPDATE user_mission_xu SET level = 1,      match_win = 0,      match_max = ?,      received_reward_level = 0,      update_time = ? ");
            stmXu.setInt(1, Integer.parseInt(matchMaxXu[0]));
            stmXu.setString(2, DateTimeUtils.getCurrentTime());
            stmXu.executeUpdate();
        }
    }

    @Override
    public UserMissionCacheModel getListMissionByNickName(String nickName, String moneyType, int maxLevel) throws SQLException {
        Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");
        UserMissionCacheModel response = new UserMissionCacheModel();
        ArrayList<MissionObj> listMissionObjResponse = new ArrayList<MissionObj>();
        boolean completeMission = false;
        boolean completeAllLevel = false;
        try {
            String tableName = "";
            tableName = moneyType.equals("vin") ? "user_mission_vin" : "user_mission_xu";
            String sql = " SELECT user_id,         user_name,         nick_name,         mission_name,         level,         match_win,         match_max,         received_reward_level  FROM " + tableName + " WHERE nick_name = ? ";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setString(1, nickName);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                completeMission = rs.getInt("match_win") >= rs.getInt("match_max");
                completeAllLevel = rs.getInt("level") == maxLevel && rs.getInt("match_win") == rs.getInt("match_max");
                MissionObj missionObj = new MissionObj(rs.getString("mission_name"), rs.getInt("level"), rs.getInt("match_win"), rs.getInt("match_max"), completeMission, completeAllLevel, rs.getInt("received_reward_level"));
                listMissionObjResponse.add(missionObj);
                response.setUserId(rs.getInt("user_id"));
                response.setUserName(rs.getString("user_name"));
                response.setNickName(rs.getString("nick_name"));
            }
            response.setListMission(listMissionObjResponse);
            rs.close();
            stm.close();
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
        return response;
    }

    @Override
    public void insertUserMission(String moneyType, MissionObj mission, UserModel user) throws SQLException {
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String tableName = "";
            tableName = moneyType.equals("vin") ? "user_mission_vin" : "user_mission_xu";
            String sql = " INSERT INTO " + tableName + " (user_id, user_name, nick_name, mission_name, level, match_win, match_max, received_reward_level, create_time, update_time)  VALUES  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setInt(1, user.getId());
            stm.setString(2, user.getUsername());
            stm.setString(3, user.getNickname());
            stm.setString(4, mission.getMisNa());
            stm.setInt(5, mission.getMisLev());
            stm.setInt(6, mission.getMisWin());
            stm.setInt(7, mission.getMisMax());
            stm.setInt(8, mission.getRecReLev());
            stm.setString(9, DateTimeUtils.getCurrentTime());
            stm.setString(10, DateTimeUtils.getCurrentTime());
            stm.executeUpdate();
            stm.close();
        }
    }

    @Override
    public void updateUserMission(String moneyType, String nickName, MissionObj mission) throws SQLException {
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String tableName = "";
            tableName = moneyType.equals("vin") ? "user_mission_vin" : "user_mission_xu";
            String sql = " UPDATE " + tableName + " SET level = ?,      match_win = ?,      match_max = ?,      received_reward_level = ?,      update_time = ?  WHERE nick_name = ?    AND mission_name = ? ";
            PreparedStatement stm = conn.prepareStatement(sql);
            stm.setInt(1, mission.getMisLev());
            stm.setInt(2, mission.getMisWin());
            stm.setInt(3, mission.getMisMax());
            stm.setInt(4, mission.getRecReLev());
            stm.setString(5, DateTimeUtils.getCurrentTime());
            stm.setString(6, nickName);
            stm.setString(7, mission.getMisNa());
            stm.executeUpdate();
            stm.close();
        }
    }

    @Override
    public UserCacheModel getUserByNickNameCache(String nickName) throws SQLException {
        UserCacheModel response = new UserCacheModel();
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT id, vin, vin_total, safe FROM vinplay.users WHERE nick_name = ?";
            PreparedStatement stm = conn.prepareStatement("SELECT id, vin, vin_total, safe FROM vinplay.users WHERE nick_name = ?");
            stm.setString(1, nickName);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                response.setId(rs.getInt("id"));
                response.setVin(rs.getLong("vin"));
                response.setVinTotal(rs.getLong("vin_total"));
                response.setSafe(rs.getLong("safe"));
            }
            rs.close();
            stm.close();
        }
        return response;
    }

    @Override
    public void insertCommission(int userId, String nickName, long fee, String month) throws SQLException {
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = " INSERT INTO vinplay.user_fee  (user_id, nick_name, fee, month, create_time, update_time)  VALUES  (?, ?, ?, ?, ?, ?) ";
            PreparedStatement stm = conn.prepareStatement(" INSERT INTO vinplay.user_fee  (user_id, nick_name, fee, month, create_time, update_time)  VALUES  (?, ?, ?, ?, ?, ?) ");
            stm.setInt(1, userId);
            stm.setString(2, nickName);
            stm.setLong(3, fee);
            stm.setString(4, month);
            stm.setString(5, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            stm.setString(6, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            stm.executeUpdate();
            stm.close();
        }
    }

    @Override
    public long insertBankSms(String content, String sms, long amount, int status) throws SQLException {
        long res = -1;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            PreparedStatement stm = conn.prepareStatement(" INSERT INTO vinplay.bank_sms  (content, sms, amount, status, create_time)  VALUES  (?, ?, ?, ?, ?) ",
                    Statement.RETURN_GENERATED_KEYS);
            stm.setString(1, content);
            stm.setString(2, sms);
            stm.setLong(3, amount);
            stm.setInt(4, status);
            stm.setString(5, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            if (stm.executeUpdate() == 1) {
                try (ResultSet generatedKeys = stm.getGeneratedKeys()) {
                    if (generatedKeys.next()) {
                        res = generatedKeys.getLong(1);
                    }
                } catch (Exception ex) {
                    res = 1;
                }
            }
            stm.close();
        }
        return res;
    }

    @Override
    public List<BankSmsModel> getBankSmsLst(String id, String content, String sms, String timeStart, String timeEnd, int status, int page, int pageSize, String from, String to)
            throws SQLException {
        ArrayList<BankSmsModel> bankSmsLst = new ArrayList<BankSmsModel>();
        int num_start = (page - 1) * pageSize;
        String limit = " LIMIT " + num_start + ", " + pageSize + "";
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String sql = "SELECT * FROM bank_sms where (1=1)";
            String condition = "";
            if (from != null && !from.isEmpty()) {
                condition = condition + " AND id >= " + from;
            }
            if (to != null && !to.isEmpty()) {
                condition = condition + " AND id <= " + to;
            }
            if (id != null && !id.equals("")) {
                condition = condition + " AND id = '" + id + "'";
            }
            if (content != null && !content.equals("")) {
                condition = condition + " AND content like '%" + content + "%'";
            }
            if (sms != null && !sms.equals("")) {
                condition = condition + " AND content like '%" + sms + "%'";
            }
            if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
                condition = condition + " AND create_time BETWEEN '" + timeStart + "' AND '" + timeEnd + "'";
            }
            if (status > 0) {
                condition = condition + " AND status=" + status;
            }
            sql = sql + condition + " order by id desc" + limit;
            PreparedStatement stm = conn.prepareStatement(sql);
            ResultSet rs = stm.executeQuery();
            while (rs.next()) {
                BankSmsModel model = new BankSmsModel();
                model.setId(rs.getInt("id"));
                model.setContent(rs.getString("content"));
                model.setSms(rs.getString("sms"));
                model.setAmount(rs.getLong("amount"));
                model.setCreateTime(rs.getString("create_time"));
                model.setStatus(rs.getInt("status"));
                bankSmsLst.add(model);
            }
            rs.close();
            stm.close();
        }
        return bankSmsLst;
    }

    @Override
    public int countBankSmsLst(String id, String content, String sms, String timeStart, String timeEnd, int status, String from, String to) throws SQLException {
        int cnt = 0;
        String sql = "";
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            String condition = "";
            if (from != null && !from.isEmpty()) {
                condition = condition + " AND id >= " + from;
            }
            if (to != null && !to.isEmpty()) {
                condition = condition + " AND id <= " + to;
            }
            if (id != null && !id.equals("")) {
                condition = condition + " AND id = '" + id + "'";
            }
            if (content != null && !content.equals("")) {
                condition = condition + " AND content like '%" + content + "%'";
            }
            if (sms != null && !sms.equals("")) {
                condition = condition + " AND content like '%" + sms + "%'";
            }
            if (timeStart != null && !timeStart.equals("") && timeEnd != null && !timeEnd.equals("")) {
                condition = condition + " AND create_time BETWEEN '" + timeStart + "' AND '" + timeEnd + "'";
            }
            if (status > 0) {
                condition = condition + " AND status=" + status;
            }
            sql = "select count(*) as cnt from bank_sms where 1=1" + condition;
            PreparedStatement stm = conn.prepareStatement(sql);
            ResultSet rs = stm.executeQuery();
            if (rs.next()) {
                cnt = rs.getInt("cnt");
            }
            rs.close();
            stm.close();
        }
        return cnt;
    }

    @Override
    public boolean updateBankSmsStatus(int status, long id) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            PreparedStatement stm = conn.prepareStatement(" UPDATE vinplay.bank_sms  SET status = ?, update_time = ? WHERE id = ?");
            stm.setInt(1, status);
            stm.setString(2, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            stm.setLong(3, id);
            if (stm.executeUpdate() == 1) {
                res = true;
            }
            stm.close();
        }
        return res;
    }

    @Override
    public boolean updateBankSmsStatus(String content, int status, long id) throws SQLException {
        boolean res = false;
        try (Connection conn = ConnectionPool.getInstance().getConnection("mysqlpoolname");){
            PreparedStatement stm = conn.prepareStatement(" UPDATE vinplay.bank_sms SET content = ?, status = ?, update_time = ?, resent_count = resent_count + 1 WHERE id = ?");
            stm.setString(1, content);
            stm.setInt(2, status);
            stm.setString(3, DateTimeUtils.getCurrentTime((String)"yyyy-MM-dd HH:mm:ss"));
            stm.setLong(4, id);
            if (stm.executeUpdate() == 1) {
                res = true;
            }
            stm.close();
        }
        return res;
    }

}

