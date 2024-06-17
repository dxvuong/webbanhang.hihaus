<?php
$namespace = 'App\Modules\FileDownload\Controllers';

Route::group(['module' => 'Blog', 'namespace' => $namespace], function () {
    Route::get('/view/file/{id}', ['uses' => 'FileDownloadController@index']);

});