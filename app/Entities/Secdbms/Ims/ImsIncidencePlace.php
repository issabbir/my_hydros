<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:47 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsIncidencePlace extends Model
{
    protected $table = 'secdbms.ims_incidence_place';
    protected $primaryKey = 'incidence_place_id';
}