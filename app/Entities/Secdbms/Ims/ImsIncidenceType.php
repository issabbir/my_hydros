<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:45 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsIncidenceType extends Model
{
    protected $table = 'secdbms.ims_incidence_type';
    protected $primaryKey = 'incidence_type_id';
}