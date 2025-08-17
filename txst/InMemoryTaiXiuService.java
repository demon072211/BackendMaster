/**
 * 
 */
package com.archie.service;

import java.util.List;
import java.util.Map;
import java.util.concurrent.CompletableFuture;

import com.archie.service.dto.TaiXiuBetDTO;

/**
 * @author Archie
 * @date Oct 10, 2020
 */
public interface InMemoryTaiXiuService {
	// real
	public List<TaiXiuBetDTO> getList();

	public void addToList(TaiXiuBetDTO obj , int check);

	public void addBot(TaiXiuBetDTO obj);

	public void addBot(long id, long amount);

	public void addBot(long id, long amount, int type);
	
	public void addBot(long id, long amount, int type , boolean isChoose);

	public void addBot10s(long id, int type, long amount);

	public void addBot20s(long id, int type, long amount);

	public void addBot35s(long id, int type, long amount);

	public void addBot45s(long id, int type, long amount);

	public void addBot50s(long id, int type, long amount);

	void addAmountTai(long amount);

	void addAmountXiu(long amount);

	void reset();

	long size();

	long[] getQuantity1s();

	// Map<String,Map<String, Long>> winloseData(int resultType);

	void winloseData(int resultType ,int[] result);
	
//	Map<String,Long> refundMoney(int resultType ,String resultStr, long amount);
	
	int isValidBet(String loginname, int typed);
	
	public void addMultipleBot(int numBotTai, int numBotXiu, long id, long amountTai, long amountXiu , boolean isChoose);
	
	public Map<String,String> getUserAmount();

}
