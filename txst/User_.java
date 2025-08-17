package com.archie.domain;

import javax.annotation.Generated;
import javax.persistence.metamodel.SetAttribute;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(User.class)
public abstract class User_ {

	public static volatile SingularAttribute<User, Long> minAmount;
	public static volatile SingularAttribute<User, String> password;
	public static volatile SingularAttribute<User, String> langKey;
	public static volatile SingularAttribute<User, String> fullName;
	public static volatile SingularAttribute<User, Long> id;
	public static volatile SingularAttribute<User, Double> totalWinAmount;
	public static volatile SingularAttribute<User, String> login;
	public static volatile SingularAttribute<User, Long> maxAmount;
	public static volatile SetAttribute<User, Authority> authorities;
	public static volatile SingularAttribute<User, Boolean> activated;

	public static final String MIN_AMOUNT = "minAmount";
	public static final String PASSWORD = "password";
	public static final String LANG_KEY = "langKey";
	public static final String FULL_NAME = "fullName";
	public static final String ID = "id";
	public static final String TOTAL_WIN_AMOUNT = "totalWinAmount";
	public static final String LOGIN = "login";
	public static final String MAX_AMOUNT = "maxAmount";
	public static final String AUTHORITIES = "authorities";
	public static final String ACTIVATED = "activated";

}

