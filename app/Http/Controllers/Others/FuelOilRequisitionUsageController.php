<?php

namespace App\Http\Controllers\Others;

use App\Entities\Security\Menu;
use App\Entities\Security\Submenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FuelOilRequisitionUsageController extends Controller
{
    public function index(Request $request)
    {
        $url = Menu::where('menu_id', 29)
            ->where('module_id', 35)
            ->first()
            ->base_url;

        $route = Submenu::where('submenu_id', 1293)
            ->first()
            ->route_name;
        $route = $route.'?ref_module=2';

        return view('others.fuel-oil-requisition-usage-index', compact('url', 'route'));
    }
}
