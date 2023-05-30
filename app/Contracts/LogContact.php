<?php
namespace App\Contracts;

interface LogContact{
    public function save_sms_log($customer_id,$employee_id,$mobile_number, $src_id ,$sms_content, $raw_data);
    public function save_system_log($customer_id,$employee_id,$mobile_number, $src_id ,$sms_content, $raw_data);
    public function save_payment_log($transaction_id,$src_name,$completed_yn,$raw_data);
}
