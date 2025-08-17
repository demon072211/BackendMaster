package com.archie.entity;

import javax.annotation.Generated;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(TxRank.class)
public abstract class TxRank_ {

	public static volatile SingularAttribute<TxRank, Long> amount;
	public static volatile SingularAttribute<TxRank, String> loginname;
	public static volatile SingularAttribute<TxRank, Long> id;

	public static final String AMOUNT = "amount";
	public static final String LOGINNAME = "loginname";
	public static final String ID = "id";

}

