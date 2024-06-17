<?php

namespace App\Modules\FileDownload\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\FileDownload\Models\FileDownload;

class FileDownloadController extends Controller
{
    public function index($id)
    {

        $data = FileDownload::find($id);

        return view('FileDownload::view', ['data' => $data]);
    }
}