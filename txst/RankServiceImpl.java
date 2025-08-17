package com.archie.service.impl;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;
import java.util.concurrent.CopyOnWriteArrayList;

import org.springframework.scheduling.annotation.Async;
import org.springframework.stereotype.Service;
import com.archie.entity.TxRank;
import com.archie.hazelcast.HazelcastClientFactory;
import com.archie.service.RankService;
import com.hazelcast.core.HazelcastInstance;
import com.hazelcast.core.IMap;

@Service
public class RankServiceImpl implements RankService {

	private static List<TxRank> topTx = new CopyOnWriteArrayList<TxRank>();
	
	private static final int MAXSIZE = 10;
	
	private static final String KEY ="RANK_TXST";
	
	public void init() {
		if (topTx == null || topTx.isEmpty()) {
			HazelcastInstance instance =null;
			try {
				instance = HazelcastClientFactory.getInstance();
			} catch (Exception e) {
				return;
			}
//			HazelcastInstance instance = HazelcastClientFactory.getInstance();
			IMap<String, List<TxRank>> rankCache = instance.getMap("cacheRankingTxst");
			// key =nickname , value = amount
			if (rankCache != null && !rankCache.isEmpty()) {
				if (rankCache.containsKey(KEY)) {
					List<TxRank> lstData = rankCache.get(KEY);
					if (lstData != null && !lstData.isEmpty()) {
						topTx.addAll(lstData);
					}
				}
			}
		}
	}
	
	@Override
	public List<TxRank> getTopTxRank() {
		init();
		return new ArrayList<>(topTx);
	}
	
	@Override
	@Async("taskStealingPool")
	public void insertRank(TxRank rank) {
		init();
		if (rank != null && rank.getAmount() > 0) {
			boolean isChange = false;
			long val = rank.getAmount();
			int size = topTx.size();
			if (size == 0) {
				topTx.add(rank);
			}else if (size <MAXSIZE) {
				//
				if(topTx.contains(rank)) {
					int index = topTx.indexOf(rank);
					TxRank ra = topTx.get(index);
					rank.setAmount(rank.getAmount() + ra.getAmount());
					topTx.set(index, rank);
				}else {
					topTx.add(rank);
				}
				
				Collections.sort(topTx, new Comparator<TxRank>() {
					@Override
					public int compare(TxRank s1, TxRank s2) {
						return (int)(s2.getAmount() - s1.getAmount());
					}
				});
				isChange = true;
			} else {
				if(topTx.contains(rank)) {
					int index = topTx.indexOf(rank);
					TxRank ra = topTx.get(index);
					rank.setAmount(rank.getAmount() + ra.getAmount());

					Collections.sort(topTx, new Comparator<TxRank>() {
						@Override
						public int compare(TxRank s1, TxRank s2) {
							return (int)(s2.getAmount() - s1.getAmount());
						}
					});
					isChange = true;
				}else {
					int i = 0;
					while (i<MAXSIZE) {
						if(topTx.get(i).getAmount() <= val) {
							topTx.add(i, rank);
							topTx.remove(topTx.size()-1);
							isChange = true;
							break;
						}
						i++;
					}
				}
				
			}
			if (topTx.size() == 10 && isChange) {
				HazelcastInstance instance = HazelcastClientFactory.getInstance();
				IMap<String, List<TxRank>> rankCache = instance.getMap("cacheRankingTxst");
				if (rankCache != null && !rankCache.isEmpty()) {
					if (rankCache.containsKey(KEY)) {
						rankCache.set(KEY, topTx);
					}
				}
			}
		}

	}

//	public static void main(String[] args) {
//		TxRank x1 = new TxRank("x1", 10l);
//		TxRank x2 = new TxRank("x2", 11l);
//		TxRank x3 = new TxRank("x3", 12l);
//		TxRank x4 = new TxRank("x4", 15l);
//		TxRank x5 = new TxRank("x5", 11l);
//		TxRank x10 = new TxRank("x10", 11l);
//		TxRank x20 = new TxRank("x20", 17l);
//		TxRank x30 = new TxRank("x30", 14l);
//		TxRank x40 = new TxRank("x40", 13l);
//		TxRank x50 = new TxRank("x50", 16l);
//		TxRank x60 = new TxRank("x50", 99l);
//		topTx.add(x1);
//		topTx.add(x2);
//		topTx.add(x3);
//		topTx.add(x4);
//		topTx.add(x5);
//		RankServiceImpl rrr = new RankServiceImpl();
//		rrr.insertRank(x1);
//		rrr.insertRank(x2);
//		rrr.insertRank(x3);
//		rrr.insertRank(x4);
//		rrr.insertRank(x5);
//		rrr.insertRank(x10);
//		rrr.insertRank(x20);
//		rrr.insertRank(x30);
//		rrr.insertRank(x40);
//		rrr.insertRank(x50);//10
//		rrr.insertRank(x60);
//		rrr.insertRank(x60);
//		rrr.insertRank(x50);rrr.insertRank(x1);
//		System.out.println(topTx.toString());
//		System.out.println(topTx.size());
//	}
}
