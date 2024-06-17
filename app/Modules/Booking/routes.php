<?php
$namespace = 'App\Modules\Booking\Controllers';

Route::group(
    ['module'=>'Booking', 'namespace' => $namespace], function() {
    Route::get('booking', ['as' => 'booking.list', 'uses' => 'BookingController@getList']);
    Route::post('booking', ['as' => 'booking.post', 'uses' => 'BookingController@postList']);
}
);