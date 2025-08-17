package com.archie.entity;

import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import com.archie.config.Constants;
import com.archie.service.dto.TaiXiuBetDTO;

import javax.persistence.*;

import java.io.Serializable;
import java.time.LocalDateTime;

/**
 * A TaixiuRecord.
 */
@Entity
@Table(name = "taixiu_record")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class TaixiuRecord implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "taixiu_id")
    private Long taixiuId;

    @Column(name = "nick_name")
    private String loginname;

    @Column(name = "betamount")
    private Long betamount;

    @Column(name = "winamount")
    private Long winamount;

    @Column(name = "typed")
    private Integer typed;

    @Column(name = "status")
    private Integer status;

    @Column(name = "bettime")
    private LocalDateTime bettime;

    @Column(name = "result")
    private String result;

    @Column(name = "description")
    private String description;

    @Column(name = "refundamount")
    private Long refundamount;

    @Column(name = "ip")
    private String ip;
    
    @Column(name = "usertype")
    private Integer userType;

   
    /**
	 * @param id
	 * @param taixiuId
	 * @param userId
	 * @param loginname
	 * @param betamount
	 * @param winamount
	 * @param typed
	 * @param resultStatus
	 * @param bettime
	 * @param result
	 * @param description
	 * @param refundamount
	 * @param ip
	 */
	public TaixiuRecord(TaiXiuBetDTO txDto , int resultType) {
		this.taixiuId = txDto.getTaixiuId();
		this.loginname = txDto.getLoginname();
		this.betamount = txDto.getBetamount();
		this.typed = txDto.getTyped();
		this.status = Constants.STATUS_FINISH;
		this.bettime = LocalDateTime.now();
		this.ip = "127.0.0.1";
		this.refundamount = 0l;
		this.userType = txDto.getUserType();
		this.result = txDto.getResult();
		long winamount = 0;
		if (txDto.getTyped().intValue() == resultType) {
			winamount = (long) (txDto.getBetamount().longValue() + txDto.getBetamount().longValue() * Constants.rate);
		}
		this.winamount = winamount;
	}
	
	public TaixiuRecord(TaiXiuBetDTO txDto) {
		this.taixiuId = txDto.getTaixiuId();
		this.loginname = txDto.getLoginname();
		this.betamount = txDto.getBetamount();
		this.typed = txDto.getTyped();
		this.status = Constants.PENDING;
		this.bettime = LocalDateTime.now();
		this.ip = txDto.getIp();
		this.refundamount = 0l;
		this.winamount = 0l;
		this.result = "";
		this.userType = txDto.getUserType();
	}

	/**
	 * 
	 */
	public TaixiuRecord() {
	}

	public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getTaixiuId() {
        return taixiuId;
    }

    public TaixiuRecord taixiuId(Long taixiuId) {
        this.taixiuId = taixiuId;
        return this;
    }

    public void setTaixiuId(Long taixiuId) {
        this.taixiuId = taixiuId;
    }

    public String getLoginname() {
        return loginname;
    }

    public TaixiuRecord loginname(String loginname) {
        this.loginname = loginname;
        return this;
    }

    public void setLoginname(String loginname) {
        this.loginname = loginname;
    }

    public Long getBetamount() {
        return betamount;
    }

    public TaixiuRecord betamount(Long betamount) {
        this.betamount = betamount;
        return this;
    }

    public void setBetamount(Long betamount) {
        this.betamount = betamount;
    }

    public Long getWinamount() {
        return winamount;
    }

    public TaixiuRecord winamount(Long winamount) {
        this.winamount = winamount;
        return this;
    }

    public void setWinamount(Long winamount) {
        this.winamount = winamount;
    }

    public Integer getTyped() {
        return typed;
    }

    public TaixiuRecord typed(Integer typed) {
        this.typed = typed;
        return this;
    }

    public void setTyped(Integer typed) {
        this.typed = typed;
    }

    public Integer getStatus() {
        return status;
    }

    public TaixiuRecord status(Integer status) {
        this.status = status;
        return this;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    public LocalDateTime getBettime() {
        return bettime;
    }

    public TaixiuRecord bettime(LocalDateTime bettime) {
        this.bettime = bettime;
        return this;
    }

    public void setBettime(LocalDateTime bettime) {
        this.bettime = bettime;
    }

    public String getResult() {
        return result;
    }

    public TaixiuRecord result(String result) {
        this.result = result;
        return this;
    }

    public void setResult(String result) {
        this.result = result;
    }

    public String getDescription() {
        return description;
    }

    public TaixiuRecord description(String description) {
        this.description = description;
        return this;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Long getRefundamount() {
        return refundamount;
    }

    public TaixiuRecord refundamount(Long refundamount) {
        this.refundamount = refundamount;
        return this;
    }

    public void setRefundamount(Long refundamount) {
        this.refundamount = refundamount;
    }

    public String getIp() {
        return ip;
    }

    public TaixiuRecord ip(String ip) {
        this.ip = ip;
        return this;
    }

    /**
	 * @return the userType
	 */
	public Integer getUserType() {
		return userType;
	}

	/**
	 * @param userType the userType to set
	 */
	public void setUserType(Integer userType) {
		this.userType = userType;
	}

	public void setIp(String ip) {
        this.ip = ip;
    }
    // jhipster-needle-entity-add-getters-setters - JHipster will add getters and setters here

    @Override
    public boolean equals(Object o) {
        if (this == o) {
            return true;
        }
        if (!(o instanceof TaixiuRecord)) {
            return false;
        }
        return id != null && id.equals(((TaixiuRecord) o).id);
    }

    @Override
    public int hashCode() {
        return 31;
    }

    // prettier-ignore
    @Override
    public String toString() {
        return "TaixiuRecord{" +
            "id=" + getId() +
            ", taixiuId=" + getTaixiuId() +
            ", loginname='" + getLoginname() + "'" +
            ", betamount=" + getBetamount() +
            ", winamount=" + getWinamount() +
            ", typed=" + getTyped() +
            ", status=" + getStatus() +
            ", bettime='" + getBettime() + "'" +
            ", result='" + getResult() + "'" +
            ", description='" + getDescription() + "'" +
            ", refundamount=" + getRefundamount() +
            ", ip='" + getIp() + "'" +
            ", userType='" + getUserType() + "'" +
            "}";
    }
}
