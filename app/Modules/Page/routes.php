<?php
/*
* @Created by: TungTT
* @Author    : tranthanhtung.it02@gmail.com
* @Date      : 05/2023
* @Version   : 1.0
*/
$namespace = '\App\Modules\Page\Controllers';

Route::group(
    ['module'=>'Page', 'namespace' => $namespace], function() {
    Route::get('/gioi-thieu', array('as' => 'admin.page.about','uses' => 'PageController@getAbout'));
    Route::get('/lien-he', array('as' => 'admin.page.contact','uses' => 'PageController@getContact'));
    Route::get('/chinh-sach-bao-hanh', array('as' => 'admin.page.warrantyPolicy','uses' => 'PageController@getWarrantyPolicy'));
    Route::get('/kiem-tra-bao-hanh', array('as' => 'admin.page.warrantyCheck','uses' => 'PageController@getWarrantyCheck'));
    Route::post('/lien-he/gui', array('as' => 'home.page.contact.post','uses' => 'PageController@postContact'));
    Route::post('/bao-gia/gui', array('as' => 'home.page.quote_and_promotion.php.post','uses' => 'PageController@postQuoteAndPromotion'));
});

//Route::any('{query}', array('as' => 'admin.page.404','uses' => 'PageController@get404'));
