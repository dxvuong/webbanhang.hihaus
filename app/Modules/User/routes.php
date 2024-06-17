<?php
$namespace = 'App\Modules\User\Controllers';

Route::group(['module'=>'Auth', 'namespace' => $namespace], function() {
    Route::get('tai-khoan-cua-toi', 'UserController@detail')->name('user.auth.detail');
    Route::post('tai-khoan-cua-toi', 'UserController@postUpdateUser')->name('user.auth.update');
});