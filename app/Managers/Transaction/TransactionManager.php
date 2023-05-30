<?php
namespace App\Managers\Transaction;

use App\Contracts\Transaction\TransactionContact;

use App\Enums\YesNoFlag;
use App\Providers\RouteServiceProvider;
//Entities
use App\Entities\Transaction\TempTransaction;
use App\Entities\Transaction\SellingTransaction;
use Illuminate\Support\Facades\Auth;
/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\TransactionManager
 */
class TransactionManager implements TransactionContact
{


    private $temp_transaction;


    public function __construct()
    {
       $this->temp_transaction = new TempTransaction();
    }

	public function get_temp_transaction_id(){

        $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->user()->customer_id;
        $temp_transaction = $this->temp_transaction->where('customer_id','=',$customer_id)->first();
        $transaction_id = $temp_transaction->transaction_id;

        return $transaction_id;
    }

	public function amount_from_selling_transaction($transaction_id){


		$amount = \DB::select("SELECT SUM (PRICE) as total_price
              FROM PRODUCT_ORDER_DETAIL
             WHERE PRODUCT_ORDER_ID IN (SELECT PRODUCT_ORDER_ID
                                          FROM TEMP_TRANSACTION
                                         WHERE TRANSACTION_ID = ".$transaction_id.")")[0]->total_price;
		return $amount;
	}

    /**
     * Authorization Login process
     *
     * @param $transaction_id
     * @param $bank_transaction_id
     * @param $gateway_id
     * @return mixed
     *
     */

/*    public function selling_transaction_update($transaction_id,$bank_transaction_id,$gateway_id){
        $procedure_name = 'SELLING_TRANSACTION_UPDATE';

        try {
            $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->id();


            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_TRANSACTION_ID' => $transaction_id,
                'I_BANK_TRANSACTION_ID' => $bank_transaction_id,
                'I_GATEWAY_ID' => $gateway_id,
                'I_COMPLETED_YN' =>  YesNoFlag::NO ,
                'I_CUSTOMER_ID' => $customer_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }*/

    /*CREATE OR REPLACE PROCEDURE HYDROAS.TRANSACTION_MASTER_INSERT (
    I_TRANSACTION_ID        IN     NUMBER,
    I_BANK_TRANSACTION_ID   IN     VARCHAR2,
    I_GATEWAY_ID            IN     VARCHAR2,
                    IN     VARCHAR2,
          IN     NUMBER,
    I_CUSTOMER_ID           IN     NUMBER,

    O_STATUS_CODE              OUT NUMBER,
    O_STATUS_MESSAGE           OUT VARCHAR2)*/


    public function transaction_master_completed($transaction_id, $bank_transaction_id, $gateway_id,$product_order_id,$amount)
    {
        // TODO: Implement selling_transaction_completed() method.
        $procedure_name = 'TRANSACTION_MASTER_INSERT';

        try {
            $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->id();
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_TRANSACTION_ID' => $transaction_id,
                'I_BANK_TRANSACTION_ID' => $bank_transaction_id,
                'I_GATEWAY_ID' => $gateway_id,
                'I_AMOUNT' =>  $amount ,
                'I_PRODUCT_ORDER_ID' =>  $product_order_id ,
                'I_CUSTOMER_ID' => $customer_id,
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;

    }
}
