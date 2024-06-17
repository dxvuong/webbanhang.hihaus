<?php
$namespace = 'App\Modules\App\Controllers';

$menus = \App\Modules\App\Models\Menu::where('parent', '=', NULL)
    ->where('menu_type', '=', \App\Modules\App\Models\Menu::THEORY_TYPE)
    ->where('status', '=', 1)
    ->with('children')
    ->get();
$menuParent = \App\Modules\Home\Models\Menu::where('parent', '=', NULL)
    ->where('item_type', '=', \App\Modules\Home\Models\Menu::LINK_TYPE)
    ->where('link', 'app-api')
    ->where('status', '=', 1)
    ->first();
Route::group(
    ['module'=>'App', 'namespace' => $namespace], function() use ($menus, $menuParent) {

    Route::get('/theory/chi-tiet/{id}', ['uses' => 'TheoryController@getSingle']);

    if (!empty($menus) && !empty($menuParent)) {
        foreach ($menus as $menu) {
            if ($menu->children->count() > 0) {
                foreach ($menu->children as $childMenu) {
                    if ($childMenu->children->count() > 0) {
                        foreach ($childMenu->children as $grandchildMenu) {
                            Route::get('/' . $menuParent->slug . '/' . $menu->slug.'/'. $childMenu->slug . '/'.$grandchildMenu->slug, ['uses' => 'TheoryController@getList']);
                            Route::get('/' . $menuParent->slug . '/' . $menu->slug.'/'. $childMenu->slug . '/'.$grandchildMenu->slug . '/{id?}', ['uses' => 'TheoryController@getSingle']);
                            Route::get('/' . $menuParent->slug . '/' . $grandchildMenu->slug, ['uses' => 'TheoryController@getList']);
                            Route::get('/' . $menuParent->slug . '/' . $grandchildMenu->slug . '/{id?}', ['uses' => 'TheoryController@getSingle']);
                        }
                    }
                    Route::get('/' . $menuParent->slug . '/' . $menu->slug.'/'. $childMenu->slug, ['uses' => 'TheoryController@getList']);
                    Route::get('/' . $menuParent->slug . '/' . $menu->slug.'/'. $childMenu->slug . '/{id?}', ['uses' => 'TheoryController@getSingle']);
                    Route::get('/' . $menuParent->slug . '/' . $childMenu->slug, ['uses' => 'TheoryController@getList']);
                    Route::get('/' . $menuParent->slug . '/' . $childMenu->slug . '/{id?}', ['uses' => 'TheoryController@getSingle']);
                }
            }
            Route::get('/' . $menuParent->slug . '/' .$menu->slug, ['uses' => 'TheoryController@getList']);
            Route::get('/' . $menuParent->slug . '/'.$menu->slug . '/{id?}', ['uses' => 'TheoryController@getSingle']);
        }
    }
}
);