package com.archie.entity;

import org.hibernate.annotations.Cache;
import org.hibernate.annotations.CacheConcurrencyStrategy;

import javax.persistence.*;

import java.io.Serializable;
import java.time.LocalDateTime;

/**
 * A Taixiu.
 */
@Entity
@Table(name = "taixiu")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Taixiu implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(name = "opentime")
    private LocalDateTime opentime;

    @Column(name = "endtime")
    private LocalDateTime endtime;

    @Column(name = "status")
    private Integer status;

    @Column(name = "result")
    private String result;

    @Column(name = "result_amount")
    private Long resultAmount;

    @Column(name = "twin")
    private Long twin;

    // jhipster-needle-entity-add-field - JHipster will add fields here
    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public LocalDateTime getOpentime() {
        return opentime;
    }

    public Taixiu opentime(LocalDateTime opentime) {
        this.opentime = opentime;
        return this;
    }

    public void setOpentime(LocalDateTime opentime) {
        this.opentime = opentime;
    }

    public LocalDateTime getEndtime() {
        return endtime;
    }

    public Taixiu endtime(LocalDateTime endtime) {
        this.endtime = endtime;
        return this;
    }

    public void setEndtime(LocalDateTime endtime) {
        this.endtime = endtime;
    }

    public Integer getStatus() {
        return status;
    }

    public Taixiu status(Integer status) {
        this.status = status;
        return this;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    public String getResult() {
        return result;
    }

    public Taixiu result(String result) {
        this.result = result;
        return this;
    }

    public void setResult(String result) {
        this.result = result;
    }

    public Long getResultAmount() {
        return resultAmount;
    }

    public Taixiu resultAmount(Long resultAmount) {
        this.resultAmount = resultAmount;
        return this;
    }

    public void setResultAmount(Long resultAmount) {
        this.resultAmount = resultAmount;
    }

    public Long getTwin() {
        return twin;
    }

    public Taixiu twin(Long twin) {
        this.twin = twin;
        return this;
    }

    public void setTwin(Long twin) {
        this.twin = twin;
    }
    // jhipster-needle-entity-add-getters-setters - JHipster will add getters and setters here

    @Override
    public boolean equals(Object o) {
        if (this == o) {
            return true;
        }
        if (!(o instanceof Taixiu)) {
            return false;
        }
        return id != null && id.equals(((Taixiu) o).id);
    }

    @Override
    public int hashCode() {
        return 31;
    }

    // prettier-ignore
    @Override
    public String toString() {
        return "Taixiu{" +
            "id=" + getId() +
            ", opentime='" + getOpentime() + "'" +
            ", endtime='" + getEndtime() + "'" +
            ", status=" + getStatus() +
            ", result='" + getResult() + "'" +
            ", resultAmount=" + getResultAmount() +
            ", twin=" + getTwin() +
            "}";
    }
}
