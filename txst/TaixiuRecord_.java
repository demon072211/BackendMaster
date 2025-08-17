package com.archie.entity;

import java.time.LocalDateTime;
import javax.annotation.Generated;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(TaixiuRecord.class)
public abstract class TaixiuRecord_ {

	public static volatile SingularAttribute<TaixiuRecord, String> loginname;
	public static volatile SingularAttribute<TaixiuRecord, Long> winamount;
	public static volatile SingularAttribute<TaixiuRecord, String> ip;
	public static volatile SingularAttribute<TaixiuRecord, String> description;
	public static volatile SingularAttribute<TaixiuRecord, LocalDateTime> bettime;
	public static volatile SingularAttribute<TaixiuRecord, String> result;
	public static volatile SingularAttribute<TaixiuRecord, Integer> typed;
	public static volatile SingularAttribute<TaixiuRecord, Long> refundamount;
	public static volatile SingularAttribute<TaixiuRecord, Long> id;
	public static volatile SingularAttribute<TaixiuRecord, Integer> userType;
	public static volatile SingularAttribute<TaixiuRecord, Long> taixiuId;
	public static volatile SingularAttribute<TaixiuRecord, Long> betamount;
	public static volatile SingularAttribute<TaixiuRecord, Integer> status;

	public static final String LOGINNAME = "loginname";
	public static final String WINAMOUNT = "winamount";
	public static final String IP = "ip";
	public static final String DESCRIPTION = "description";
	public static final String BETTIME = "bettime";
	public static final String RESULT = "result";
	public static final String TYPED = "typed";
	public static final String REFUNDAMOUNT = "refundamount";
	public static final String ID = "id";
	public static final String USER_TYPE = "userType";
	public static final String TAIXIU_ID = "taixiuId";
	public static final String BETAMOUNT = "betamount";
	public static final String STATUS = "status";

}

