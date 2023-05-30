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

class EbsClass
{

    public $id;
    public $links;

    /**
     * @return mixed
     */
    public static function menuSetup()
    {
        if (Auth::user()->hasGrantAll()) {
            $moduleId = ModuleInfo::EBS_MODULE_ID;
            $menus = Menu::where('module_id', $moduleId)->orderBy('menu_order_no')->get();

            return $menus;
        } else {
            $allMenus = Auth::user()->getRoleMenus();
            $menus = [];

            if($allMenus) {
                foreach($allMenus as $menu) {
                    if($menu->module_id == ModuleInfo::EBS_MODULE_ID) {
                        $menus[] = $menu;
                    }
                }
            }

            return $menus;
        };
    }

    public static function getActiveRouteNameWrapping($routeName)
    {
        if (in_array($routeName, ['setup.zone-area-edit'])) {
            return 'setup.zone-area-index';
        } else if (in_array($routeName, ['setup.team-edit'])) {
            return 'setup.team-index';
        } else if (in_array($routeName, ['setup.schedule-type-edit'])) {
            return 'setup.schedule-type-index';
        } else if (in_array($routeName, ['schedule.schedule-edit'])) {
            return 'schedule.schedule-index';
        } else if (in_array($routeName, ['schedule.schedule-approval-edit'])) {
            return 'schedule.schedule-approval-index';
        } else if (in_array($routeName, ['others.fuel-oil-requisition-post'])) {
            return 'others.fuel-oil-requisition-index';
        } else if (in_array($routeName, ['setup.file-category-edit'])) {
            return 'setup.file-category-index';
        } else if (in_array($routeName, ['setup.product-edit'])) {
            return 'setup.product-index';
        }  else if (in_array($routeName, ['setup.product-format-edit'])) {
            return 'setup.product-format-index';
        }  else if (in_array($routeName, ['product.product-order-detail'])) {
            return 'product.product-upload-index';
        } else if (in_array($routeName, ['schedule.duty-roster-employee'])) {
            return 'schedule.duty-roster-index';
        } else if (in_array($routeName, ['schedule.shift-setup-edit'])) {
            return 'schedule.shift-setup-index';
        }

        else if (in_array($routeName, ['schedule.duty-roster-calender','schedule.duty-roster-calender-boat'])) {
            return 'schedule.duty-roster-index';
        }

        else if (in_array($routeName, ['schedule.duty-roster-approval-save'])) {
            return 'schedule.duty-roster-approval-index';
        }

        else if (in_array($routeName, ['file.file-upload-post'])) {
            return 'file.file-upload-index';
        }

        else if (in_array($routeName, ['file.archive-search-post'])) {
            return 'file.archive-search-index';
        }
        else if (in_array($routeName, ['dashboard'])) {
            return 'dashboard-index';
        }

        else {
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
