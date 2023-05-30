<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
    protected $table = 'secdbms.wm_attachment_type';
    protected $primaryKey = 'attachment_type_id';
}
