/*
 * Decompiled with CFR 0.144.
 */
package com.vinplay.usercore.entities;

public class TransferMoneyResponse {
    private byte code;
    private long moneyUse;
    private long currentMoney;
    private String nicknameReceive;
    private long currentMoneyReceive;
    private long moneyReceive;
    private byte isAuth;

    public TransferMoneyResponse(byte code, long moneyUse, long currentMoney) {
        this.code = code;
        this.moneyUse = moneyUse;
        this.currentMoney = currentMoney;
    }

    public long getMoneyReceive() {
        return this.moneyReceive;
    }

    public void setMoneyReceive(long moneyReceive) {
        this.moneyReceive = moneyReceive;
    }

    public long getCurrentMoneyReceive() {
        return this.currentMoneyReceive;
    }

    public void setCurrentMoneyReceive(long currentMoneyReceive) {
        this.currentMoneyReceive = currentMoneyReceive;
    }

    public String getNicknameReceive() {
        return this.nicknameReceive;
    }

    public void setNicknameReceive(String nicknameReceive) {
        this.nicknameReceive = nicknameReceive;
    }

    public byte getCode() {
        return this.code;
    }

    public void setCode(byte code) {
        this.code = code;
    }

    public long getMoneyUse() {
        return this.moneyUse;
    }

    public void setMoneyUse(long moneyUse) {
        this.moneyUse = moneyUse;
    }

    public long getCurrentMoney() {
        return this.currentMoney;
    }

    public void setCurrentMoney(long currentMoney) {
        this.currentMoney = currentMoney;
    }

    public byte getIsAuth() {
        return isAuth;
    }

    public void setIsAuth(byte isAuth) {
        this.isAuth = isAuth;
    }
}

