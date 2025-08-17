package com.archie.domain;

import com.archie.config.Constants;

import com.fasterxml.jackson.annotation.JsonIgnore;
import org.hibernate.annotations.BatchSize;
import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Pattern;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.util.HashSet;
import java.util.Set;

/**
 * A user.
 */
@Entity
@Table(name = "tx_user")
@Cache(usage = CacheConcurrencyStrategy.NONSTRICT_READ_WRITE)
public class User implements Serializable {

	private static final long serialVersionUID = 1L;

	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Long id;

	@NotNull
	@Pattern(regexp = Constants.LOGIN_REGEX)
	@Size(min = 1, max = 50)
	@Column(length = 50, unique = true, nullable = false)
	private String login;

	@JsonIgnore
	@Size(min = 4, max = 260)
	@Column(name = "password_hash", length = 60, nullable = false)
	private String password;

	@NotNull
	@Column(nullable = false)
	private boolean activated = true;

	@Size(min = 2, max = 10)
	@Column(name = "lang_key", length = 10)
	private String langKey;

	@Column(name = "min_amount")
	private long minAmount;

	@Column(name = "max_amount")
	private long maxAmount;
	
	@Column(name = "full_name" ,length = 200)
	private String fullName;
	
	@Column(name = "total_winamount")
	private Double totalWinAmount = 0.0;

	@JsonIgnore
	@ManyToMany
	@JoinTable(name = "tx_user_authority", joinColumns = {
			@JoinColumn(name = "user_id", referencedColumnName = "id") }, inverseJoinColumns = {
					@JoinColumn(name = "authority_name", referencedColumnName = "name") })
	@Cache(usage = CacheConcurrencyStrategy.NONSTRICT_READ_WRITE)
	@BatchSize(size = 20)
	private Set<Authority> authorities = new HashSet<>();
	
	
	/**
	 * @return the totalWinAmount
	 */
	public Double getTotalWinAmount() {
		return totalWinAmount;
	}

	/**
	 * @param totalWinAmount the totalWinAmount to set
	 */
	public void setTotalWinAmount(Double totalWinAmount) {
		this.totalWinAmount = totalWinAmount;
	}

	/**
	 * @return the fullName
	 */
	public String getFullName() {
		return fullName;
	}

	/**
	 * @param fullName the fullName to set
	 */
	public void setFullName(String fullName) {
		this.fullName = fullName;
	}

	/**
	 * @return the minAmount
	 */
	public long getMinAmount() {
		return minAmount;
	}

	/**
	 * @param minAmount the minAmount to set
	 */
	public void setMinAmount(long minAmount) {
		this.minAmount = minAmount;
	}

	/**
	 * @return the maxAmount
	 */
	public long getMaxAmount() {
		return maxAmount;
	}

	/**
	 * @param maxAmount the maxAmount to set
	 */
	public void setMaxAmount(long maxAmount) {
		this.maxAmount = maxAmount;
	}

	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public String getLogin() {
		return login;
	}

	public void setLogin(String login) {
		this.login = login;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public boolean getActivated() {
		return activated;
	}

	public void setActivated(boolean activated) {
		this.activated = activated;
	}

	public String getLangKey() {
		return langKey;
	}

	public void setLangKey(String langKey) {
		this.langKey = langKey;
	}

	public Set<Authority> getAuthorities() {
		return authorities;
	}

	public void setAuthorities(Set<Authority> authorities) {
		this.authorities = authorities;
	}

	@Override
	public boolean equals(Object o) {
		if (this == o) {
			return true;
		}
		if (!(o instanceof User)) {
			return false;
		}
		return id != null && id.equals(((User) o).id);
	}

	@Override
	public int hashCode() {
		return 31;
	}

	@Override
	public String toString() {
		return "User [id=" + id + ", login=" + login + ", password=" + password + ", activated=" + activated
				+ ", langKey=" + langKey + ", minAmount=" + minAmount + ", maxAmount=" + maxAmount + ", fullName="
				+ fullName + ", totalWinAmount=" + totalWinAmount + ", authorities=" + authorities + "]";
	}

}
