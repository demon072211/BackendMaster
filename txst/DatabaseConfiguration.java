package com.archie.config;

import javax.persistence.EntityManagerFactory;
import javax.sql.DataSource;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.boot.autoconfigure.jdbc.DataSourceProperties;
import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.boot.orm.jpa.EntityManagerFactoryBuilder;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Primary;
import org.springframework.context.annotation.Profile;
import org.springframework.data.jpa.repository.config.EnableJpaAuditing;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;
import org.springframework.orm.jpa.JpaTransactionManager;
import org.springframework.orm.jpa.LocalContainerEntityManagerFactoryBean;
import org.springframework.transaction.annotation.EnableTransactionManagement;

import com.archie.TxcbApp;

@Configuration
@EnableJpaRepositories("com.archie.repository")
@EnableJpaAuditing(auditorAwareRef = "springSecurityAuditorAware")
@EnableTransactionManagement
public class DatabaseConfiguration {

	@Bean
	@Primary
	@ConfigurationProperties("spring.datasource")
	public DataSourceProperties defaultDataSourceProperties() {
		return new DataSourceProperties();
	}

	@Bean
	@Primary
	@ConfigurationProperties("spring.datasource.hikari")
	public DataSource defaultDataSource() {
		return defaultDataSourceProperties().initializeDataSourceBuilder()
				// .type(HikariDataSource.class)
				.build();
	}

	@Bean(name = "entityManagerFactory")
	@Primary
	public LocalContainerEntityManagerFactoryBean customerEntityManagerFactory(EntityManagerFactoryBuilder builder) {
		return builder.dataSource(defaultDataSource()).packages(TxcbApp.class).persistenceUnit("default").build();
	}

	@Bean(name = "transactionManager")
	@Primary
	public JpaTransactionManager db2TransactionManager(
			@Qualifier("entityManagerFactory") final EntityManagerFactory emf) {
		JpaTransactionManager transactionManager = new JpaTransactionManager();
		transactionManager.setEntityManagerFactory(emf);
		return transactionManager;
	}
}
