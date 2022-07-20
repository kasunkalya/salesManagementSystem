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
    Route::group(['prefix' => 'user/role', 'namespace' => 'Modules\UserRoles\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'user.role.add', 'uses' => 'UserRoleController@addView'
      ]);

      Route::get('edit/{id}', [
        'as' => 'user.role.edit', 'uses' => 'UserRoleController@editView'
      ]);

      Route::get('list', [
        'as' => 'user.role.list', 'uses' => 'UserRoleController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'user.role.list', 'uses' => 'UserRoleController@jsonList'
      ]);

      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'user.role.add', 'uses' => 'UserRoleController@add'
      ]);

      Route::post('edit/{id}', [
        'as' => 'user.role.edit', 'uses' => 'UserRoleController@edit'
      ]);

      Route::post('delete', [
        'as' => 'user.role.delete', 'uses' => 'UserRoleController@delete'
      ]);
    });
});