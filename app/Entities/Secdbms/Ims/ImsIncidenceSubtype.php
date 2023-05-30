<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/12/20
 * Time: 10:44 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsIncidenceSubtype extends Model
{
    protected $table = 'secdbms.ims_incidence_subtype';
    protected $primaryKey = 'incidence_subtype_id';
}