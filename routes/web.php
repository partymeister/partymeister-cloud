<?php
Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation'
    ]
], function () {
    Route::resource('projects', 'ProjectsController');
    Route::resource('websites', 'WebsitesController');
    Route::resource('apps', 'AppsController');
});