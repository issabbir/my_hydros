<?php
namespace App\Managers;

use App\Contracts\HttpContact;
use App\Contracts\LogContact;
use App\Enums\ModuleInfo;
use App\Enums\NotificationType;
use App\Enums\ProjectModule;
use App\Enums\YesNoFlag;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Auth;


/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\HttpManager
 */
class LogManager implements LogContact
{


    public function save_system_log($customer_id,$employee_id,$mobile_number, $src_id ,$sms_content, $raw_data)
    {
        // TODO: Implement save_sms_log() method.

        $raw_data_str = json_encode( $raw_data, JSON_UNESCAPED_SLASHES);

        $procedure_name = 'SYSTEM_LOG_INSERT';

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_EMPLOYEE_ID' => $employee_id,
                'I_CUSTOMER_ID' => $customer_id,
                'I_SRC_ID' => $src_id,
                'I_SRC_NAME' => $sms_content,
                'I_RAW_DATA' => [
                    'value' => $raw_data_str,
                    'type'  => \PDO::PARAM_STR,
                    'length'  => strlen($raw_data_str)
                ],
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];

            \DB::executeProcedure($procedure_name, $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }

    public function save_payment_log($transaction_id,$src_name,$completed_yn,$raw_data)
    {
        // TODO: Implement save_payment_log() method.

        $procedure_name = 'PAYMENT_LOG_INSERT';

        $raw_data_str = json_encode( $raw_data, JSON_UNESCAPED_SLASHES);

        try {
            $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->id();

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_CUSTOMER_ID' => $customer_id,
                'I_TRANSACTION_ID' => $transaction_id,
                'I_SRC_NAME' => $src_name,
                'I_TRANSACTION_COMPLETED_YN' =>  $completed_yn ,
                'I_RAW_DATA' => [
                    'value' => $raw_data_str,
                    'type'  => \PDO::PARAM_STR,
                    'length'  => strlen($raw_data_str)
                ],
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

    /*CREATE OR REPLACE PROCEDURE HYDROAS.NOTIFICATION_LOG_INSERT (
    I_NOTIFICATION_TYPE_ID   IN     NUMBER,
    I_EMP_ID                 IN     NUMBER,

                  IN     NUMBER,
       IN     VARCHAR2,
    I_GATEWAY_RAW_DATA       IN     CLOB,
    I_USER_ID                IN     NUMBER,
    O_STATUS_CODE               OUT NUMBER,
    O_STATUS_MESSAGE            OUT VARCHAR2)*/
    public function save_sms_log($customer_id, $employee_id, $mobile_number, $src_id, $sms_content, $raw_data)
    {
        // TODO: Implement save_sms_log() method.

        $procedure_name = 'NOTIFICATION_LOG_INSERT';

        $raw_data_str = json_encode( $raw_data, JSON_UNESCAPED_SLASHES);

        try {
            $customer_id = Auth::guard(RouteServiceProvider::EXTERNAL_GUARD)->id();

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [
                'I_NOTIFICATION_TYPE_ID' => NotificationType::SMS,
                'I_EMP_ID' => $customer_id,
                'I_MODULE_ID' => ProjectModule::SURVEY_SCHEDULE_ID,
                'I_NOTIFICATION_MESSAGE' => $sms_content,
                'I_GATEWAY_RAW_DATA' => [
                    'value' => $raw_data_str,
                    'type'  => \PDO::PARAM_STR,
                    'length'  => strlen($raw_data_str)
                ],
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
