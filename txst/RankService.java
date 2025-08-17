package com.archie.service;

import java.util.List;

import com.archie.entity.TxRank;

public interface RankService {
	List<TxRank> getTopTxRank();
	
	void insertRank(TxRank rank); 
}
