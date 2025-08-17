package com.archie.config;

import java.util.Arrays;
import java.util.Collection;
import java.util.Properties;

import javax.annotation.PostConstruct;
import javax.persistence.EntityManagerFactory;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.boot.autoconfigure.domain.EntityScan;
import org.springframework.boot.autoconfigure.jdbc.DataSourceProperties;
import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.boot.orm.jpa.EntityManagerFactoryBuilder;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.env.MapPropertySource;
import org.springframework.core.env.PropertySource;
import org.springframework.core.env.StandardEnvironment;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;
import org.springframework.orm.jpa.JpaTransactionManager;
import org.springframework.orm.jpa.LocalContainerEntityManagerFactoryBean;
import org.springframework.transaction.annotation.EnableTransactionManagement;

import com.zaxxer.hikari.HikariDataSource;

import io.github.jhipster.config.JHipsterConstants;

@Configuration
@EnableTransactionManagement
@EntityScan(basePackages = "com.archie.entity")
@EnableJpaRepositories(transactionManagerRef = "partnerTransactionManager", entityManagerFactoryRef = "partnerEntityManagerFactory", basePackages = "com.archie.dao")
public class PartnerDbConfig {
	private final StandardEnvironment env;
	private static final String PARTNER_CONFIGURATION_HIKARI_PREFIX = "partner.datasource.hikari";
	private static final String PARTNER_CONFIGURATION_PREFIX = "partner.datasource";

	@Autowired
	public PartnerDbConfig(StandardEnvironment env) {
		this.env = env;
	}

	private static Boolean isProd;
	private static Properties sysProperties = new Properties();

	@PostConstruct
	public void setupProperties() {
		Collection<String> activeProfiles = Arrays.asList(env.getActiveProfiles());
		if (activeProfiles.contains(JHipsterConstants.SPRING_PROFILE_DEVELOPMENT)
				|| activeProfiles.contains(JHipsterConstants.SPRING_PROFILE_SWAGGER)) {
			isProd = false;
		}
		if (activeProfiles.contains(JHipsterConstants.SPRING_PROFILE_PRODUCTION)) {
			isProd = true;
		}
		for (PropertySource<?> propertySource : env.getPropertySources()) {
			if (propertySource instanceof MapPropertySource) {
				final String propertySourceName = propertySource.getName();
				String comparitionStr = "applicationConfig: [classpath:/config/application-dev.yml]";
				if (isProd == true) {
					comparitionStr = "applicationConfig: [classpath:/config/application-prod.yml]";
				}
				if (propertySourceName.startsWith(comparitionStr)) {
					MapPropertySource mapPropertySource = (MapPropertySource) propertySource;
					for (String key : mapPropertySource.getPropertyNames()) {
						if (key.startsWith("spring.jpa")) {
							Object value = mapPropertySource.getProperty(key);
							sysProperties.put(key, value);
						}
					}
				}
			}
		}
	}

	@Bean
	@ConfigurationProperties(PARTNER_CONFIGURATION_PREFIX)
	public DataSourceProperties SyncDataSourceProperties() {
		return new DataSourceProperties();
	}

	@Bean
	@ConfigurationProperties(PARTNER_CONFIGURATION_HIKARI_PREFIX)
	public HikariDataSource partnerDataSource() {
		return SyncDataSourceProperties().initializeDataSourceBuilder().type(HikariDataSource.class).build();
	}

	@Bean(name = "partnerEntityManagerFactory")
	public LocalContainerEntityManagerFactoryBean customerEntityManagerFactory(EntityManagerFactoryBuilder builder) {
		LocalContainerEntityManagerFactoryBean emf = builder.dataSource(partnerDataSource())
				.packages("com.archie.entity").persistenceUnit("partner").build();

		emf.setJpaProperties(sysProperties);
		return emf;
	}

	@Bean(name = "partnerTransactionManager")
	public JpaTransactionManager db2TransactionManager(
			@Qualifier("partnerEntityManagerFactory") final EntityManagerFactory emf) {
		JpaTransactionManager transactionManager = new JpaTransactionManager();
		transactionManager.setEntityManagerFactory(emf);
		return transactionManager;
	}

}
