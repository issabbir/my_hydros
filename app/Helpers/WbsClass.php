<?php
//app/Helpers/ImsClass.php
namespace App\Helpers;

use App\Entities\Admin\LGeoDistrict;
use App\Entities\Security\Menu;
use App\Enums\ModuleInfo;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class WbsClass
{

    public $id;
    public $links;

    /**
     * @return mixed
     */
    public static function menuSetup()
    {
        if (Auth::user()->hasGrantAll()) {
            $moduleId = ModuleInfo::WBS_MODULE_ID;
            $menus = Menu::where('module_id', $moduleId)->orderBy('menu_order_no')->get();

            return $menus;
        } else {
            $allMenus = Auth::user()->getRoleMenus();
            $menus = [];

            if($allMenus) {
                foreach($allMenus as $menu) {
                    if($menu->module_id == ModuleInfo::WBS_MODULE_ID) {
                        $menus[] = $menu;
                    }
                }
            }

            return $menus;
        };
    }

    public static function getActiveRouteNameWrapping($routeName)
    {

        if (in_array($routeName, ['water-vessel-edit'])) {
            return 'water-vessel-index';
        } else if (in_array($routeName, ['water-delivery-area-edit'])) {
            return 'water-delivery-area-index';
        } else if (in_array($routeName, ['water-rate-chart-edit'])) {
            return 'water-rate-chart-index';
        } else if (in_array($routeName, ['water-requisition-edit'])) {
            return 'water-requisition-index';
        } else if (in_array($routeName, ['water-booking-edit'])) {
            return 'water-booking-index';
        } else if (in_array($routeName, ['water-assign-medium-edit'])) {
            return 'water-assign-medium-index';
        } else if (in_array($routeName, ['water-acknowledgement-edit'])) {
            return 'water-acknowledgement-index';
        } else if (in_array($routeName, ['water-bill-preparation-edit'])) {
            return 'water-bill-preparation-index';
        } else if (in_array($routeName, ['water-invoice-status-edit'])) {
            return 'water-invoice-status-index';
        } else {
            return [
                [
                    'submenu_name' => $routeName,
                ]
            ];
        }
    }

    public static function activeMenus($routeName)
    {
        //$menus = [];
        try {
            $authorizationManager = new AuthorizationManager();
            $menus[] = $getRouteMenuId = $authorizationManager->findSubMenuId(self::getActiveRouteNameWrapping($routeName));

            if ($getRouteMenuId && !empty($getRouteMenuId)) {
                $bm = $authorizationManager->findParentMenu($getRouteMenuId);
                $menus[] = $bm['parent_submenu_id'];
                if ($bm && isset($bm['parent_submenu_id']) && !empty($bm['parent_submenu_id'])) {
                    $m = $authorizationManager->findParentMenu($bm['parent_submenu_id']);
                    if (!empty($m['submenu_id'])) {
                        $menus[] = $m['submenu_id'];
                    }
                }
            }
        } catch (\Exception $e) {
            $menus = [];
        }
        return is_array($menus) ? $menus : false;
    }

    public static function hasChildMenu($routeName)
    {
        $authorizationManager = new AuthorizationManager();
        $getRouteMenuId = $authorizationManager->findSubMenuId($routeName);
        return $authorizationManager->hasChildMenu($getRouteMenuId);
    }
}
