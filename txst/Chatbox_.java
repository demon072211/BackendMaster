package com.archie.entity;

import javax.annotation.Generated;
import javax.persistence.metamodel.SingularAttribute;
import javax.persistence.metamodel.StaticMetamodel;

@Generated(value = "org.hibernate.jpamodelgen.JPAMetaModelEntityProcessor")
@StaticMetamodel(Chatbox.class)
public abstract class Chatbox_ {

	public static volatile SingularAttribute<Chatbox, String> loginname;
	public static volatile SingularAttribute<Chatbox, String> created;
	public static volatile SingularAttribute<Chatbox, Long> id;
	public static volatile SingularAttribute<Chatbox, String> message;

	public static final String LOGINNAME = "loginname";
	public static final String CREATED = "created";
	public static final String ID = "id";
	public static final String MESSAGE = "message";

}

