package game;

import bitzero.engine.sessions.ISession;
import bitzero.server.BitZeroServer;
import bitzero.server.core.BZEventType;
import bitzero.server.entities.data.ISFSObject;
import bitzero.server.exceptions.BZException;
import bitzero.server.extensions.BZExtension;
import bitzero.server.extensions.data.DataCmd;
import bitzero.util.ExtensionUtility;
import bitzero.util.common.business.Debug;
import bitzero.util.socialcontroller.bean.UserInfo;
import com.vinplay.usercore.utils.GameCommon;
import com.vinplay.vbee.common.hazelcast.HazelcastLoader;
import com.vinplay.vbee.common.mongodb.MongoDBConnectionFactory;
import com.vinplay.vbee.common.pools.ConnectionPool;
import com.vinplay.vbee.common.rmq.RMQApi;
import game.eventHandlers.LoginSuccessHandler;
import game.modules.slot.AvengerModule;
import game.modules.slot.HallSlotModule;
import game.modules.slot.KhoBauModule;
import game.modules.slot.NuDiepVienModule;
import game.modules.slot.VQVModule;
import game.modules.slot.cmd.rev.LoginCmd;
import game.modules.slot.entities.BotMinigame;
import game.util.ConfigGame;
import game.util.GameUtils;
import java.util.concurrent.TimeUnit;

public class SlotMachineExtension extends BZExtension {
     private int countReloadConfig = 0;
     private final Runnable gameLoopTask = new GameLoopTask();

     public void init() {
          try {
               RMQApi.start("config/rmq.properties");
               HazelcastLoader.start();
               MongoDBConnectionFactory.init();
               ConnectionPool.start("config/db_pool.properties");
               ConfigGame.reload();
               BotMinigame.loadData();
               GameCommon.init();
          } catch (Exception var2) {
               Debug.trace("INIT MINIGAME ERROR " + var2.getMessage());
          }

          this.addRequestHandler((short)10000, HallSlotModule.class);
          this.addRequestHandler((short)2000, KhoBauModule.class);
          this.addRequestHandler((short)3000, NuDiepVienModule.class);
          this.addRequestHandler((short)4000, AvengerModule.class);
          this.addRequestHandler((short)5000, VQVModule.class);
          this.addEventHandler(BZEventType.USER_LOGIN, LoginSuccessHandler.class);
          this.addEventHandler(BZEventType.USER_DISCONNECT, LoginSuccessHandler.class);
          BitZeroServer.getInstance().getTaskScheduler().scheduleAtFixedRate(this.gameLoopTask, 10, 1, TimeUnit.SECONDS);
     }

     public void doLogin(short s, ISession iSession, DataCmd dataCmd) throws BZException {
          if (s == 1) {
               LoginCmd cmd = new LoginCmd(dataCmd);
               UserInfo info = GameUtils.getUserInfo(cmd.nickname, cmd.sessionKey);
               if (info != null) {
                    ExtensionUtility.instance().canLogin(info, "", iSession);
               }

          }
     }

     public void doLogin(ISession iSession, ISFSObject iSFSObject) throws Exception {
     }

     private void gameLoop() {
          ++this.countReloadConfig;
          if (this.countReloadConfig == 300) {
               Debug.trace("reload config");
               ConfigGame.reload();
               this.countReloadConfig = 0;
          }

     }

     private final class GameLoopTask implements Runnable {
          private GameLoopTask() {
          }

          public void run() {
               SlotMachineExtension.this.gameLoop();
          }

          // $FF: synthetic method
          GameLoopTask(Object x1) {
               this();
          }
     }
}
