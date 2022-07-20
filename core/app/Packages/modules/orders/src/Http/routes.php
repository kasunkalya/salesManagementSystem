<?php
/**
 * PERMISSIONS MANAGEMENT ROUTES
 *
 * @version 1.0.0
 * @author Kasun Kalya <kasun.kalya@gmail.com>
 * @copyright 2015 Kasun Kalya
 */

/**
 * USER AUTHENTICATION MIDDLEWARE
 */
Route::group(['middleware' => ['auth']], function()
{
    Route::group(['prefix' => 'orders', 'namespace' => 'Modules\Orders\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'OrdersController@addView'
      ]);      
      
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'OrdersController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'OrdersController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'OrdersController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'orders.list', 'uses' => 'OrdersController@jsonList'
      ]);
    
      Route::get('json/orderlist/{year}/{product}', [
        'as' => 'orders.list', 'uses' => 'OrdersController@jsonorderList'
      ]);
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'OrdersController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'orders.edit', 'uses' => 'OrdersController@edit' 
      ]);
 
      Route::post('delete', [
        'as' => 'orders.delete', 'uses' => 'OrdersController@delete'
      ]);
         
       Route::post('deleteitem', [
        'as' => 'orders.deleteitem', 'uses' => 'OrdersController@deleteitem'
      ]);
      
      
    });
});