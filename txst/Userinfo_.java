package com.archie.domain;

import javax.annotation.Generated;
import javax.persistence.metamodel.SetAttribute;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(Userinfo.class)
public abstract class Userinfo_ {

	public static volatile SingularAttribute<Userinfo, Double> balance;
	public static volatile SingularAttribute<Userinfo, String> loginname;
	public static volatile SingularAttribute<Userinfo, String> nickName;
	public static volatile SingularAttribute<Userinfo, Long> id;
	public static volatile SingularAttribute<Userinfo, String> pwd;
	public static volatile SetAttribute<Userinfo, Authority> authorities;

	public static final String BALANCE = "balance";
	public static final String LOGINNAME = "loginname";
	public static final String NICK_NAME = "nickName";
	public static final String ID = "id";
	public static final String PWD = "pwd";
	public static final String AUTHORITIES = "authorities";

}

