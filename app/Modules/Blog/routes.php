<?php
$namespace = 'App\Modules\Blog\Controllers';
use App\Modules\Home\Models\Menu;

$menus = Menu::select('link')
    ->where('item_type', '=', Menu::BLOG_TYPE)
    ->where('status', '=', 1)
    ->with('children')
    ->get();
Route::group(
    ['module'=>'Blog', 'namespace' => $namespace], function() use ($menus) {
    Route::get('blog', ['as' => 'blog.list', 'uses' => 'BlogController@getList']);
    Route::get('blog/danh-sach/{menu}', ['as' => 'menu.blog', 'uses' => 'BlogController@getList']);
    Route::get('/blog/chi-tiet/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle']);
    Route::get('dich-vu/{slug}', ['as' => 'service.single.blog', 'uses' => 'BlogController@getServiceSingle']);
    Route::post('blog/comment', ['as' => 'comment.blog', 'uses' => 'BlogController@commentSingle']);
    Route::post('blog/comment/child', ['as' => 'comment.blog.child', 'uses' => 'BlogController@commenChildtSingle']);
    foreach ($menus as $menu) {
        Route::get('/'.$menu->link, ['uses' => 'BlogController@getList']);
    }
    foreach ($menus as $menu) {
        Route::get('/'.$menu->link . '/{id}', ['uses' => 'BlogController@getSingle']);
    }
}
);