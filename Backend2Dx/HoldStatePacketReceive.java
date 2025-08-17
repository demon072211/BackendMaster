package bitzero.util.payment;

import org.json.JSONObject;

public class HoldStatePacketReceive extends PacketPaymentReceive {
     public String AccountName;
     public String HoldID;
     public int RetCode;

     public HoldStatePacketReceive(JSONObject data) {
          super(data);
     }
}
