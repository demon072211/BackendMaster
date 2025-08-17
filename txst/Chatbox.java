package com.archie.entity;

import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import com.archie.service.dto.WsChatDto;

import javax.persistence.*;

import java.io.Serializable;

/**
 * A Chatbox.
 */
@Entity
@Table(name = "chatbox")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Chatbox implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "nick_name")
    private String loginname;

    @Column(name = "message")
    private String message;

    @Column(name = "created")
    private String created;

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

    public Chatbox loginname(String loginname) {
        this.loginname = loginname;
        return this;
    }

    public void setLoginname(String loginname) {
        this.loginname = loginname;
    }

    public String getMessage() {
        return message;
    }

    public Chatbox message(String message) {
        this.message = message;
        return this;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getCreated() {
        return created;
    }

    public Chatbox created(String created) {
        this.created = created;
        return this;
    }

    public void setCreated(String created) {
        this.created = created;
    }
    // jhipster-needle-entity-add-getters-setters - JHipster will add getters and setters here

    @Override
    public boolean equals(Object o) {
        if (this == o) {
            return true;
        }
        if (!(o instanceof Chatbox)) {
            return false;
        }
        return id != null && id.equals(((Chatbox) o).id);
    }

    @Override
    public int hashCode() {
        return 31;
    }

    /**
	 * @param id
	 * @param loginname
	 * @param message
	 * @param created
	 */
	public Chatbox(WsChatDto input) {
		this.loginname = input.getU();
		this.message = input.getM();
		this.created = input.getDt();
	}

	/**
	 * 
	 */
	public Chatbox() {
	}

	// prettier-ignore
    @Override
    public String toString() {
        return "Chatbox{" +
            "id=" + getId() +
            ", loginname='" + getLoginname() + "'" +
            ", message='" + getMessage() + "'" +
            ", created='" + getCreated() + "'" +
            "}";
    }
}
