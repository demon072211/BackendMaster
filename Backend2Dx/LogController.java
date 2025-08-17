package bitzero.util.logcontroller.business;

import bitzero.util.logcontroller.business.scribe.ScribeLogController;

public class LogController {
     static ScribeLogController _instance;
     static final Object lock = new Object();

     public static ILogController GetController() {
          if (_instance == null) {
               synchronized(lock) {
                    if (_instance == null) {
                         _instance = new ScribeLogController();
                    }
               }
          }

          return _instance;
     }
}
