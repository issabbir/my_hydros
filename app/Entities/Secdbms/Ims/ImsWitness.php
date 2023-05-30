<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:49 AM
 */

namespace App\Entities\Secdbms\Ims;

use App\Contracts\Secdbms\Ims\ImsInvestigationContract;
use Illuminate\Database\Eloquent\Model;

class ImsWitness extends Model
{
    protected $table = 'secdbms.ims_witness';
    protected $primaryKey = 'witness_id';

    public function investigation()
    {
        return $this->belongsTo(ImsInvestigation::class, 'investigation_id');
    }
}