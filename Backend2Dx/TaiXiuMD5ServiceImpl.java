/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.hazelcast.core.HazelcastInstance
 *  com.hazelcast.core.IMap
 *  com.vinplay.vbee.common.enums.Games
 *  com.vinplay.vbee.common.hazelcast.HazelcastClientFactory
 *  com.vinplay.vbee.common.messages.BaseMessage
 *  com.vinplay.vbee.common.messages.minigame.LogRutLocMessge
 *  com.vinplay.vbee.common.messages.minigame.LogTanLocMessage
 *  com.vinplay.vbee.common.messages.minigame.ResultTaiXiuMessage
 *  com.vinplay.vbee.common.messages.minigame.ThanhDuMessage
 *  com.vinplay.vbee.common.messages.minigame.TransactionTaiXiuDetailMessage
 *  com.vinplay.vbee.common.messages.minigame.TransactionTaiXiuMessage
 *  com.vinplay.vbee.common.messages.minigame.UpdateLuotRutLocMessage
 *  com.vinplay.vbee.common.messages.minigame.UpdatePotMessage
 *  com.vinplay.vbee.common.models.cache.RutLocCacheModel
 *  com.vinplay.vbee.common.models.cache.ThanhDuTXModel
 *  com.vinplay.vbee.common.models.cache.TopRLTLModel
 *  com.vinplay.vbee.common.models.cache.TopWinCache
 *  com.vinplay.vbee.common.models.minigame.TopWin
 *  com.vinplay.vbee.common.models.minigame.taixiu.XepHangRLTLModel
 *  com.vinplay.vbee.common.rmq.RMQApi
 *  org.apache.log4j.Logger
 */
package com.vinplay.dal.service.impl;

import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;
import com.vinplay.dal.dao.TaiXiuDAO;
import com.vinplay.dal.dao.impl.MiniGameDAOImpl;
import com.vinplay.dal.dao.impl.TaiXiuMD5DAOImpl;
import com.vinplay.dal.entities.report.ReportMoneySystemModel;
import com.vinplay.dal.entities.taixiu.ResultTaiXiu;
import com.vinplay.dal.entities.taixiu.TransactionTaiXiu;
import com.vinplay.dal.entities.taixiu.TransactionTaiXiuDetail;
import com.vinplay.dal.entities.taixiu.VinhDanhRLTLModel;
import com.vinplay.dal.service.TaiXiuService;
import com.vinplay.vbee.common.enums.Games;
import com.vinplay.vbee.common.hazelcast.HazelcastClientFactory;
import com.vinplay.vbee.common.messages.BaseMessage;
import com.vinplay.vbee.common.messages.minigame.*;
import com.vinplay.vbee.common.models.cache.RutLocCacheModel;
import com.vinplay.vbee.common.models.cache.ThanhDuTXModel;
import com.vinplay.vbee.common.models.cache.TopRLTLModel;
import com.vinplay.vbee.common.models.cache.TopWinCache;
import com.vinplay.vbee.common.models.minigame.TopWin;
import com.vinplay.vbee.common.models.minigame.taixiu.XepHangRLTLModel;
import com.vinplay.vbee.common.rmq.RMQApi;
import org.apache.log4j.Logger;

import java.io.IOException;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.concurrent.TimeoutException;

public class TaiXiuMD5ServiceImpl
implements TaiXiuService {
    private Logger logger = Logger.getLogger((String)"rmq");
    private TaiXiuDAO dao = new TaiXiuMD5DAOImpl();

    

    

    

    @Override
    public String getLichSuPhien(int soPhien, int moneyType) throws SQLException {
        List<ResultTaiXiu> results = this.dao.getLichSuPhien(soPhien, moneyType);
        return this.buildLichSuPhien(results, soPhien);
    }

    @Override
    public List<TopWin> getTopWin(int moneyType) throws SQLException {
        TopWinCache topTXCache;
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap topMap = client.getMap("cacheTop");
        if (topMap.containsKey((Object)(Games.TAI_XIU.getName() + "_" + moneyType)) && (topTXCache = (TopWinCache)topMap.get((Object)(Games.TAI_XIU.getName() + "_" + moneyType))) != null) {
            return topTXCache.getResult();
        }
        return new ArrayList<TopWin>();
    }

    @Override
    public void updateAllTop() {
        try {
            List<TopWin> topWinVin = this.dao.getTopTaiXiu(1);
            this.logger.debug((Object)("TOP WIN VIN MD5: " + topWinVin.size()));
            List<TopWin> topWinXu = this.dao.getTopTaiXiu(0);
            this.logger.debug((Object)("TOP WIN XU MD5: " + topWinXu.size()));
            HazelcastInstance client = HazelcastClientFactory.getInstance();
            IMap topMap = client.getMap("cacheTop");
            TopWinCache cacheVin = (TopWinCache)topMap.get((Object)(Games.TAI_XIU.getName() + "_1"));
            if (cacheVin == null) {
                cacheVin = new TopWinCache();
            }
            cacheVin.setResult(topWinVin);
            topMap.put((Object)(Games.TAI_XIU.getName() + "_1"), (Object)cacheVin);
            TopWinCache cacheXu = (TopWinCache)topMap.get((Object)(Games.TAI_XIU.getName() + "_0"));
            if (cacheXu == null) {
                cacheXu = new TopWinCache();
            }
            cacheXu.setResult(topWinXu);
            topMap.put((Object)(Games.TAI_XIU.getName() + "_0"), (Object)cacheXu);
        }
        catch (SQLException e) {
            this.logger.error((Object)"UPDATE ALL TOP  MD5 exception: ", (Throwable)e);
            e.printStackTrace();
        }
    }

    

    

    

    

    

    

    

    @Override
    public ResultTaiXiu getKetQuaPhien(long referenceId, int moneyType) throws SQLException {
        ResultTaiXiu resultTX = this.dao.getKetQuaPhien(referenceId, moneyType);
        return resultTX;
    }

    

    @Override
    public void calculateThanhDu(long referenceId, List<TransactionTaiXiu> transacntions, int result) throws IOException, TimeoutException, InterruptedException {

    }

    @Override
    public List<ThanhDuTXModel> getTopThanhDuDaily(String dateStr, int type) throws SQLException {
        return new ArrayList<>();
    }

    @Override
    public List<ThanhDuTXModel> getTopThanhDuMonthly(String dateStr, int type) throws SQLException, ParseException {
        return new ArrayList<>();
    }

    @Override
    public long getPotTanLoc() throws SQLException {
        MiniGameDAOImpl miniGameDAO = new MiniGameDAOImpl();
        return miniGameDAO.getPot("tan_loc");
    }

    @Override
    public void logTanLoc(String username, long money) throws IOException, TimeoutException, InterruptedException {
        LogTanLocMessage message = new LogTanLocMessage();
        message.username = username;
        message.value = money;
        message.isMD5 = true;
        RMQApi.publishMessage((String)"queue_taixiu", (BaseMessage)message, (int)107);
    }

    @Override
    public void updatePotTanLoc(long newValue) throws IOException, TimeoutException, InterruptedException {
        UpdatePotMessage message = new UpdatePotMessage();
        message.newValue = newValue;
        message.potName = "tan_loc";
        message.isMD5 = true;
        RMQApi.publishMessage((String)"queue_pot", (BaseMessage)message, (int)106);
    }

    @Override
    public void logRutLoc(String username, long prize, int timeRequest, long currentFund) throws IOException, TimeoutException, InterruptedException {
        LogRutLocMessge message = new LogRutLocMessge();
        message.username = username;
        message.prize = prize;
        message.timeRequest = timeRequest;
        message.currentFund = currentFund;
        message.isMD5 = true;
        RMQApi.publishMessage((String)"queue_taixiu", (BaseMessage)message, (int)108);
    }

    /*
     * WARNING - Removed try catching itself - possible behaviour change.
     */
    @Override
    public int updateLuotRutLoc(String username, int soLuotThem) throws IOException, TimeoutException, InterruptedException {
        UpdateLuotRutLocMessage message = new UpdateLuotRutLocMessage();
        message.username = username;
        message.soLuotThem = soLuotThem;
        message.isMD5 = true;
        RMQApi.publishMessage((String)"queue_taixiu", (BaseMessage)message, (int)109);
        int soLuotRut = soLuotThem;
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap userMap = client.getMap("cacheRutLocTX");
        if (userMap.containsKey((Object)username)) {
            try {
                 userMap.lock(username);
                RutLocCacheModel model = (RutLocCacheModel)userMap.get((Object)username);
                soLuotRut = model.addSoLuotRut(soLuotThem);
                 userMap.put(username, model);
            }
            catch (Exception e) {
                this.logger.error((Object)e);
            }
            finally {
                 userMap.unlock(username);
            }
        } else {
            RutLocCacheModel model = new RutLocCacheModel(soLuotThem);
             userMap.put(username, model);
        }
        return soLuotRut;
    }

    @Override
    public int updateDealerProfit(long phienid, int result, long total_money_tai, long total_money_xiu, long total_profit, long last_balance) throws IOException, TimeoutException, InterruptedException {
        UpdateDealerProfitMessage updateDealerProfitMessage = new UpdateDealerProfitMessage();
        updateDealerProfitMessage.last_balance = last_balance;
        updateDealerProfitMessage.phienid = phienid;
        updateDealerProfitMessage.result = result;
        updateDealerProfitMessage.total_money_tai = total_money_tai;
        updateDealerProfitMessage.total_money_xiu = total_money_xiu;
        updateDealerProfitMessage.total_profit = total_profit;
        RMQApi.publishMessage((String)"queue_taixiu", (BaseMessage)updateDealerProfitMessage, (int)110);
        return 0;
    }

    /*
     * WARNING - Removed try catching itself - possible behaviour change.
     */
    @Override
    public int getLuotRutLoc(String username) throws SQLException {
        int soLuot = 0;
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap userMap = client.getMap("cacheRutLocTX");
        if (userMap.containsKey((Object)username)) {
            try {
                 userMap.lock(username);
                RutLocCacheModel model = (RutLocCacheModel)userMap.get((Object)username);
                soLuot = model.getSoLuotRut();
            }
            catch (Exception e) {
                this.logger.error((Object)e);
            }
            finally {
                 userMap.unlock(username);
            }
        } else {
            soLuot = this.dao.getSoLanRutLoc(username);
            RutLocCacheModel model = new RutLocCacheModel(soLuot);
             userMap.put(username, model);
        }
        return soLuot;
    }

    @Override
    public List<XepHangRLTLModel> getXepHangTanLoc() {
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap topMap = client.getMap("cacheTop");
        if (topMap != null) {
            TopRLTLModel topTanLoc = (TopRLTLModel)topMap.get((Object)"TopTanLoc");
            if (topTanLoc == null) {
                topTanLoc = new TopRLTLModel();
            }
            if (topTanLoc.getResults().size() == 0) {
                List<XepHangRLTLModel> results = this.dao.getXepHangTanLoc();
                topTanLoc.setResults(results);
                topMap.put("TopTanLoc", (Object)topTanLoc);
            }
            return topTanLoc.getResults();
        }
        return this.dao.getXepHangTanLoc();
    }

    @Override
    public List<VinhDanhRLTLModel> getVinhDanhTanLoc() {
        return this.dao.getVinhDanhTanLoc();
    }

    @Override
    public long getSoTienTanLoc(String username) {
        return this.dao.getTongTienTanLoc(username);
    }

    @Override
    public List<XepHangRLTLModel> getXepHangRutLoc() {
        HazelcastInstance client = HazelcastClientFactory.getInstance();
        IMap topMap = client.getMap("cacheTop");
        if (topMap != null) {
            TopRLTLModel topRutLoc = (TopRLTLModel)topMap.get((Object)"TopRutLoc");
            if (topRutLoc == null) {
                topRutLoc = new TopRLTLModel();
            }
            if (topRutLoc.getResults().size() == 0) {
                List<XepHangRLTLModel> results = this.dao.getXepHangRutLoc();
                topRutLoc.setResults(results);
                topMap.put("TopRutLoc", (Object)topRutLoc);
            }
            return topRutLoc.getResults();
        }
        return this.dao.getXepHangRutLoc();
    }

    @Override
    public List<VinhDanhRLTLModel> getVinhDanhRutLoc() {
        return this.dao.getVinhDanhRutLoc();
    }

    @Override
    public long getSoTienRutLoc(String username) {
        return this.dao.getTongTienRutLoc(username);
    }

    @Override
    public boolean updatePot(long pot, String potName) {
        return false;
    }

    @Override
    public boolean updateFund(long fund, String potName) {
        return false;
    }

    private String buildLichSuPhien(List<ResultTaiXiu> input, int number) {
        int end = input.size();
        int start = end - number > 0 ? end - number : 0;
        StringBuilder builder = new StringBuilder();
        for (int i = start; i < end; ++i) {
            ResultTaiXiu entry = input.get(i);
            builder.append(entry.dice1);
            builder.append(",");
            builder.append(entry.dice2);
            builder.append(",");
            builder.append(entry.dice3);
            builder.append(",");
        }
        if (builder.length() > 0) {
            builder.deleteCharAt(builder.length() - 1);
        }
        return builder.toString();
    }

    @Override
    public ReportMoneySystemModel getReportTXToday() {
        return this.dao.getReportTXToDay();
    }

    @Override
    public ReportMoneySystemModel getReportTX(int range) {
        ReportMoneySystemModel reportTX;
        ReportMoneySystemModel todayModel = this.getReportTXToday();
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy/MM/dd");
        Calendar cal = Calendar.getInstance();
        String endDate = sdf.format(cal.getTime());
        int date = cal.get(5);
        int month = cal.get(2);
        int dateBefore = date % range - 1;
        cal.add(5, -dateBefore);
        String startDate = sdf.format(cal.getTime());
        int dateAfter = range - dateBefore;
        Calendar calTmp = Calendar.getInstance();
        calTmp.add(5, dateAfter);
        String dateReset = sdf.format(calTmp.getTime());
        int monthTmp = calTmp.get(2);
        if (monthTmp != month) {
            SimpleDateFormat sdf2 = new SimpleDateFormat("yyyy/MM/01");
            dateReset = sdf2.format(calTmp.getTime());
        }
        ReportMoneySystemModel result = reportTX = this.dao.getReportTX(startDate, endDate);
        reportTX.moneyWin += todayModel.moneyWin;
        ReportMoneySystemModel reportMoneySystemModel = result;
        reportMoneySystemModel.moneyLost += todayModel.moneyLost;
        ReportMoneySystemModel reportMoneySystemModel2 = result;
        reportMoneySystemModel2.fee += todayModel.fee;
        ReportMoneySystemModel reportMoneySystemModel3 = result;
        reportMoneySystemModel3.moneyOther += todayModel.moneyOther;
        ReportMoneySystemModel reportMoneySystemModel4 = result;
        reportMoneySystemModel4.revenuePlayGame += todayModel.revenuePlayGame;
        ReportMoneySystemModel reportMoneySystemModel5 = result;
        reportMoneySystemModel5.revenue += todayModel.revenue;
        result.dateReset = dateReset;
        return result;
    }
}

