<?php

namespace App\Entities\Others;

use Illuminate\Database\Eloquent\Model;

class ContactManagement extends Model
{
    //CONTACT_MANAGEMENT
    protected $table = 'CONTACT_MANAGEMENT';
    protected $primaryKey = "contact_management_id";
    public $timestamps = false;

}
