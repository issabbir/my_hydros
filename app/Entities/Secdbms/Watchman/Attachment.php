<?php

/**
 * Created by PhpStorm.
 * User: Hossian
 * Date: 4/26/20
 * Time: 01:00 PM
 */

namespace App\Entities\Secdbms\Watchman;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'secdbms.wm_attachments';
    protected $primaryKey = 'attachment_id';
    protected $with = ['attachment_type'];

    public function attachment_type()
    {
        return $this->belongsTo(AttachmentType::class, 'attachment_type_id');
    }
}
