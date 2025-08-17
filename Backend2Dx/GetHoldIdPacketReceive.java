package bitzero.util.payment;

import org.json.JSONObject;

public class GetHoldIdPacketReceive extends PacketPaymentReceive {
     public String HoldID;
     public int RetCode;
     public String AccountName;

     public GetHoldIdPacketReceive(JSONObject data) {
          super(data);
     }
}
