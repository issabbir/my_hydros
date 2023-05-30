<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class WorkFlowProcess extends Model
{
    protected $table = "workflow_process";
    protected $primaryKey = "workflow_process_id";

    protected $fillable = ['workflow_object_id','workflow_step_id','note','price_bdt','price_usd'];
    protected $with = ['workflowStep'];

    public function workflowStep(){
        return $this->belongsTo(WorkFlowStep::class, 'workflow_step_id');
    }
}
