package bitzero.util.payment;

import org.json.JSONObject;

public class HoldCashPacketReceive extends PacketPaymentReceive {
     public String HoldID;
     public int UserCnt;
     public int RetCode;

     public HoldCashPacketReceive(JSONObject data) {
          super(data);
     }
}
