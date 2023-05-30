<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:49 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsInvestigation extends Model
{
    protected $table = 'secdbms.ims_investigation';
    protected $primaryKey = 'investigation_id';
    protected $with = ['witnesses'];

    public function witnesses()
    {
        return $this->hasMany(ImsWitness::class, 'investigation_id', 'investigation_id')->orderBy('witness_id');
    }
}