@extends('Home::Layout.master')

@section('main')
    <div class="single_blog">
        <div class="container">
            @if($data->file_type == \App\Modules\FileDownload\Models\FileDownload::PDF_TYPE)
                <iframe src='{{ config('app.PATH_ADMIN') . $data->file }}' style="width: 100%; height: 80vh"></iframe>
            @else
                <iframe src='https://docs.google.com/gview?url={{ config('app.PATH_ADMIN') . $data->file }}&embedded=true' style="width: 100%; height: 80vh"></iframe>
            @endif
        </div>
    </div>
@endsection