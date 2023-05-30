<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 5/19/20
 * Time: 2:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class LoanMst extends Model
{
    protected $table = 'secdbms.wm_loan_mst';
    protected $primaryKey = 'loan_mst_id';

    public function wm_id()
    {
        return $this->belongsTo(Watchman::class, 'watchman_id');
    }


}
