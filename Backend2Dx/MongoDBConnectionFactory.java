/*
 * Decompiled with CFR 0.144.
 * 
 * Could not load the following classes:
 *  com.mongodb.MongoClient
 *  com.mongodb.MongoCredential
 *  com.mongodb.ServerAddress
 *  com.mongodb.client.MongoDatabase
 */
package com.vinplay.vbee.common.mongodb;

import com.mongodb.MongoClient;
import com.mongodb.MongoCredential;
import com.mongodb.ServerAddress;
import com.mongodb.client.MongoDatabase;
import com.vinplay.vbee.common.config.VBeePath;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Arrays;
import java.util.Properties;

public class MongoDBConnectionFactory {
    private static String MONGODB_HOST = "localhost";
    private static String MONGODB_DATABASE = "vinplay";
    private static String MONGODB_AUTH_DATABASE = "admin";
    private static String MONGODB_USERNAME = "vinplay";
    private static String MONGODB_PASSWORD = "vinplay@123";
    private static int MONGODB_PORT = 27017;
    private static MongoClient mongoClient;

    public static void init() throws IOException {
        Properties prop = new Properties();
        FileInputStream input = new FileInputStream(VBeePath.basePath.concat("config/mongo.properties"));
        prop.load(input);
        MONGODB_HOST = prop.getProperty("host");
        MONGODB_DATABASE = prop.getProperty("database");
        MONGODB_AUTH_DATABASE = prop.getProperty("auth_database");
        MONGODB_PORT = Integer.parseInt(prop.getProperty("port"));
        MONGODB_USERNAME = prop.getProperty("username");
        MONGODB_PASSWORD = prop.getProperty("password");
        MongoDBConnectionFactory.newConnection();
    }

    public static void newConnection() {
        MongoCredential credential = MongoCredential.createCredential((String)MONGODB_USERNAME, (String)MONGODB_AUTH_DATABASE, (char[])MONGODB_PASSWORD.toCharArray());
        mongoClient = new MongoClient(new ServerAddress(MONGODB_HOST, MONGODB_PORT), Arrays.asList(new MongoCredential[]{credential}));
    }

    public static MongoDatabase getDB() {
        if (mongoClient == null) {
            MongoDBConnectionFactory.newConnection();
        }
        return mongoClient.getDatabase(MONGODB_DATABASE);
    }
}

