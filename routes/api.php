<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'as' => 'api.', 'namespace' => 'Api', 'middleware' => 'auth:api' ], function () {
    Route::post('tickets/{app}', 'TicketsController@index');
    Route::get('apps/{app}', 'AppsController@show');
    Route::get('project_navigation_trees/{project_navigation}', 'ProjectNavigationTreesController@show');
});

//Route::resource('projects', 'ProjectsController');
//Route::resource('apps', 'AppsController');
//Route::resource('websites', 'WebsitesController');
//Route::resource('project_navigations', 'ProjectNavigationsController');
