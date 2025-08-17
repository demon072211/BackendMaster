package game.modules.slot;

import bitzero.server.BitZeroServer;
import bitzero.server.entities.User;
import bitzero.server.extensions.BaseClientRequestHandler;
import bitzero.server.extensions.data.BaseMsg;
import bitzero.server.extensions.data.DataCmd;
import com.vinplay.dal.service.MiniGameService;
import com.vinplay.dal.service.SlotMachineService;
import com.vinplay.dal.service.impl.MiniGameServiceImpl;
import com.vinplay.dal.service.impl.SlotMachineServiceImpl;
import com.vinplay.usercore.service.UserService;
import com.vinplay.usercore.service.impl.UserServiceImpl;
import game.modules.slot.cmd.send.khobau.PokeGoX2Msg;
import game.modules.slot.entities.BotMinigame;
import game.modules.slot.room.SlotRoom;
import game.modules.slot.utils.SlotUtils;
import game.util.ConfigGame;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.concurrent.TimeUnit;

public abstract class SlotModule extends BaseClientRequestHandler {
     protected Map rooms = new HashMap();
     protected MiniGameService service = new MiniGameServiceImpl();
     protected SlotMachineService slotService = new SlotMachineServiceImpl();
     protected UserService userService = new UserServiceImpl();
     protected boolean eventX2 = false;
     protected String ngayX2;
     protected long[] pots = new long[3];
     protected long lastTimeUpdatePotToRoom = 0L;
     protected int countBot100;
     protected int countBot1000;
     protected int countBot10000;
     protected GameLoopTask gameLoopTask = new GameLoopTask();
     protected String gameName;
     protected X2Task x2Task = new X2Task();

     public void handleClientRequest(User user, DataCmd dataCmd) {
     }

     protected abstract String getRoomName(short var1, long var2);

     protected abstract void gameLoop();

     public abstract long getNewReferenceId();

     public void startX2() {
          this.eventX2 = true;
          this.ngayX2 = "";
     }

     public void stopX2() {
          this.eventX2 = false;
          this.ngayX2 = SlotUtils.calculateTimePokeGoX2AsString(this.gameName, SlotUtils.getX2Days(this.gameName), SlotUtils.getLastDayX2(this.gameName));
          PokeGoX2Msg msg = new PokeGoX2Msg();
          msg.ngayX2 = this.ngayX2;
          Iterator var2 = this.rooms.values().iterator();

          while(var2.hasNext()) {
               SlotRoom room = (SlotRoom)var2.next();
               room.sendMessageToRoom(msg);
          }

          Calendar cal = Calendar.getInstance();
          int today = cal.get(7);
          SlotUtils.saveLastDayX2(this.gameName, today);
          int lastDayX2 = SlotUtils.getLastDayX2(this.gameName);
          int nextX2Time = SlotUtils.calculateTimePokeGoX2(this.gameName, SlotUtils.getX2Days(this.gameName), lastDayX2);
          BitZeroServer.getInstance().getTaskScheduler().schedule(this.x2Task, nextX2Time, TimeUnit.SECONDS);
     }

     protected int getCountTimeBot(String name) {
          int n = ConfigGame.getIntValue(name, 0);
          if (n == 0) {
               return 0;
          } else {
               if (BotMinigame.isNight()) {
                    n *= 3;
               }

               return n;
          }
     }

     protected SlotRoom getRoom(byte roomId) {
          short moneyType = this.getMoneyTypeFromRoomId(roomId);
          long baseBetting = this.getBaseBetting(roomId);
          String roomName = this.getRoomName(moneyType, baseBetting);
          SlotRoom room = (SlotRoom)this.rooms.get(roomName);
          return room;
     }

     protected short getMoneyTypeFromRoomId(byte roomId) {
          return (short)(roomId >= 0 && roomId < 3 ? 1 : 0);
     }

     protected long getBaseBetting(byte roomId) {
          switch(roomId) {
          case 0:
               return 100L;
          case 1:
               return 1000L;
          case 2:
               return 10000L;
          case 3:
               return 1000L;
          case 4:
               return 10000L;
          case 5:
               return 100000L;
          default:
               return 0L;
          }
     }

     protected void sendMessageToTS(BaseMsg msg) {
          Iterator var2 = this.rooms.values().iterator();

          while(var2.hasNext()) {
               SlotRoom room = (SlotRoom)var2.next();
               room.sendMessageToRoom(msg);
          }

     }

     public void sendMsgToAllUsers(BaseMsg msg) {
          SendMsgToAlLUsersThread t = new SendMsgToAlLUsersThread(msg);
          t.start();
     }

     protected final class X2Task implements Runnable {
          public void run() {
               SlotModule.this.startX2();
               SlotRoom room100 = (SlotRoom)SlotModule.this.rooms.get(SlotModule.this.gameName + "_vin_100");
               room100.startHuX2();
               SlotRoom room101 = (SlotRoom)SlotModule.this.rooms.get(SlotModule.this.gameName + "_vin_1000");
               room101.startHuX2();
          }
     }

     protected final class SendMsgToAlLUsersThread extends Thread {
          private BaseMsg msg;

          protected SendMsgToAlLUsersThread(BaseMsg msg) {
               this.msg = msg;
          }

          public void run() {
               SlotModule.this.sendMessageToTS(this.msg);
          }
     }

     protected final class GameLoopTask implements Runnable {
          public void run() {
               SlotModule.this.gameLoop();
          }
     }
}
