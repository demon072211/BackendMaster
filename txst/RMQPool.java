package com.archie.rabbitmq;

import java.io.IOException;
import java.util.concurrent.TimeoutException;

import com.rabbitmq.client.Channel;
import com.rabbitmq.client.Connection;

public class RMQPool {
    private Connection connection = RMQConnectionFactory.newConnection();
    private static RMQPool instance;

    private RMQPool() throws IOException, TimeoutException {
    }

    public static RMQPool getInstance() throws IOException, TimeoutException {
        if (instance == null) {
            instance = new RMQPool();
        }
        return instance;
    }

    public Channel getChannel(String queueName) throws IOException {
        Channel channel = this.connection.createChannel();
        channel.queueDeclare(queueName, true, false, false, null);
        return channel;
    }

    public void releaseChannel(Channel channel) throws InterruptedException, IOException, TimeoutException {
        channel.close();
    }
}

