<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:43 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsIncidenceStatus extends Model
{
    protected $table = 'secdbms.ims_incidence_status';
    protected $primaryKey = 'incidence_status_id';
}