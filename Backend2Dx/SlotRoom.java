package game.modules.slot.room;

import bitzero.server.entities.User;
import bitzero.server.extensions.data.BaseMsg;
import bitzero.util.ExtensionUtility;
import bitzero.util.common.business.Debug;
import com.vinplay.dal.service.BroadcastMessageService;
import com.vinplay.dal.service.CacheService;
import com.vinplay.dal.service.MiniGameService;
import com.vinplay.dal.service.SlotMachineService;
import com.vinplay.dal.service.impl.BroadcastMessageServiceImpl;
import com.vinplay.dal.service.impl.CacheServiceImpl;
import com.vinplay.dal.service.impl.MiniGameServiceImpl;
import com.vinplay.dal.service.impl.SlotMachineServiceImpl;
import com.vinplay.usercore.service.UserService;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import com.vinplay.vbee.common.exceptions.KeyNotFoundException;
import game.modules.slot.SlotModule;
import game.modules.slot.entities.slot.AutoUser;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.concurrent.TimeoutException;

public abstract class SlotRoom {
     protected SlotModule module;
     public static final String MGROOM_KHO_BAU_INFO = "MGROOM_KHO_BAU_INFO";
     public static final String MGROOM_NU_DIEP_VIEN_INFO = "MGROOM_NU_DIEP_VIEN_INFO";
     protected byte id;
     protected String gameName;
     protected String cacheFreeName;
     protected String name;
     protected List users = new ArrayList();
     protected long pot;
     protected long fund;
     protected long initPotValue;
     protected int betValue;
     protected short moneyType;
     protected String moneyTypeStr;
     protected int countHu = -1;
     protected int countNoHuX2 = 0;
     protected boolean huX2 = false;
     protected UserService userService = new UserServiceImpl();
     protected SlotMachineService slotService = new SlotMachineServiceImpl();
     protected BroadcastMessageService broadcastMsgService = new BroadcastMessageServiceImpl();
     protected MiniGameService mgService = new MiniGameServiceImpl();
     protected CacheService sv = new CacheServiceImpl();
     protected Map usersAuto = new HashMap();

     public SlotRoom(byte id, String name, int betValue, short moneyType, long pot, long fund, long initPotValue) {
          this.id = id;
          this.name = name;
          this.betValue = betValue;
          this.moneyType = moneyType;
          this.pot = pot;
          this.fund = fund;
          this.initPotValue = initPotValue;
          if (this.moneyType == 1) {
               this.moneyTypeStr = "vin";
          } else {
               this.moneyTypeStr = "xu";
          }

          try {
               this.countHu = this.sv.getValueInt(name + "_count_hu");
               this.countNoHuX2 = this.sv.getValueInt(name + "_count_no_hu_x2");
               this.calculatHuX2();
          } catch (KeyNotFoundException var15) {
          }

          try {
               this.mgService.savePot(name, pot, this.huX2);
          } catch (InterruptedException var12) {
          } catch (TimeoutException var13) {
          } catch (IOException var14) {
          }

     }

     public boolean joinRoom(User user) {
          synchronized(this.users) {
               if (!this.users.contains(user)) {
                    this.users.add(user);
                    return true;
               } else {
                    return false;
               }
          }
     }

     public boolean quitRoom(User user) {
          synchronized(this.users) {
               if (this.users.contains(user)) {
                    this.users.remove(user);
                    return true;
               } else {
                    return false;
               }
          }
     }

     public void sendMessageToRoom(BaseMsg msg) {
          List usersCopy = new ArrayList(this.users);
          Iterator var3 = usersCopy.iterator();

          while(var3.hasNext()) {
               User user = (User)var3.next();
               ExtensionUtility.getExtension().send(msg, user);
          }

     }

     public void startHuX2() {
          Debug.trace(this.gameName + " start hu X2");
          this.countHu = 1;
          this.sv.setValue(this.name + "_count_hu", this.countHu);
          if (this.moneyType == 1 && this.betValue == 100) {
               this.huX2 = true;
          }

     }

     public void stopHuX2() {
          Debug.trace(this.gameName + " stop hu x2");
          this.countHu = -1;
          this.countNoHuX2 = 0;
          this.huX2 = false;
          this.sv.setValue(this.name + "_count_hu", this.countHu);
          this.sv.setValue(this.name + "_count_no_hu_x2", this.countNoHuX2);
     }

     public void noHuX2() {
          if (this.countHu > -1) {
               ++this.countHu;
               this.sv.setValue(this.name + "_count_hu", this.countHu);
               if (this.huX2) {
                    ++this.countNoHuX2;
                    this.sv.setValue(this.name + "_count_no_hu_x2", this.countNoHuX2);
                    Debug.trace(this.gameName + " No hu X2: " + this.countHu + " , huX2= " + this.countNoHuX2);
                    if (this.betValue == 100 && this.countNoHuX2 >= 10) {
                         this.module.stopX2();
                         this.stopHuX2();
                    }

                    if (this.betValue == 1000 && this.countNoHuX2 >= 1) {
                         this.module.stopX2();
                         this.stopHuX2();
                    }
               }

               this.calculatHuX2();
          }

     }

     private void calculatHuX2() {
          if (this.countHu > -1 && this.moneyType == 1) {
               if (this.betValue == 100) {
                    if (this.countHu % 4 == 1 && this.countNoHuX2 < 10) {
                         this.huX2 = true;
                    } else {
                         this.huX2 = false;
                    }
               } else if (this.betValue == 1000) {
                    if (this.countHu == 3 && this.countNoHuX2 < 1) {
                         this.huX2 = true;
                    } else {
                         this.huX2 = false;
                    }
               }
          }

     }

     public int getBetValue() {
          return this.betValue;
     }

     public void forceStopAutoPlay(User user) {
          user.removeProperty("auto_" + this.gameName);
     }

     public void autoPlay(User user, String lines, short resultFirstPlay) {
          synchronized(this.usersAuto) {
               AutoUser autoUser;
               if (this.usersAuto.containsKey(user.getName())) {
                    autoUser = (AutoUser)this.usersAuto.get(user.getName());
                    this.forceStopAutoPlay(autoUser.getUser());
               }

               autoUser = new AutoUser(user, lines);
               if (resultFirstPlay == 0) {
                    autoUser.setMaxCount(autoUser.isSpeedUp() ? 3 : 5);
               } else if (resultFirstPlay == 5) {
                    autoUser.setMaxCount(20);
               } else {
                    autoUser.setMaxCount(autoUser.isSpeedUp() ? 4 : 8);
               }

               this.usersAuto.put(user.getName(), autoUser);
               user.setProperty("auto_" + this.gameName, true);
          }
     }

     public void stopAutoPlay(User user) {
          synchronized(this.usersAuto) {
               if (this.usersAuto.containsKey(user.getName())) {
                    AutoUser entry = (AutoUser)this.usersAuto.get(user.getName());
                    if (entry.getUser().getUniqueId() == user.getUniqueId()) {
                         this.usersAuto.remove(user.getName());
                         user.removeProperty("auto_" + this.gameName);
                    }
               }

          }
     }

     public void speedUp(User user, byte speedUp) {
          synchronized(this.usersAuto) {
               if (this.usersAuto.containsKey(user.getName())) {
                    AutoUser entry = (AutoUser)this.usersAuto.get(user.getName());
                    entry.setSpeedUp(speedUp == 1 ? true : false);
               }

          }
     }

     public void userMinimize(User user) {
          synchronized(this.usersAuto) {
               if (this.usersAuto.containsKey(user.getName())) {
                    AutoUser entry = (AutoUser)this.usersAuto.get(user.getName());
                    if (entry.getUser().getUniqueId() == user.getUniqueId()) {
                         entry.setMinimize(true);
                    }
               }

          }
     }

     public void userMaximize(User user) {
          synchronized(this.usersAuto) {
               if (this.usersAuto.containsKey(user.getName())) {
                    AutoUser entry = (AutoUser)this.usersAuto.get(user.getName());
                    if (entry.getUser().getUniqueId() == user.getUniqueId()) {
                         entry.setMinimize(false);
                    }
               }

          }
     }

     public boolean isUserMinimize(User user) {
          synchronized(this.usersAuto) {
               if (this.usersAuto.containsKey(user.getName())) {
                    AutoUser entry = (AutoUser)this.usersAuto.get(user.getName());
                    if (entry.getUser().getUniqueId() == user.getUniqueId()) {
                         return entry.isMinimize();
                    }
               }

               return false;
          }
     }

     protected abstract void gameLoop();

     protected abstract void playListAuto(List var1);

     protected String buildDescription(long totalBet, long totalPrizes, short result) {
          return totalBet == 0L ? this.resultToString(result) + ": " + totalPrizes : "Quay: " + (totalBet == 0L ? "free" : totalBet) + ", " + this.resultToString(result) + ": " + totalPrizes;
     }

     protected String resultToString(short result) {
          switch(result) {
          case 1:
          case 5:
               return "Thắng";
          case 2:
               return "Thắng lớn";
          case 3:
               return "Nổ hũ";
          case 4:
               return "Nổ hũ X2";
          default:
               return "Trượt";
          }
     }

     public byte getId() {
          return this.id;
     }

     public class ResultSlot {
          public static final short LOI_HE_THONG = 100;
          public static final short DAT_CUOC_KHONG_HOP_LE = 101;
          public static final short KHONG_DU_TIEN = 102;
          public static final short LUOT_QUAY_FREE_KHONG_HOP_LE = 103;
          public static final short TRUOT = 0;
          public static final short THANG = 1;
          public static final short THANG_LON = 2;
          public static final short NO_HU = 3;
          public static final short NO_HU_X2 = 4;
          public static final short MINIGAME_SLOT = 5;
     }

     protected final class GameLoopTask implements Runnable {
          public void run() {
               try {
                    SlotRoom.this.gameLoop();
               } catch (Exception var2) {
                    var2.printStackTrace();
               }

          }
     }

     protected final class PlayListAutoUserTask extends Thread {
          private List users;

          protected PlayListAutoUserTask(List users) {
               this.users = users;
               this.setName(SlotRoom.this.gameName + "_" + SlotRoom.this.betValue + "_AutoPlayTask");
          }

          public void run() {
               SlotRoom.this.playListAuto(this.users);
          }
     }
}
