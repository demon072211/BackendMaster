package com.archie.entity;

import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import javax.persistence.*;

import java.io.Serializable;

/**
 * A TxRank.
 */
@Entity
@Table(name = "tx_rank")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class TxRank implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "nick_name")
    private String loginname;

    @Column(name = "amount")
    private Long amount;

    // jhipster-needle-entity-add-field - JHipster will add fields here
    public Long getId() {
        return id;
    }

    public TxRank(String nickname, Long amount) {
		this.loginname = nickname;
		this.amount = amount;
	}

	public TxRank() {
	}

	public void setId(Long id) {
        this.id = id;
    }

    public String getLoginname() {
        return loginname;
    }

    public TxRank loginname(String loginname) {
        this.loginname = loginname;
        return this;
    }

    public void setLoginname(String loginname) {
        this.loginname = loginname;
    }

    public Long getAmount() {
        return amount;
    }

    public TxRank amount(Long amount) {
        this.amount = amount;
        return this;
    }

    public void setAmount(Long amount) {
        this.amount = amount;
    }
    // jhipster-needle-entity-add-getters-setters - JHipster will add getters and setters here

    @Override
    public boolean equals(Object o) {
        if (this == o) {
            return true;
        }
        if (!(o instanceof TxRank)) {
            return false;
        }
        return loginname != null && loginname.equals(((TxRank) o).loginname);
    }

    @Override
    public int hashCode() {
        return 31;
    }

    // prettier-ignore
    @Override
    public String toString() {
        return "TxRank{" +
            "id=" + getId() +
            ", loginname='" + getLoginname() + "'" +
            ", amount=" + getAmount() +
            "}";
    }

}
