<?php
$namespace = 'App\Modules\Product\Controllers';

Route::group(
    ['module'=>'Product', 'namespace' => $namespace, 'middleware' => 'web'], function() {
        Route::get('/{id}', [ 'uses' => 'ProductController@getSingle']);
    }
);
