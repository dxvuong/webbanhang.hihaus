<?php
$namespace = 'App\Modules\Auth\Controllers';

Route::group(['module'=>'Auth', 'namespace' => $namespace], function() {
    Route::get('dang-nhap-tai-khoan', 'AuthController@loginForm')->name('user.login');
    Route::post('dang-nhap-tai-khoan', 'AuthController@postLogin')->name('user.login.post');

    Route::get('dang-ky-tai-khoan', 'AuthController@signupForm')->name('user.register');
    Route::post('dang-ky-tai-khoan', 'AuthController@postSignup')->name('user.register.post');

    Route::any('dang-xuat', function(){
        Auth::logout();
        return redirect(route('index'));
    })->name('user.logout');
});