<?php

namespace App\Http\Controllers\Others;

use App\Entities\Setup\Vehicle;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CraftProfileController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::with("vehicle_type")->where('active_yn', '=', YesNoFlag::YES)->get();

        return view('others.craft-profile-index', [
            'vehicles' => $vehicles,
        ]);
    }
}
