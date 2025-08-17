/*
 * Decompiled with CFR 0.144.
 */
package com.vinplay.dichvuthe.response;

public class RechargeResponse {
    private int code;
    private long currentMoney;
    private int fail;
    private long time;

    private String message;

    public RechargeResponse(int code, long currentMoney, int fail, long time) {
        this.code = code;
        this.currentMoney = currentMoney;
        this.fail = fail;
        this.time = time;
    }

    public int getCode() {
        return this.code;
    }

    public void setCode(int code) {
        this.code = code;
    }

    public long getCurrentMoney() {
        return this.currentMoney;
    }

    public void setCurrentMoney(long currentMoney) {
        this.currentMoney = currentMoney;
    }

    public int getFail() {
        return this.fail;
    }

    public void setFail(int fail) {
        this.fail = fail;
    }

    public long getTime() {
        return this.time;
    }

    public void setTime(long time) {
        this.time = time;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}

