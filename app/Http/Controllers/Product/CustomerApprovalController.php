<?php

namespace App\Http\Controllers\Product;

use App\Entities\Product\CustomerTempRegistration;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerApprovalController extends Controller
{
    //

    public function pending_approval(Request $request)
    {
        $customers = CustomerTempRegistration::where('rejected_yn'  ,'=', YesNoFlag::NO)->get();

        return view('product.customer-pending-approval', [
            'customers' => $customers
        ]);
    }


    public function customer_approval_confirmation(Request $request,$id)
    {
        $response = $this->save_customer_approval($request,$id);
        return response()->json($response);
    }

    private function save_customer_approval($request,$customer_temp_id){
        $postData = $request->post();
        $procedure_name = 'CUSTOMER_APPROVAL';
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $customer_id = sprintf("%4000s","");
            $params = [
                'I_CUSTOMER_TEMP_ID' =>  $customer_temp_id,
                'I_USER_ID' => auth()->id(),
                'I_APPROVED_YN' => ($postData['approved_yn'] == YesNoFlag::YES) ? YesNoFlag::YES : YesNoFlag::NO,
                'I_REMARKS' => $postData['remarks'],
                'o_customer_id' =>&$customer_id,
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
