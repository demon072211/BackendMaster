package game.modules.slot;

import bitzero.server.BitZeroServer;
import bitzero.server.entities.User;
import bitzero.server.extensions.BaseClientRequestHandler;
import bitzero.server.extensions.data.BaseMsg;
import bitzero.server.extensions.data.DataCmd;
import bitzero.util.common.business.Debug;
import com.vinplay.dal.service.CacheService;
import com.vinplay.dal.service.impl.CacheServiceImpl;
import com.vinplay.vbee.common.enums.Games;
import game.modules.slot.cmd.send.hall.ListAutoPlayInfoMsg;
import game.modules.slot.cmd.send.hall.UpdateJackpotsMsg;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Set;
import java.util.concurrent.TimeUnit;
import org.json.simple.JSONObject;

public class HallSlotModule extends BaseClientRequestHandler {
     private Set usersSub = new HashSet();
     private Runnable updateJackpotsTask = new UpdateJackpotsTask();

     public HallSlotModule() {
          BitZeroServer.getInstance().getTaskScheduler().scheduleAtFixedRate(this.updateJackpotsTask, 10, 4, TimeUnit.SECONDS);
     }

     public void handleClientRequest(User user, DataCmd dataCmd) {
          switch(dataCmd.getId()) {
          case 10001:
               this.subScribe(user, dataCmd);
               break;
          case 10002:
               this.unSubscribe(user, dataCmd);
          }

     }

     protected void subScribe(User user, DataCmd dataCmd) {
          synchronized(this.usersSub) {
               this.usersSub.add(user);
          }

          UpdateJackpotsMsg msg = new UpdateJackpotsMsg();
          msg.json = this.buildJsonJackpots();
          this.send(msg, user);
          ListAutoPlayInfoMsg listAutoMsg = new ListAutoPlayInfoMsg();
          boolean auto;
          if (user.getProperty("auto_" + Games.KHO_BAU.getName()) != null) {
               auto = (Boolean)user.getProperty("auto_" + Games.KHO_BAU.getName());
               listAutoMsg.autoKhoBau = auto;
          }

          if (user.getProperty("auto_" + Games.NU_DIEP_VIEN.getName()) != null) {
               auto = (Boolean)user.getProperty("auto_" + Games.NU_DIEP_VIEN.getName());
               listAutoMsg.autoNDV = auto;
          }

          if (user.getProperty("auto_" + Games.AVENGERS.getName()) != null) {
               auto = (Boolean)user.getProperty("auto_" + Games.AVENGERS.getName());
               listAutoMsg.autoAvenger = auto;
          }

          if (user.getProperty("auto_" + Games.VUONG_QUOC_VIN.getName()) != null) {
               auto = (Boolean)user.getProperty("auto_" + Games.VUONG_QUOC_VIN.getName());
               listAutoMsg.autoVQV = auto;
          }

          this.send(listAutoMsg, user);
     }

     protected void unSubscribe(User user, DataCmd dataCmd) {
          synchronized(this.usersSub) {
               this.usersSub.remove(user);
          }
     }

     private String buildJsonJackpots() {
          JSONObject json = new JSONObject();
          JSONObject jsonKhoBau = this.buildGameSlotInfo(Games.KHO_BAU.getName());
          json.put("kb", jsonKhoBau);
          JSONObject jsonNDV = this.buildGameSlotInfo(Games.NU_DIEP_VIEN.getName());
          json.put("ndv", jsonNDV);
          JSONObject jsonAvenger = this.buildGameSlotInfo(Games.AVENGERS.getName());
          json.put("sah", jsonAvenger);
          JSONObject jsonVQV = this.buildGameSlotInfo(Games.VUONG_QUOC_VIN.getName());
          json.put("vqv", jsonVQV);
          return json.toJSONString();
     }

     private JSONObject buildGameSlotInfo(String gameName) {
          JSONObject jsonGame = new JSONObject();

          try {
               JSONObject room100 = this.buildRoomSlotInfo(gameName, 100);
               jsonGame.put("100", room100);
               JSONObject room101 = this.buildRoomSlotInfo(gameName, 1000);
               jsonGame.put("1000", room101);
               JSONObject room102 = this.buildRoomSlotInfo(gameName, 10000);
               jsonGame.put("10000", room102);
          } catch (Exception var6) {
               Debug.trace("Hall Slot get jackpots " + gameName + " error: " + var6.getMessage());
          }

          return jsonGame;
     }

     private JSONObject buildRoomSlotInfo(String gameName, int room) {
          CacheService cacheService = new CacheServiceImpl();
          JSONObject jsonValue = new JSONObject();

          try {
               int pot = cacheService.getValueInt(gameName + "_vin_" + room);
               jsonValue.put("p", pot);
               int x2 = cacheService.getValueInt(gameName + "_vin_" + room + "_x2");
               jsonValue.put("x2", x2);
          } catch (Exception var7) {
               Debug.trace("Hall Slot get jackpots " + gameName + " - " + room + " error: " + var7.getMessage());
          }

          return jsonValue;
     }

     static void access$2(HallSlotModule hallSlotModule, BaseMsg baseMsg, User user) {
          hallSlotModule.send(baseMsg, user);
     }

     private class UpdateJackpotsTask implements Runnable {
          private UpdateJackpotsTask() {
          }

          public void run() {
               try {
                    String result = HallSlotModule.this.buildJsonJackpots();
                    UpdateJackpotsMsg msg = new UpdateJackpotsMsg();
                    msg.json = result;
                    synchronized(HallSlotModule.this.usersSub) {
                         Iterator var4 = HallSlotModule.this.usersSub.iterator();

                         while(var4.hasNext()) {
                              User user = (User)var4.next();
                              if (user != null) {
                                   HallSlotModule.access$2(HallSlotModule.this, msg, user);
                              }
                         }
                    }
               } catch (Exception var8) {
                    Debug.trace("Update slot exception: " + var8.getMessage());
               }

          }

          // $FF: synthetic method
          UpdateJackpotsTask(Object x1) {
               this();
          }
     }
}
