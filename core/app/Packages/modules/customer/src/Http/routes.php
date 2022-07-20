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
    Route::group(['prefix' => 'customer', 'namespace' => 'Modules\Customer\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'CustomerController@addView'
      ]);      
      
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'CustomerController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'CustomerController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'CustomerController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'Customer.list', 'uses' => 'CustomerController@jsonList'
      ]);
    
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'CustomerController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Customer.edit', 'uses' => 'CustomerController@edit' 
      ]);
 
      Route::post('delete', [
        'as' => 'Customer.delete', 'uses' => 'CustomerController@delete'
      ]);
            
    });
});