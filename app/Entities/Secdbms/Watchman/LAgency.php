<?php

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class LAgency extends Model
{
    protected $table = 'secdbms.l_agency';
    protected $primaryKey = 'agency_id';

    public function agency_type()
    {
        return $this->belongsTo(LAgencyType::class, 'agency_type_id');
    }
}
