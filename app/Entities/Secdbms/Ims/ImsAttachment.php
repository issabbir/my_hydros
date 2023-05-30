<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 4/20/20
 * Time: 8:52 PM
 */

namespace App\Entities\Secdbms\Ims;

use Illuminate\Database\Eloquent\Model;

class ImsAttachment extends Model
{
    protected $table = 'secdbms.ims_attachment';
    protected $primaryKey = 'attachment_id';
}