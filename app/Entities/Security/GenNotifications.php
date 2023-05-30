<?php


namespace App\Entities\Security;


use Illuminate\Database\Eloquent\Model;

class GenNotifications extends Model
{
    protected  $primaryKey='notification_id';
    protected $table = "cpa_security.gen_notifications";
    public $timestamps = false;
}
