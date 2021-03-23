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
    Route::group([ 'middleware' => [ 'permission' ] ], static function () {
        Route::resource('projects', 'ProjectsController');
        Route::resource('websites', 'WebsitesController');
        Route::resource('apps', 'AppsController');

        Route::resource('project_navigations', 'ProjectNavigationsController', [
            'except' => [
                'index',
                'create'
            ]
        ]);

        Route::get('project_navigations/{project_navigation}', 'ProjectNavigationsController@index')
             ->name('project_navigations.index');
        Route::get('project_navigations/{project_navigation}/create', 'ProjectNavigationsController@create')
             ->name('project_navigations.create');

        Route::resource('project_navigation_trees', 'ProjectNavigationTreesController', [
            'parameters' => [
                'project_navigation_trees' => 'project_navigation'
            ]
        ]);
        Route::get('project_navigation_trees/{project_navigation}/duplicate',
            'ProjectNavigationTreesController@duplicate')->name('project_navigation_trees.duplicate');
    }
});
