<?php

namespace App\Entities\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Setup\LFileCategory;
use App\Entities\Setup\LFileFormat;
use App\Entities\Setup\LModule;
use App\Entities\Setup\LSurveySoftware;
use Illuminate\Database\Eloquent\Model;

class FileInfo extends Model
{
    protected $table = 'FILE_INFO';
    protected $primaryKey = "file_info_id";
    public $timestamps = false;

    //
    protected $hidden = ['file_content'];

    public function file_category()
    {
        return $this->belongsTo(LFileCategory::class, 'file_category_id');
    }


    public function file_format()
    {
        return $this->belongsTo(LFileFormat::class, 'file_format_id');
    }


    public function survey_software()
    {
        return $this->belongsTo(LSurveySoftware::class, 'survey_software_id');
    }


    public function module()
    {
        return $this->belongsTo(LModule::class, 'module_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'uploaded_by');
    }
}
