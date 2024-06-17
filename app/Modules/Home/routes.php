<?php

use Illuminate\Support\Facades\Session;
use App\Modules\Home\Models\LandingPage;

$namespace = 'App\Modules\Home\Controllers';
$landingPage = LandingPage::select('url')->where('status', 1)->get();
$brands = \App\Modules\Home\Models\Brand::select('slug')->where('status', 1)->get();
$commitment = \App\Modules\Home\Models\Commitment::select('slug')->where('status', 1)->get();

Route::group(
    ['module'=>'Home', 'namespace' => $namespace], function() {
        Route::get('/', ['as' => 'index', 'uses' => 'HomeController@getHome']);
        Route::get('/git-pull', ['as' => 'git.pull', 'uses' => 'HomeController@gitPull']);
        Route::get('/lang/{lang?}', function ($lang) {
            Session::put('language', $lang, 6*24);
            return redirect()->back();
        })->name('index.lang');
        Route::get('/dang-ky', 'HomeController@signup');
        Route::post('/signup_submit', 'HomeController@signup_submit');
        Route::post('/selectdictrict', 'HomeController@loadQuanHuyen')->where('id', '[0-9]+');
        Route::post('/selectward', 'HomeController@loadXaPhuong')->where('id', '[0-9]+');
    }
);

Route::group(
    ['module'=>'Page', 'namespace' => $namespace], function() use ($landingPage) {
    foreach ($landingPage as $page) {
        Route::get("/$page->url", ['uses' => 'HomeController@getLandingPage']);
    }
}
);

Route::group(['middleware' => []], function () {
    Route::get('php-artisan-{type}', function($type){
        print_r(Artisan::call(str_replace('_', ':', $type)));
    });
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::group(
    ['module'=>'Brand', 'namespace' => $namespace], function() use ($brands) {
    foreach ($brands as $brand) {
        Route::get('/'.$brand->slug, ['uses' => 'BrandController@getSingle']);
    }
}
);

Route::group(
    ['module'=>'Commitment', 'namespace' => $namespace], function() use ($commitment) {
    foreach ($commitment as $commit) {
        Route::get('/'.$commit->slug, ['uses' => 'CommitmentController@getSingle']);
    }
}
);

Route::get('/sitemap.xml', function () {
    // Phản hồi cho yêu cầu
    return response()->file(public_path('sitemap.xml'));
});
