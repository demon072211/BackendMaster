/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  bitzero.server.extensions.data.BaseMsg
 */
package game.lieng.server.cmd.send;

import bitzero.server.extensions.data.BaseMsg;
import java.nio.ByteBuffer;

public class SendDealPrivateCard
extends BaseMsg {
    public int gameId;
    public int chair;
    public byte[] cards;
    public int card_name;
    public int countDown;

    public SendDealPrivateCard() {
        super((short)3106);
    }

    public byte[] createData() {
        ByteBuffer bf = this.makeBuffer();
        bf.put((byte)this.chair);
        this.putByteArray(bf, this.cards);
        bf.put((byte)this.card_name);
        bf.put((byte)this.countDown);
        return this.packBuffer(bf);
    }
}

