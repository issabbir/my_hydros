<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LFileFormat extends Model
{
    //
    protected $table = 'L_FILE_FORMAT';
    protected $primaryKey = "file_format_id";
    public $timestamps = false;
}
