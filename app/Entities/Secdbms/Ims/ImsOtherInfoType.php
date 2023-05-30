<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/19/20
 * Time: 6:10 PM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsOtherInfoType extends Model
{
    protected $table = 'secdbms.ims_other_info_type';
    protected $primaryKey = 'other_info_type_id';
}