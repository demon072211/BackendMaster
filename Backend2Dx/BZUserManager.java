package bitzero.server.entities.managers;

import bitzero.engine.sessions.ISession;
import bitzero.engine.sessions.ISessionManager;
import bitzero.server.BitZeroServer;
import bitzero.server.api.IBZApi;
import bitzero.server.core.BaseCoreService;
import bitzero.server.entities.Room;
import bitzero.server.entities.User;
import bitzero.server.entities.Zone;
import bitzero.server.exceptions.BZRuntimeException;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;
import java.util.concurrent.ConcurrentHashMap;
import java.util.concurrent.ConcurrentMap;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public final class BZUserManager extends BaseCoreService implements IUserManager {
     private final ConcurrentMap usersByName = new ConcurrentHashMap();
     private final ConcurrentMap usersBySession = new ConcurrentHashMap();
     private final ConcurrentMap usersById = new ConcurrentHashMap();
     private Room ownerRoom;
     private Zone ownerZone;
     private Logger logger = LoggerFactory.getLogger(this.getClass());
     private int highestCCU = 0;

     public void addUser(User user) {
          if (this.containsId(user.getUniqueId())) {
               throw new BZRuntimeException("Can't add User: " + user.getName() + " - Already exists in Room: " + this.ownerRoom + ", Zone: " + this.ownerZone);
          } else {
               this.usersById.put(user.getUniqueId(), user);
               List users = (List)this.usersByName.get(user.getName());
               if (users == null) {
                    users = new ArrayList();
                    ((List)users).add(user);
               } else {
                    ((List)users).add(user);
               }

               this.usersByName.put(user.getName(), users);
               this.usersBySession.put(user.getSession(), user);
               if (this.usersById.size() > this.highestCCU) {
                    this.highestCCU = this.usersById.size();
               }

          }
     }

     public User getUserById(int id) {
          return (User)this.usersById.get(id);
     }

     public List getUserByName(String name) {
          return (List)this.usersByName.get(name);
     }

     public User getUserBySession(ISession session) {
          return (User)this.usersBySession.get(session);
     }

     public void removeUser(int userId) {
          User user = (User)this.usersById.get(userId);
          if (user == null) {
               this.logger.warn("Can't remove user with ID: " + userId + ". User was not found.");
          } else {
               this.removeUser(user);
          }

     }

     public void removeUser(String name) {
          List users = (List)this.usersByName.get(name);
          if (users != null) {
               Iterator var3 = users.iterator();

               while(var3.hasNext()) {
                    User user = (User)var3.next();
                    if (user == null) {
                         this.logger.warn("Can't remove user with name: " + name + ". User was not found.");
                    } else {
                         this.removeUser(user);
                    }
               }

          }
     }

     public void removeUser(ISession session) {
          User user = (User)this.usersBySession.get(session);
          if (user == null) {
               throw new BZRuntimeException("Can't remove user with session: " + session + ". User was not found.");
          } else {
               this.removeUser(user);
          }
     }

     public void removeUser(User user) {
          this.usersById.remove(user.getUniqueId());
          List users = this.getUserByName(user.getName());
          User userRemoved = null;
          Iterator var4 = users.iterator();

          while(var4.hasNext()) {
               User u = (User)var4.next();
               if (u.getUniqueId() == user.getUniqueId()) {
                    userRemoved = u;
                    break;
               }
          }

          if (userRemoved != null) {
               users.remove(userRemoved);
               if (users.size() == 0) {
                    this.usersByName.remove(user.getName());
               }
          }

          this.usersBySession.remove(user.getSession());
     }

     public boolean containsId(int userId) {
          return this.usersById.containsKey(userId);
     }

     public boolean containsName(String name) {
          return this.usersByName.containsKey(name);
     }

     public boolean containsSessions(ISession session) {
          return this.usersBySession.containsKey(session);
     }

     public boolean containsUser(User user) {
          return this.usersById.containsKey(user.getUniqueId());
     }

     public Room getOwnerRoom() {
          return this.ownerRoom;
     }

     public void setOwnerRoom(Room ownerRoom) {
          this.ownerRoom = ownerRoom;
     }

     public Zone getOwnerZone() {
          return this.ownerZone;
     }

     public void setOwnerZone(Zone ownerZone) {
          this.ownerZone = ownerZone;
     }

     public List getAllUsers() {
          return new ArrayList(this.usersById.values());
     }

     public List getAllSessions() {
          return new ArrayList(this.usersBySession.keySet());
     }

     public int getUserCount() {
          return this.usersById.values().size();
     }

     public int getUserCountByName() {
          return this.usersByName.values().size();
     }

     public int getHighestCCU() {
          return this.highestCCU;
     }

     public void disconnectUser(int userId) {
          User user = (User)this.usersById.get(userId);
          if (user == null) {
               this.logger.warn("Can't disconnect user with id: " + userId + ". User was not found.");
          } else {
               this.disconnectUser(user);
          }

     }

     public void disconnectUser(ISession session) {
          User user = (User)this.usersBySession.get(session);
          if (user == null) {
               this.logger.warn("Can't disconnect user with session: " + session + ". User was not found.");
          } else {
               this.disconnectUser(user);
          }

     }

     public void disconnectUser(String name) {
          User user = (User)this.usersByName.get(name);
          if (user == null) {
               this.logger.warn("Can't disconnect user with name: " + name + ". User was not found.");
          } else {
               this.disconnectUser(user);
          }

     }

     public void disconnectUser(User user) {
          this.removeUser(user);
     }

     public void purgeOrphanedUsers() {
          ISessionManager mgr = BitZeroServer.getInstance().getSessionManager();
          IBZApi api = BitZeroServer.getInstance().getAPIManager().getBzApi();
          int tot = 0;
          Iterator iterator = this.usersBySession.keySet().iterator();

          while(iterator.hasNext()) {
               ISession session = (ISession)iterator.next();
               if (!mgr.containsSession(session)) {
                    User evictable = (User)this.usersBySession.get(session);
                    api.disconnectUser(evictable);
                    ++tot;
               }
          }

          this.logger.info("Evicted " + tot + " users.");
     }

     private String getOwnerDetails() {
          StringBuilder sb = new StringBuilder();
          if (this.ownerZone != null) {
               sb.append("Zone: ").append(this.ownerZone.getName());
          } else if (this.ownerRoom != null) {
               sb.append("Zone: ").append(this.ownerRoom.getZone().getName()).append("Room: ").append(this.ownerRoom.getName()).append(", Room Id: ").append(this.ownerRoom.getId());
          }

          return sb.toString();
     }

     private void populateTransientFields() {
          this.logger = LoggerFactory.getLogger(this.getClass());
     }
}
