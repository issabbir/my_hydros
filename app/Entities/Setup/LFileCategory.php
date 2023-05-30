<?php

namespace App\Entities\Setup;

use Illuminate\Database\Eloquent\Model;

class LFileCategory extends Model
{
    //
    protected $table = 'L_FILE_CATEGORY';
    protected $primaryKey = "file_category_id";
    public $timestamps = false;
}
