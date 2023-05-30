<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:41 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsIncidence extends Model
{
    protected $table = 'secdbms.ims_incidence';
    protected $primaryKey = 'incidence_id';

    public function incidence_type()
    {
        return $this->belongsTo(ImsIncidenceType::class, 'incidence_type_id');
    }

    public function investigation()
    {
        return $this->hasOne(ImsInvestigation::class, 'incidence_id', 'incidence_id');
    }

    public function incidence_action()
    {
        return $this->hasOne(ImsIncidenceAction::class, 'incidence_id', 'incidence_id');
    }
}