<?php
$namespace = 'App\Modules\Event\Controllers';

Route::group(
    ['module'=>'Event', 'namespace' => $namespace], function() {
    Route::get('su-kien/{slug}', ['as' => 'event.single', 'uses' => 'EventController@getSingle']);
    Route::post('event/comment', ['as' => 'comment.event', 'uses' => 'EventController@commentSingle']);
    Route::post('event/comment/child', ['as' => 'comment.event.child', 'uses' => 'EventController@commenChildtSingle']);
}
);