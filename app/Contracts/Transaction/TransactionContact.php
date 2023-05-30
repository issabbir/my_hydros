<?php
namespace App\Contracts\Transaction;

interface TransactionContact{

	public function get_temp_transaction_id();
	public function amount_from_selling_transaction($transaction_id);
	//public function  selling_transaction_update($transaction_id,$bank_transaction_id,$gateway_id);
	public function  transaction_master_completed($transaction_id,$bank_transaction_id,$gateway_id,$product_order_id,$amount);

}
