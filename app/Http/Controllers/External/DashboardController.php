<?php

namespace App\Http\Controllers\External;

use App\Entities\Product\Product;
use App\Entities\Setup\LFileFormat;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {


        $products = DB::select("SELECT P.* , FI.*,
(
SELECT COUNT(*)
FROM PRODUCT_DETAIL PD
INNER JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
where  PD.ACTIVE_YN = 'Y'
AND PD.PRODUCT_ID = P.PRODUCT_ID
) as FORMAT_AVAILABLE,
(
SELECT MIN(PD.PRICE)
FROM PRODUCT_DETAIL PD
INNER JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
where  PD.ACTIVE_YN = 'Y'
AND PD.PRODUCT_ID = P.PRODUCT_ID
) MIN_PRICE
FROM PRODUCT P
LEFT JOIN FILE_INFO FI
ON P.FILE_INFO_ID = FI.FILE_INFO_ID
WHERE P.ACTIVE_YN = 'Y'
");
       // $products = Product::with(['file_category'])->where('active_yn','=',YesNoFlag::YES)->get();
        return view('external.dashboard',[
            "products" => $products,
            "fileFormats" => LFileFormat::with([])->get()
        ]);
    }

    public function dashboard_search(Request $request)
    {

        $search_param = $request->get('searchItem');

        $products = DB::select("SELECT P.* , FI.*,
(
SELECT COUNT(*)
FROM PRODUCT_DETAIL PD
INNER JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
where  PD.ACTIVE_YN = 'Y'
AND PD.PRODUCT_ID = P.PRODUCT_ID
) as FORMAT_AVAILABLE,
(
SELECT MIN(PD.PRICE)
FROM PRODUCT_DETAIL PD
INNER JOIN L_FILE_FORMAT FF
ON PD.FILE_FORMAT_ID = FF.FILE_FORMAT_ID
where  PD.ACTIVE_YN = 'Y'
AND PD.PRODUCT_ID = P.PRODUCT_ID
) MIN_PRICE
FROM PRODUCT P
LEFT JOIN FILE_INFO FI
ON P.FILE_INFO_ID = FI.FILE_INFO_ID
WHERE P.ACTIVE_YN = 'Y' AND   LOWER(P.NAME) LIKE  '%$search_param%'
");
        // $products = Product::with(['file_category'])->where('active_yn','=',YesNoFlag::YES)->get();
        return view('external.dashboard',[
            "products" => $products,
            "fileFormats" => LFileFormat::with([])->get()
        ]);
    }

}
