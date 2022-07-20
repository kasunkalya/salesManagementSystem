<?php
/**
 * MENU MANAGEMENT ROUTES
 *

 * @author kasun kalya <kasun.kalya@gmail.com>

 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'menu', 'namespace' => 'Modules\MenuManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'menu.add', 'uses' => 'MenuController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'menu.edit', 'uses' => 'MenuController@editView'
      ]);

      Route::get('list', [
        'as' => 'menu.list', 'uses' => 'MenuController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'menu.list', 'uses' => 'MenuController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'menu.add', 'uses' => 'MenuController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'menu.edit', 'uses' => 'MenuController@edit'
      ]);

      Route::post('status', [
        'as' => 'menu.status', 'uses' => 'MenuController@status'
      ]);

      Route::post('delete', [
        'as' => 'menu.delete', 'uses' => 'MenuController@delete'
      ]);
    });
});