<?php
//app/Helpers/HelperClass.php
namespace App\Helpers;

use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoThana;
use App\Entities\Ams\LPriorityType;
use App\Entities\Ams\OperatorMapping;
use App\Entities\Security\Menu;
use App\Enums\Secdbms\Watchman\AppointmentType;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HelperClass
{

    public $id;
    public $links;

    public static function breadCrumbs($routeName)
    {
        if (in_array($routeName, ['setup.zone-area-edit'])) {
            return [
                ['submenu_name' => 'Schedule Setup', 'action_name' => ''],
                ['submenu_name' => ' Zone Area', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['setup.team-edit'])) {
            return [
                ['submenu_name' => 'Schedule Setup', 'action_name' => ''],
                ['submenu_name' => ' Team', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['setup.schedule-type-edit'])) {
            return [
                ['submenu_name' => 'Schedule Setup', 'action_name' => ''],
                ['submenu_name' => ' Schedule Type Edit', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['schedule.schedule-edit'])) {
            return [
                ['submenu_name' => 'Schedule Setup', 'action_name' => ''],
                ['submenu_name' => ' Schedule Edit', 'action_name' => '']
            ];
        }else if (in_array($routeName, ['schedule.duty-roster-calender-boat'])) {
            return [
                ['submenu_name' => 'Duty Roaster Setup', 'action_name' => ''],
                ['submenu_name' => ' Duty Roaster Edit', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['schedule.schedule-approval-edit'])) {
            return [
                ['submenu_name' => 'Schedule Approval', 'action_name' => ''],
                ['submenu_name' => ' Schedule Approval Confirmation', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['others.fuel-oil-requisition-post'])) {
            return [
                ['submenu_name' => ' Fuel oil requisition', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['setup.file-category-edit'])) {
            return [
                ['submenu_name' => ' File category edit', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['setup.product-edit'])) {
            return [
                ['submenu_name' => ' Product edit', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['setup.product-format-edit'])) {
            return [
                ['submenu_name' => ' Product format edit', 'action_name' => '']
            ];
        } else if (in_array($routeName, ['product.product-order-detail'])) {
            return [
                ['submenu_name' => 'Chart/Map Sell', 'action_name' => ''],
                ['submenu_name' => 'File Upload', 'action_name' => ''],
                ['submenu_name' => ' Product order detail', 'action_name' => '']
            ];
        } else {
            $breadMenus = [];

            try {
                $authorizationManager = new AuthorizationManager();
                $getRouteMenuId = $authorizationManager->findSubMenuId($routeName);
                if ($getRouteMenuId && !empty($getRouteMenuId)) {
                    $breadMenus[] = $bm = $authorizationManager->findParentMenu($getRouteMenuId);
                    if ($bm && isset($bm['parent_submenu_id']) && !empty($bm['parent_submenu_id'])) {
                        $breadMenus[] = $authorizationManager->findParentMenu($bm['parent_submenu_id']);
                    }
                }
            } catch (\Exception $e) {
                return false;
            }

            return is_array($breadMenus) ? array_reverse($breadMenus) : false;
        }
    }
}
