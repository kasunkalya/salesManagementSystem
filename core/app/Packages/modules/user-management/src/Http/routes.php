<?php
/**
 * USER MANAGEMENT ROUTES
 *

 * @author kasun kalya <kasun.kalya@gmail.com>

 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'user', 'namespace' => 'Modules\UserManage\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'user.add', 'uses' => 'UserController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'user.edit', 'uses' => 'UserController@editView'
      ]);

      Route::get('list', [
        'as' => 'user.list', 'uses' => 'UserController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'user.list', 'uses' => 'UserController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'user.add', 'uses' => 'UserController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'user.edit', 'uses' => 'UserController@edit'
      ]);

      Route::post('status', [
        'as' => 'user.status', 'uses' => 'UserController@status'
      ]);

      Route::post('delete', [
        'as' => 'user.delete', 'uses' => 'UserController@delete'
      ]);
    });
});