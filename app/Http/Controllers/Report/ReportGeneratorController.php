<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 4/20/20
 * Time: 04:54 AM
 */

namespace App\Http\Controllers\Report;

use App\Entities\Admin\LGeoDivision;
use App\Entities\HydroOptions;
use App\Entities\Schedule\Schedule;
use App\Entities\Security\Report;
use App\Entities\Setup\LMonth;
use App\Entities\Setup\Vehicle;
use App\Enums\HydroOptionEnum;
use App\Enums\ModuleInfo;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Security\HasPermission;

class ReportGeneratorController extends Controller
{
    use HasPermission;

    public function index(Request $request)
    {
        $module = ModuleInfo::EBS_MODULE_ID;

        $reportObject = new Report();

        if (auth()->user()->hasGrantAll()) {
            $reports = $reportObject->where('module_id', $module)->orderBy('report_name', 'ASC')->get();
        }
        else {
            $roles = auth()->user()->getRoles();
            $reports = array();
            foreach ($roles as $role) {
                if(count($role->reports)) {
                    $rpts = $role->reports->where('module_id', $module);
                    foreach ($rpts as $report) {
                        $reports[$report->report_id] = $report;
                    }
                }
            }
        }

        return view('water.reportgenerator.index', compact('reports'));
    }

    public function reportParams(Request $request)
    {

        $id = $request->get('id');
        $report = Report::find($id);

        $months = LMonth::with([])->get();
        $vehicles = Vehicle::with([])->where('active_yn','=',YesNoFlag::YES)->get();


        $limit_count = \DB::table('HYDRO_OPTIONS')
            ->where('option_name', HydroOptionEnum::SURVEY_FILE_LIMIT)
            ->value('option_value');
        $schedules = Schedule::with([])
            ->where('approved_yn','=',YesNoFlag::YES)
            ->orderBy('schedule_master_id', 'desc')->take($limit_count)->get();

        $reportForm = view('water.reportgenerator.report-params', compact('report','months','vehicles','schedules'))->render();

        return $reportForm;
    }
}
