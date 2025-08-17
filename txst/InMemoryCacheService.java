/**
 * 
 */
package com.archie.service;

/**
 * @author Archie
 * @date Sep 18, 2020
 */
public interface InMemoryCacheService<K, T> {
	public void put(K key, T value);

	public T get(K key);

	public void remove(K key);

	public int size();

	public void cleanup();
}
