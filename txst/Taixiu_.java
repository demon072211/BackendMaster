package com.archie.entity;

import java.time.LocalDateTime;
import javax.annotation.Generated;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(Taixiu.class)
public abstract class Taixiu_ {

	public static volatile SingularAttribute<Taixiu, String> result;
	public static volatile SingularAttribute<Taixiu, LocalDateTime> endtime;
	public static volatile SingularAttribute<Taixiu, Long> id;
	public static volatile SingularAttribute<Taixiu, LocalDateTime> opentime;
	public static volatile SingularAttribute<Taixiu, Long> resultAmount;
	public static volatile SingularAttribute<Taixiu, Long> twin;
	public static volatile SingularAttribute<Taixiu, Integer> status;

	public static final String RESULT = "result";
	public static final String ENDTIME = "endtime";
	public static final String ID = "id";
	public static final String OPENTIME = "opentime";
	public static final String RESULT_AMOUNT = "resultAmount";
	public static final String TWIN = "twin";
	public static final String STATUS = "status";

}

