/*
 * Decompiled with CFR 0.144.
 *
 * Could not load the following classes:
 *  bitzero.server.BitZeroServer
 *  bitzero.server.core.BZEventParam
 *  bitzero.server.core.BZEventType
 *  bitzero.server.core.IBZEvent
 *  bitzero.server.core.IBZEventListener
 *  bitzero.server.core.IBZEventParam
 *  bitzero.server.core.IBZEventType
 *  bitzero.server.entities.User
 *  bitzero.server.entities.managers.IUserManager
 *  bitzero.server.exceptions.BZException
 *  bitzero.server.extensions.BZExtension
 *  bitzero.server.extensions.BaseClientRequestHandler
 *  bitzero.server.extensions.data.BaseMsg
 *  bitzero.server.extensions.data.DataCmd
 *  bitzero.server.util.TaskScheduler
 *  bitzero.util.ExtensionUtility
 *  bitzero.util.common.business.CommonHandle
 *  bitzero.util.common.business.Debug
 *  com.vinplay.dal.entities.taixiu.ResultTaiXiu
 *  com.vinplay.dal.service.MiniGameService
 *  com.vinplay.dal.service.TaiXiuService
 *  com.vinplay.dal.service.impl.MiniGameServiceImpl
 *  com.vinplay.dal.service.impl.TaiXiuServiceImpl
 *  com.vinplay.usercore.service.impl.UserServiceImpl
 *  com.vinplay.vbee.common.response.MoneyResponse
 *  com.vinplay.vbee.common.statics.TransType
 *  com.vinplay.vbee.common.utils.DateTimeUtils
 */
package game.modules.minigame;


import bitzero.server.BitZeroServer;
import bitzero.server.core.*;
import bitzero.server.entities.User;
import bitzero.server.exceptions.BZException;
import bitzero.server.extensions.BaseClientRequestHandler;
import bitzero.server.extensions.data.BaseMsg;
import bitzero.server.extensions.data.DataCmd;
import bitzero.server.util.TaskScheduler;
import bitzero.util.ExtensionUtility;
import bitzero.util.common.business.CommonHandle;
import bitzero.util.common.business.Debug;
import com.vinplay.dal.entities.taixiu.ResultTaiXiu;
import com.vinplay.dal.service.MiniGameService;
import com.vinplay.dal.service.TaiXiuService;
import com.vinplay.dal.service.impl.MiniGameServiceImpl;
import com.vinplay.dal.service.impl.TaiXiuMD5ServiceImpl;
import com.vinplay.dal.service.impl.TaiXiuServiceImpl;
import com.vinplay.usercore.dao.impl.GameConfigDaoImpl;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.vbee.common.response.MoneyResponse;
import com.vinplay.vbee.common.statics.TransType;
import com.vinplay.vbee.common.utils.DateTimeUtils;
import game.modules.chat.ChatMD5Module;
import game.modules.minigame.cmd.*;
import game.modules.minigame.cmd.rev.*;
import game.modules.minigame.cmd.send.txmini_md5.*;
import game.modules.minigame.entities.BotMinigame;
import game.modules.minigame.entities.BotTaiXiu;
import game.modules.minigame.room.MGRoom;
import game.modules.minigame.room.MGRoomTaiXiuMD5;
import game.modules.minigame.utils.GenerationTaiXiu;
import game.modules.minigame.utils.MiniGameUtils;
import game.modules.minigame.utils.RutLocUtils;
import game.modules.minigame.utils.TaiXiuUtils;
import game.utils.GameUtils;
import org.apache.commons.lang.RandomStringUtils;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileOutputStream;
import java.io.IOException;
import java.io.PrintStream;
import java.sql.SQLException;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.concurrent.*;

public class TaiXiuMD5Module
        extends BaseClientRequestHandler {
    private Map<String, MGRoom> rooms = new HashMap<String, MGRoom>();
    private final Runnable gameLoopTask = new GameLoopTask();
    private final Runnable serverReadyTask = new ServerReadyTask();
    private final Runnable calculatingTXVinTask = new CalculatingTaiXiuPrize((short)1);
    // private final Runnable calculatingTXXuTask = new CalculatingTaiXiuPrize((short)0);
    // private final Runnable rewardThanhDuDailyTask = new RewardThanhDuDaily();
    private int count = 0;
    private boolean serverReady = false;
    private ThreadPoolExecutor executor = (ThreadPoolExecutor)Executors.newFixedThreadPool(10);
    private long referenceTaiXiuId;
    private TaiXiuMD5ServiceImpl txService = new TaiXiuMD5ServiceImpl();
    private MiniGameService mgService = new MiniGameServiceImpl();
    private List<ResultTaiXiu> lichSuPhienTX = new ArrayList<ResultTaiXiu>();
    private GenerationTaiXiu generationTX = new GenerationTaiXiu();
    private short result = (short)-1;
    private long fundRutLoc = 0L;
    private int countRutLoc = 0;
    private int countReqRutLoc = 0;
    private int[] rutLocPrizes;
    private int[] phanBoGiaiThuong;
    private boolean enableRutLoc = false;
    private int tongSoNguoiRutLocLanTruoc = 30;
    private List<BotTaiXiu> botsVin = new ArrayList<BotTaiXiu>();
    private short forceBetSide = (short)-1;
    //
    private String session_md5_string = "";
    private String session_before_md5_string = "";
    private short[] currDices = new short[]{1,2,3};
    public final Logger logger = LoggerFactory.getLogger(TaskScheduler.class);
    //
    private long MinCtrl = 100L;
    {
        try {
            GameConfigDaoImpl dao = new GameConfigDaoImpl();
            String commons = dao.getGameCommon("taixiu");
            try {
                JSONObject commonObj = new JSONObject(commons);
                MinCtrl = commonObj.getLong("min_ctrl");
            } catch (JSONException e) {
                e.printStackTrace();
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }


    private ChatMD5Module chatModule = new ChatMD5Module();

    public void init() {
        this.rooms.put(MGRoomTaiXiuMD5.getKeyRoom((short)1), new MGRoomTaiXiuMD5("TaiXiuMD5_1", this.referenceTaiXiuId, (byte)1));
        this.loadData();
        BitZeroServer.getInstance().getTaskScheduler().scheduleAtFixedRate(this.gameLoopTask, 10, 1, TimeUnit.SECONDS);
        BitZeroServer.getInstance().getTaskScheduler().schedule(this.serverReadyTask, 10, TimeUnit.SECONDS);
        this.getParentExtension().addEventListener((IBZEventType)BZEventType.USER_DISCONNECT, (IBZEventListener)this);
    }

    public void handleServerEvent(IBZEvent ibzevent) throws BZException {
        if (ibzevent.getType() == BZEventType.USER_DISCONNECT) {
            User user = (User)ibzevent.getParameter((IBZEventParam)BZEventParam.USER);
            this.userDis(user);
        }
    }

    private void userDis(User user) {
        MGRoom room = (MGRoom)user.getProperty((Object)"MGROOM_TAI_XIU_INFO");
        if (room != null) {
            room.quitRoom(user);
        }
    }

    private void loadData() {
        this.referenceTaiXiuId = 1L;
        this.session_md5_string = "";
        this.session_before_md5_string="";
        currDices = new short[]{1,2,3};
        try {
            this.referenceTaiXiuId = this.mgService.getReferenceId(4);
            logger.debug("referenceTaiXiuId md5: " + this.referenceTaiXiuId);
            //this.lichSuPhienTX = this.txService.getListLichSuPhien(120, 1);
        }
        catch (SQLException e) {
            Debug.trace((Object[])new Object[]{"Load reference error ", e.getMessage()});
            logger.error("error:", e);
        }
        try {
            this.generationTX.readConfig();
        }
        catch (IOException e) {
            Debug.trace((Object[])new Object[]{"Load cau tai xiu MD5 error ", e.getMessage()});
        }
        try {
            this.fundRutLoc = this.txService.getPotTanLoc();
            if (this.fundRutLoc < 100000L) {
                this.countRutLoc = -1;
            }
        }
        catch (SQLException e) {
            Debug.trace((Object[])new Object[]{"Load fund tan loc MD5  error ", e.getMessage()});
        }
        Debug.trace((Object)("Phien TX MD5: " + this.referenceTaiXiuId));
        Debug.trace((Object)("SIZE LSDG MD5: " + this.lichSuPhienTX.size()));
        Debug.trace((Object)("LSDG MD5: " + TaiXiuUtils.logLichSuPhien(this.lichSuPhienTX, 120)));
        Debug.trace((Object)("Fund tan loc MD5: " + this.fundRutLoc));
    }

    private void saveReferences() {
        try {
            this.mgService.saveReferenceId(this.referenceTaiXiuId, 4);
        }
        catch (SQLException e) {
            Debug.trace((Object)("Save reference error " + e.getMessage()));
        }
    }

    public void handleClientRequest(User user, DataCmd dataCmd) {
        switch (dataCmd.getId()) {
            case MiniGameCMD.SUBCRIBE_TXMINI_MD5_GAME: {
                this.subcribeMiniGame(user, dataCmd);
                break;
            }
            case MiniGameCMD.UNSUBCRIBE_TXMINI_MD5_GAME: {
                this.unsubscribeMiniGame(user, dataCmd);
                break;
            }
            case MiniGameCMD.BET_TXMINI_MD5: {
                if (GameUtils.disablePlayMiniGame(user)) {
                    return;
                }
                this.betTaiXiu(user, dataCmd);
                break;
            }
            case MiniGameCMD.LICH_SU_PHIEN_TXMINI_MD5: {
                this.getLichSuPhienTX(user);
                break;
            }
            case MiniGameCMD.TXMINI_MD5_TAN_LOC: {
                if (GameUtils.disablePlayMiniGame(user)) {
                    return;
                }
                this.tanLoc(user, dataCmd);
                break;
            }
            case MiniGameCMD.TXMINI_MD5_RUT_LOC: {
                if (GameUtils.disablePlayMiniGame(user)) {
                    return;
                }
                this.rutLoc(user, dataCmd);
            }
        }
    }

    private void subcribeMiniGame(User user, DataCmd dataCmd) {
        SubcribeMinigameCmd cmd = new SubcribeMinigameCmd(dataCmd);
        this.doSubcribeMiniGame(user, cmd.gameId, cmd.roomId);
        LichSuPhienMsg msgLSGD = new LichSuPhienMsg();
        msgLSGD.data = TaiXiuUtils.buildLichSuPhien(this.lichSuPhienTX, 22);
        this.send((BaseMsg)msgLSGD, user);
        UpdateRutLocMsg rutLocMsg = new UpdateRutLocMsg();
        try {
            rutLocMsg.soLuotRut = this.txService.getLuotRutLoc(user.getName());
        }
        catch (Exception e) {
            Debug.trace((Object[])new Object[]{"Get so luot rut loc MD5 " + user.getName() + " error ", e.getMessage()});
        }
        this.send((BaseMsg)rutLocMsg, user);
        UpdateFundTanLocMsg fundRLMsg = new UpdateFundTanLocMsg();
        fundRLMsg.value = this.fundRutLoc;
        this.send((BaseMsg)fundRLMsg, user);
    }

    private void doSubcribeMiniGame(User user, short gameId, short roomId) {
        logger.debug("doSubcribeMiniGame gameId:" + gameId + " roomId:" + roomId);
        switch (gameId) {
            case 22000: {
                short moneyType = MGRoomTaiXiuMD5.getMoneyType(roomId);
                String keyRoom = MGRoomTaiXiuMD5.getKeyRoom(moneyType);
                MGRoomTaiXiuMD5 roomTX = (MGRoomTaiXiuMD5)this.getGame(keyRoom);
                if (roomTX != null) {
                    roomTX.joinRoom(user);
                    roomTX.updateTaiXiuInfo(user, this.getRemainTimeRutLoc(), session_md5_string, session_before_md5_string);
                    break;
                }
                CommonHandle.writeErrLog((String)"Game TAI XIU MD5 not found");
                break;
            }
            default: {
                Debug.trace((Object)"Game id not found");
            }
        }
    }

    private void unsubscribeMiniGame(User user, DataCmd dataCmd) {
        UnsubscribeMiniGameCmd cmd = new UnsubscribeMiniGameCmd(dataCmd);
        this.doUnsubscribeMiniGame(user, cmd.gameId, cmd.roomId);
    }

    private void doUnsubscribeMiniGame(User user, short gameId, short roomId) {
        switch (gameId) {
            case 22000: {
                short moneyType = MGRoomTaiXiuMD5.getMoneyType(roomId);
                String keyRoom = MGRoomTaiXiuMD5.getKeyRoom(moneyType);
                MGRoom room = this.getGame(keyRoom);
                if (room == null) break;
                room.quitRoom(user);
            }
        }
    }

    private void changeRoom(User user, DataCmd dataCmd) {
        ChangeRoomMinigameCmd cmd = new ChangeRoomMinigameCmd(dataCmd);
        this.doUnsubscribeMiniGame(user, cmd.gameId, cmd.lastRoomId);
        this.doSubcribeMiniGame(user, cmd.gameId, cmd.newRoomId);
    }

    public String genRandomCode() {
        int length = 10;
        boolean useLetters = true;
        boolean useNumbers = true;
        String generatedString = RandomStringUtils.random(length, useLetters, useNumbers);

        return generatedString;
    }

    public String MD5(String md5) {
        try {
            java.security.MessageDigest md = java.security.MessageDigest.getInstance("MD5");
            byte[] array = md.digest(md5.getBytes());
            StringBuffer sb = new StringBuffer();
            for (int i = 0; i < array.length; ++i) {
                sb.append(Integer.toHexString((array[i] & 0xFF) | 0x100).substring(1,3));
            }
            return sb.toString();
        } catch (java.security.NoSuchAlgorithmException e) {
        }
        return null;
    }

    private void startNewRoundTX() {
        MGRoomTaiXiuMD5 roomTXVin = this.getRoomTX((short)1);
        ++this.referenceTaiXiuId;
        //
        generateTaiXiuDices();
        String md5 = genRandomCode()+"#"+this.referenceTaiXiuId+":["+currDices[0]+","+currDices[1]+","+currDices[2]+"]";
        this.session_before_md5_string = md5;
        md5 = MD5(md5);
        this.session_md5_string= md5;
        //
        roomTXVin.startNewGame(this.referenceTaiXiuId);
        StartNewGameTaiXiuMsg msg = new StartNewGameTaiXiuMsg();
        msg.referenceId = this.referenceTaiXiuId;
        msg.remainTimeRutLoc = this.getRemainTimeRutLoc();
        //
        msg.md5 = md5;
        this.sendMessageToTaiXiuNewThread(msg);
        this.saveReferences();
    }

    private void scheduleBot() {
        try {
            this.botsVin.clear();
            this.botsVin = BotMinigame.getBotTaiXiu("vin");
            logger.debug("BOTS VIN MD5: " + this.botsVin.size());
            LoggerFactory.getLogger("TaiXiuMD5Module").debug("BOTS VIN MD5: " + this.botsVin.size());
            List<BotTaiXiu> botsVip = BotMinigame.getVipBotTaiXiu();
            this.botsVin.addAll(botsVip);
            Debug.trace((Object)("TX BOTS VIP MD5: " + botsVip.size()));
            logger.debug("TX BOTS VIP MD5: " + botsVip.size());
        }
        catch (Exception e) {
            GameUtils.sendAlert("Bot tai xiu MD5 start error: " + e.getMessage() + ", time= " + DateTimeUtils.getCurrentTime());
            LoggerFactory.getLogger("TaiXiuMD5Module").error("error:", e);
        }
    }

    private void botBet(int count) {
        MGRoomTaiXiuMD5 roomVin = this.getRoomTX((short)1);
        for (BotTaiXiu b : this.botsVin) {
            if (b.getTimeBetting() != 60 - count) continue;
//            logger.debug("bot bet tai xiu " + b.getNickname() + " " + b.getBetValue() + " side:" + b.getBetSide());
            roomVin.betTaiXiu(b.getNickname(), 0, b.getBetValue(), b.getTimeBetting(), (short)1, b.getBetSide(), true);
        }
    }

    public void betTaiXiu(User user, DataCmd dataCmd) {
        BetTaiXiuCmd cmd = new BetTaiXiuCmd(dataCmd);
        MGRoomTaiXiuMD5 roomTX = this.getRoomTX(cmd.moneyType);
        if (roomTX != null) {
            roomTX.betTaiXiu(user, cmd);
        }
    }

    private synchronized void gameLoop() {
        try {
            ++this.count;
            this.botBet(this.count);
            if (this.countRutLoc > -1) {
                ++this.countRutLoc;
            }
            MGRoomTaiXiuMD5 roomTXVin = this.getRoomTX((short)1);
            roomTXVin.updateTaiXiuPerSecond();
            this.sendTXTime(roomTXVin.getRemainTime(), roomTXVin.isBetting());
            switch (this.count) {
                case 45: {
                    roomTXVin.disableBetting();
                    break;
                }
                case 50: {
                    roomTXVin.finish();
                    break;
                }
                case 48: {
                    this.forceBalanceLateGame(roomTXVin);
                    break;
                }
                case 51: {
                    this.endGame(roomTXVin);
                    break;
                }
                case 55: {
                    BitZeroServer.getInstance().getTaskScheduler().schedule(this.calculatingTXVinTask, 1, TimeUnit.SECONDS);
                    break;
                }
                case 60: {
                    ScheduleBotTask t = new ScheduleBotTask();
                    this.executor.execute(t);
                    break;
                }
                case 65: {
                    roomTXVin.getBalanceTX().startNewRound();
                    this.startNewRoundTX();
                    this.count = 0;
                }
            }
            switch (this.countRutLoc) {
                case 869: {
                    Debug.trace((Object)"RUT LOC MD5");
                    this.rutLocPrizes = RutLocUtils.getPrizes(this.fundRutLoc, 10);
                    this.phanBoGiaiThuong = RutLocUtils.phanBoGiaiThuong(this.tongSoNguoiRutLocLanTruoc, 10);
                    StringBuilder builder = new StringBuilder();
                    for (int i = 0; i < this.phanBoGiaiThuong.length; ++i) {
                        builder.append(this.phanBoGiaiThuong[i]);
                        builder.append(",");
                    }
                    Debug.trace((Object)("PHAN BO GIAI THUONG MD5: " + builder.toString()));
                    this.enableRutLoc = true;
                    this.sendMessageToTaiXiuNewThread(new EnableRutLocMsg());
                    break;
                }
                case 900: {
                    Debug.trace((Object)"PHIEN RUT LOC MOI MD5");
                    this.countRutLoc = 0;
                    if (this.fundRutLoc < 100000L) {
                        this.countRutLoc = -1;
                    }
                    this.tongSoNguoiRutLocLanTruoc = this.countReqRutLoc < 30 ? 30 : this.countReqRutLoc;
                    Debug.trace((Object)("Tong so nguoi rut loc MD5: " + this.tongSoNguoiRutLocLanTruoc));
                    this.countReqRutLoc = 0;
                    this.enableRutLoc = false;
                    StartNewRoundRutLocMsg newRoundMsg = new StartNewRoundRutLocMsg();
                    newRoundMsg.remainTime = this.getRemainTimeRutLoc();
                    this.sendMessageToTaiXiuNewThread(newRoundMsg);
                }
            }
        }
        catch (Exception e) {
            Debug.trace((Object[])new Object[]{"Exception MD5: " + e.getMessage(), e});
        }
    }

    private void forceBalanceLateGame(MGRoomTaiXiuMD5 roomTXVin) {
//        int randomNum;
//        long minCtrl = 100000L;
//        try {
//            GameConfigDaoImpl dao = new GameConfigDaoImpl();
//            String commons = dao.getGameCommon("taixiu");
//            try {
//                JSONObject commonObj = new JSONObject(commons);
//                minCtrl = commonObj.getLong("min_ctrl");
//            } catch (JSONException e) {
//                e.printStackTrace();
//            }
//        } catch (SQLException e) {
//            e.printStackTrace();
//        }
//        this.forceBetSide = roomTXVin.nguoichoidatTai > roomTXVin.nguoichoidatXiu && roomTXVin.nguoichoidatTai - roomTXVin.nguoichoidatXiu > minCtrl ? (short)0
//                : (roomTXVin.nguoichoidatTai < roomTXVin.nguoichoidatXiu && roomTXVin.nguoichoidatXiu - roomTXVin.nguoichoidatTai > minCtrl ?
//                (short)1 : ((randomNum = ThreadLocalRandom.current().nextInt(0, 1000560000)) % 2 == 0 ? (short)0 : 1));
//        try {
//            try (PrintStream out = new PrintStream(new FileOutputStream("logs/minigame/logTaiXiu.log", true));){
//                out.println(roomTXVin.referenceId + "> Tai:" + roomTXVin.nguoichoidatTai + "(" + roomTXVin.getUserBetTai() + ") Xiu:" + roomTXVin.nguoichoidatXiu + "(" + roomTXVin.getUserBetXiu() + ") >" + this.forceBetSide);
//                out.close();
//            }
//        }
//        catch (Exception out) {
//            // empty catch block
//        }
    }

    private void resetForceBalance() {
        this.forceBetSide = (short)-1;
    }

    private void endGame(MGRoomTaiXiuMD5 roomTXVin) {
        roomTXVin.updateResultDices(currDices, this.result, this.session_before_md5_string, this.session_md5_string);
        ResultTaiXiu resultTX = new ResultTaiXiu();
        resultTX.referenceId = this.referenceTaiXiuId;
        resultTX.result = this.result;
        resultTX.dice1 = currDices[0];
        resultTX.dice2 = currDices[1];
        resultTX.dice3 = currDices[2];
        //
        resultTX.before_md5 = session_before_md5_string;
        resultTX.md5 = session_md5_string;
        //
        Debug.trace((Object)("RESULT DICES MD5: " + currDices[0] + " - " + currDices[1] + " - " + currDices[2] + "   " + this.result));
        this.lichSuPhienTX.add(resultTX);
        if (this.lichSuPhienTX.size() > 120) {
            this.lichSuPhienTX.remove(0);
        }
    }

    private void generateTaiXiuDices() {
        currDices = this.generationTX.generateResult((short)-1);
//        Debug.trace((Object)("generateTaiXiuDice MD5s============== next " + this.forceBetSide));
        Debug.trace((Object)("GENERATE RESULT DICES MD5: " + currDices[0] + " - " + currDices[1] + " - " + currDices[2] + "   " + this.result));
        this.resetForceBalance();
        short total = (short)(currDices[0] + currDices[1] + currDices[2]);
        this.result = total > 10 ? (short)1 : 0;
    }

    private void getLichSuPhienTX(User user) {
        LichSuPhienMsg msg = new LichSuPhienMsg();
        msg.data = TaiXiuUtils.buildLichSuPhien(this.lichSuPhienTX, 22);
        Debug.trace((Object)("LSDG MD5: " + TaiXiuUtils.logLichSuPhien(this.lichSuPhienTX, 120)));
        this.send((BaseMsg)msg, user);
    }

    private void tanLoc(User user, DataCmd dataCmd) {
        TanLocCMD cmd = new TanLocCMD(dataCmd);
        TanLocMsg msg = new TanLocMsg();
        msg.result = 1;
        UserServiceImpl userService = new UserServiceImpl();
        long curretnMoney = userService.getMoneyUserCache(user.getName(), "vin");
        logger.debug("tanloc bet: " + cmd.money + " currentmoney: " + curretnMoney);
        if (cmd.money <= curretnMoney) {
            if (cmd.money >= 1000L) {
                boolean success;
                MoneyResponse response = userService.updateMoney(user.getName(), -cmd.money, "vin", "TaiXiuMD5", "T\u00c3\u00a0i x\u00e1\u00bb\u2030u MD5 - T\u00c3\u00a1n l\u00e1\u00bb\u2122c", "T\u00c3\u00a1n l\u00e1\u00bb\u2122c t\u00c3\u00a0i x\u00e1\u00bb\u2030u", 0L, null, TransType.NO_VIPPOINT);
                if (response != null && response.isSuccess() && (success = this.updateFundRutLoc(cmd.money))) {
                    curretnMoney = response.getCurrentMoney();
                    msg.result = 0;
                    try {
                        this.txService.logTanLoc(user.getName(), cmd.money);
                    }
                    catch (IOException | InterruptedException | TimeoutException exception) {
                        // empty catch block
                    }
                    if (this.countRutLoc == -1 && this.fundRutLoc >= 100000L) {
                        this.countRutLoc = 0;
                        StartNewRoundRutLocMsg newRoundMsg = new StartNewRoundRutLocMsg();
                        newRoundMsg.remainTime = this.getRemainTimeRutLoc();
                        this.sendMessageToTaiXiu(newRoundMsg);
                    }
                }
            } else {
                msg.result = (short)3;
            }
        } else {
            msg.result = (short)2;
        }
        msg.currentMoney = curretnMoney;
        this.send((BaseMsg)msg, user);
    }

    private synchronized void rutLoc(User user, DataCmd dataCmd) {
        ResultRutLocMsg msg = new ResultRutLocMsg();
        UserServiceImpl userService = new UserServiceImpl();
        long currentMoney = userService.getMoneyUserCache(user.getName(), "vin");
        if (this.countRutLoc > -1) {
            if (this.enableRutLoc) {
                int soLuotRut = 0;
                try {
                    soLuotRut = this.txService.getLuotRutLoc(user.getName());
                }
                catch (SQLException e) {
                    Debug.trace((Object[])new Object[]{"Get so luot rut loc MD5 error ", e.getMessage()});
                }
                if (soLuotRut > 0) {
                    MoneyResponse response;
                    int indexPirze = -1;
                    int prize = 0;
                    for (int i = 0; i < this.phanBoGiaiThuong.length; ++i) {
                        if (this.countReqRutLoc != this.phanBoGiaiThuong[i]) continue;
                        indexPirze = i;
                        break;
                    }
                    if (0 <= indexPirze && indexPirze < this.rutLocPrizes.length) {
                        prize = this.rutLocPrizes[indexPirze];
                    }
                    if ((long)prize > this.fundRutLoc) {
                        prize = 0;
                    }
                    if (prize > 0 && (response = userService.updateMoney(user.getName(), (long)prize, "vin", "TaiXiu", "T\u00c3\u00a0i x\u00e1\u00bb\u2030u - R\u00c3\u00bat l\u00e1\u00bb\u2122c", "C\u00e1\u00bb\u2122ng ti\u00e1\u00bb\ufffdn r\u00c3\u00bat l\u00e1\u00bb\u2122c", 0L, null, TransType.NO_VIPPOINT)) != null && response.isSuccess()) {
                        currentMoney = response.getCurrentMoney();
                    }
                    ++this.countReqRutLoc;
                    --soLuotRut;
                    msg.prize = prize;
                    try {
                        this.txService.updateLuotRutLoc(user.getName(), -1);
                        UpdateRutLocMsg soLuotRutMsg = new UpdateRutLocMsg();
                        soLuotRutMsg.soLuotRut = soLuotRut;
                        this.send((BaseMsg)soLuotRutMsg, user);
                    }
                    catch (IOException | InterruptedException | TimeoutException e) {
                        Debug.trace((Object[])new Object[]{"Update luot rut loc MD5 error ", e.getMessage()});
                    }
                } else {
                    msg.prize = -2;
                }
            } else {
                msg.prize = -1;
            }
        } else {
            msg.prize = -3;
        }
        msg.currentMoney = currentMoney;
        this.send((BaseMsg)msg, user);
        if (msg.prize > 0) {
            this.updateFundRutLoc(-msg.prize);
            try {
                this.txService.logRutLoc(user.getName(), (long)msg.prize, this.countReqRutLoc, this.fundRutLoc);
            }
            catch (IOException | InterruptedException | TimeoutException e) {
                Debug.trace((Object[])new Object[]{"Log rut loc MD5 error ", e.getMessage()});
            }
        }
    }

    private boolean updateFundRutLoc(long moneyExchagne) {
        boolean success = false;
        this.fundRutLoc += moneyExchagne;
        if (this.fundRutLoc < 0L) {
            Debug.trace((Object)("Quy rut loc MD5 " + this.fundRutLoc + " < 0"));
        }
        try {
            this.txService.updatePotTanLoc(this.fundRutLoc);
            UpdateFundTanLocMsg msg = new UpdateFundTanLocMsg();
            msg.value = this.fundRutLoc;
            this.sendMessageToTaiXiu(msg);
            success = true;
        }
        catch (Exception e) {
            Debug.trace((Object[])new Object[]{"Update fund tan loc MD5 error ", e.getMessage()});
        }
        return success;
    }

    private short getRemainTimeRutLoc() {
        if (this.countRutLoc == -1) {
            return 0;
        }
        int remainTime = 900 - this.countRutLoc;
        if (remainTime < 0) {
            remainTime = 0;
        }
        return (short)remainTime;
    }

    private void sendMessageToTaiXiuNewThread(BaseMsg msg) {
        SendMessageToTXThread t = new SendMessageToTXThread(false, msg);
        this.executor.execute(t);
    }

    private void sendTXTime(short remainTime, boolean betting) {
        if(true)
            return;
        BroadcastTXTimeMsg msg = new BroadcastTXTimeMsg();
        msg.remainTime = (byte)remainTime;
        msg.betting = betting;
        SendMessageToTXThread t = new SendMessageToTXThread(true, msg);
        this.executor.execute(t);
    }

    private void sendMessageToAllUsers(BaseMsg msg) {
        List users = ExtensionUtility.globalUserManager.getAllUsers();
        if (users != null) {
            this.send(msg, users);
        }
    }

    private void sendMessageToTaiXiu(BaseMsg msg) {
        MGRoomTaiXiuMD5 roomTXVin = this.getRoomTX((short)1);
        roomTXVin.sendMessageToRoom(msg);
    }

    public MGRoom getGame(String key) {
        return this.rooms.get(key);
    }

    private MGRoomTaiXiuMD5 getRoomTX(short moneyType) {
        String keyRoom = MGRoomTaiXiuMD5.getKeyRoom(moneyType);
        return (MGRoomTaiXiuMD5)this.getGame(keyRoom);
    }

    private final class GameLoopTask
            implements Runnable {
        private GameLoopTask() {
        }

        @Override
        public void run() {
            try {
                TaiXiuMD5Module.this.gameLoop();
            }
            catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    private final class ServerReadyTask
            implements Runnable {
        private ServerReadyTask() {
        }

        @Override
        public void run() {
            if (!TaiXiuMD5Module.this.serverReady) {
                Debug.trace((Object)"START TXMINI_MD5 GAME");
                TaiXiuMD5Module.this.serverReady = true;
                ScheduleBotTask t = new ScheduleBotTask();
                TaiXiuMD5Module.this.executor.execute(t);
                TaiXiuMD5Module.this.startNewRoundTX();
            }
        }
    }

    private final class CalculatingTaiXiuPrize
            implements Runnable {
        private short roomId;

        public CalculatingTaiXiuPrize(short roomId) {
            this.roomId = roomId;
        }

        @Override
        public void run() {
            long startTime = System.currentTimeMillis();
            try {
                MGRoomTaiXiuMD5 room = TaiXiuMD5Module.this.getRoomTX(this.roomId);
                room.calculatePrize(TaiXiuMD5Module.this.referenceTaiXiuId);
            }
            catch (Exception e) {
                Debug.trace((Object)("Calculate TX MD5 " + this.roomId + ", phien= " + TaiXiuMD5Module.this.referenceTaiXiuId + " error: " + e.getMessage()));
            }
            long endTime = System.currentTimeMillis();
            Debug.trace((Object)("CALCUALTE PRIZE MD5, time handle= " + (endTime - startTime) + " (ms)"));
            TaiXiuMD5Module.this.txService.updateAllTop();
        }
    }

    // private final class RewardThanhDuDaily
    // implements Runnable {
    //     private RewardThanhDuDaily() {
    //     }

    //     @Override
    //     public void run() {
    //         TaiXiuUtils.rewardThanhDu();
    //         BitZeroServer.getInstance().getTaskScheduler().schedule(TaiXiuModule.this.rewardThanhDuDailyTask, 24, TimeUnit.HOURS);
    //         Debug.trace((Object)"Tra thuong Thanh Du");
    //     }
    // }

    private final class SendMessageToTXThread
            extends Thread {
        private BaseMsg msg;
        private boolean all;

        private SendMessageToTXThread(boolean all, BaseMsg msg) {
            this.msg = msg;
            this.all = all;
        }

        @Override
        public void run() {
            if (this.all) {
                TaiXiuMD5Module.this.sendMessageToAllUsers(this.msg);
            } else {
                TaiXiuMD5Module.this.sendMessageToTaiXiu(this.msg);
            }
        }
    }

    private final class ScheduleBotTask
            extends Thread {
        private ScheduleBotTask() {
        }

        @Override
        public void run() {
            TaiXiuMD5Module.this.scheduleBot();
        }
    }

}
