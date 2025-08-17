package game.modules.slot.cmd.rev.khobau;

import bitzero.server.extensions.data.BaseCmd;
import bitzero.server.extensions.data.DataCmd;
import java.nio.ByteBuffer;

public class PlayKhoBauCmd extends BaseCmd {
     public int betValue;
     public String lines;

     public PlayKhoBauCmd(DataCmd dataCmd) {
          super(dataCmd);
          this.unpackData();
     }

     public void unpackData() {
          ByteBuffer bf = this.makeBuffer();
          this.betValue = bf.getInt();
          this.lines = this.readString(bf);
     }
}
