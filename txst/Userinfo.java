package com.archie.domain;

import org.hibernate.annotations.BatchSize;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import com.fasterxml.jackson.annotation.JsonIgnore;

import javax.persistence.*;

import java.io.Serializable;
import java.util.HashSet;
import java.util.Set;

/**
 * A Userinfo.
 */
@Entity
@Table(name = "users")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Userinfo implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "user_name")
    private String loginname;
    
    @Column(name = "nick_name")
    private String nickName;

    @Column(name = "password")
    private String pwd;

    @Column(name = "vin")
    private Double balance;
    
    @JsonIgnore
	@ManyToMany
	@JoinTable(name = "tx_user_authority", joinColumns = {
			@JoinColumn(name = "user_id", referencedColumnName = "id") }, inverseJoinColumns = {
					@JoinColumn(name = "authority_name", referencedColumnName = "name") })
	@Cache(usage = CacheConcurrencyStrategy.NONSTRICT_READ_WRITE)
	@BatchSize(size = 20)
	private Set<Authority> authorities = new HashSet<>();

    public Set<Authority> getAuthorities() {
		return authorities;
	}

	public void setAuthorities(Set<Authority> authorities) {
		this.authorities = authorities;
	}
	
    public String getNickName() {
		return nickName;
	}

	public void setNickName(String nickName) {
		this.nickName = nickName;
	}

	/**
	 * @return the balance
	 */
	public Double getBalance() {
		return balance;
	}

	/**
	 * @param balance the balance to set
	 */
	public void setBalance(Double balance) {
		this.balance = balance;
	}

    /**
	 * @param id
	 * @param loginname
	 * @param pwd
	 * @param usertype
	 * @param status
	 * @param fatherid
	 * @param balance
	 * @param authorities
	 */
	public Userinfo(User unew, String password) {
		this.id = unew.getId();
		this.loginname = unew.getLogin();
		this.pwd = password;
		this.balance = 0d;
		this.authorities = unew.getAuthorities();
	}
	

	/**
	 * 
	 */
	public Userinfo() {
	}

	// jhipster-needle-entity-add-field - JHipster will add fields here
    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getLoginname() {
        return loginname;
    }

    public Userinfo loginname(String loginname) {
        this.loginname = loginname;
        return this;
    }

    public void setLoginname(String loginname) {
        this.loginname = loginname;
    }

    public String getPwd() {
        return pwd;
    }

    public Userinfo pwd(String pwd) {
        this.pwd = pwd;
        return this;
    }

    public void setPwd(String pwd) {
        this.pwd = pwd;
    }

    
    // jhipster-needle-entity-add-getters-setters - JHipster will add getters and setters here

    @Override
    public boolean equals(Object o) {
        if (this == o) {
            return true;
        }
        if (!(o instanceof Userinfo)) {
            return false;
        }
        return id != null && id.equals(((Userinfo) o).id);
    }

    @Override
    public int hashCode() {
        return 31;
    }

    // prettier-ignore
    @Override
    public String toString() {
        return "Userinfo{" +
            "id=" + getId() +
            ", loginname='" + getLoginname() + "'" +
            ", pwd='" + getPwd() + "'" +
            "}";
    }
}
