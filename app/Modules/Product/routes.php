<?php
$namespace = 'App\Modules\Product\Controllers';
use App\Modules\Home\Models\Menu;

$menus = Menu::select('link')->where('item_type', '=', Menu::PRODUCT_TYPE)
    ->where('status', '=', 1)
    ->with('children')
    ->get();

Route::group(
    ['module'=>'Product', 'namespace' => $namespace, 'middleware' => 'web'], function() use ($menus) {
    Route::get('/tat-ca-san-pham', ['as' => 'list.product', 'uses' => 'ProductController@getList']);
    Route::get('/san-pham-moi', ['as' => 'new.product', 'uses' => 'ProductController@getList']);
    Route::get('/san-pham-ban-chay', ['as' => 'selling.product', 'uses' => 'ProductController@getSelling']);
    Route::get('/san-pham/danh-sach/{menu}', ['as' => 'menu.product', 'uses' => 'ProductController@getList']);
    Route::get('/san-pham/chi-tiet/{id}', ['as' => 'product.detail', 'uses' => 'ProductController@getSingle']);
    Route::post('/san-pham/comment', ['as' => 'comment.product', 'uses' => 'ProductController@commentSingle']);
    Route::post('/san-pham/comment/child', ['as' => 'comment.product.child', 'uses' => 'ProductController@commenChildtSingle']);
    Route::get('/gio-hang', ['as' => 'product.cart', 'uses' => 'ProductController@cartProduct']);
    Route::post('/gio-hang', ['as' => 'product.cart.post', 'uses' => 'ProductController@addToCart']);
    Route::post('/them-gio-hang', ['as' => 'product.add.cart.post', 'uses' => 'ProductController@addToCartNew']);
    Route::get('/gio-hang/xoa/{id}', ['as' => 'product.cart.remove', 'uses' => 'ProductController@removeCart']);
    Route::post('/gio-hang/update', ['as' => 'product.cart.update.post', 'uses' => 'ProductController@updateToCart']);
    Route::get('/thanh-toan', ['as' => 'product.checkout', 'uses' => 'ProductController@checkOut']);
    Route::post('/thanh-toan', ['as' => 'product.checkout.post', 'uses' => 'ProductController@postCheckOut']);
    Route::post('/gio-hang/nhap-ma-gioi-thieu', ['as' => 'product.nhapmagioithieu.post', 'uses' => 'ProductController@nhapMaGioiThieu']);
    foreach ($menus as $menu) {
        Route::get('/'.$menu->link, ['uses' => 'ProductController@getList']);
    }

    Route::post('/product/{product_id}/review', ['as' => 'product.review.store', 'uses' => 'ProductController@storeReview']);
}
);
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared 123123';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Clear Config cache:
Route::get('/backup', function() {
    //ENTER THE RELEVANT INFO BELOW
    $mysqlHostName      = env('DB_HOST');
    $mysqlUserName      = env('DB_USERNAME');
    $mysqlPassword      = env('DB_PASSWORD');
    $DbName             = env('DB_DATABASE');
    $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';


    $queryTables = \DB::select(\DB::raw('SHOW TABLES'));
    foreach ( $queryTables as $table )
    {
        foreach ( $table as $tName)
        {
            $tables[]= $tName ;
        }
    }
    // $tables  = array("users","products","categories"); //here your tables...

    $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword",array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $get_all_table_query = "SHOW TABLES";
    $statement = $connect->prepare($get_all_table_query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    foreach($tables as $table)
    {
        $show_table_query = "SHOW CREATE TABLE " . $table . "";
        $statement = $connect->prepare($show_table_query);
        $statement->execute();
        $show_table_result = $statement->fetchAll();

        foreach($show_table_result as $show_table_row)
        {
            $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
        }
        $select_query = "SELECT * FROM " . $table . "";
        $statement = $connect->prepare($select_query);
        $statement->execute();
        $total_row = $statement->rowCount();

        for($count=0; $count<$total_row; $count++)
        {
            $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
            $table_column_array = array_keys($single_result);
            $table_value_array = array_values($single_result);
            $output .= "\nINSERT INTO $table (";
            $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
            $output .= "'" . implode("','", $table_value_array) . "');\n";
        }
    }

    $file_handle = fopen($file_name, 'w+');
    fwrite($file_handle, $output);
    fclose($file_handle);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);
});