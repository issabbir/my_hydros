<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/20/20
 * Time: 10:23 AM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsContainerDetained extends Model
{
    protected $table = 'secdbms.ims_container_detained';
    protected $primaryKey = 'container_detained_id';
}