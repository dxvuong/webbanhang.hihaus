<?php

namespace App\Modules\FileDownload\Models;

use Illuminate\Database\Eloquent\Model;

class FileDownload extends Model{
    protected $table = 'file_downloads';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'name', 'file', 'file_url', 'file_type', 'url_view', 'url_download', 'author'
    );

    const DOC_TYPE = 1;
    const EXCEL_TYPE = 2;
    const PDF_TYPE = 3;
}
