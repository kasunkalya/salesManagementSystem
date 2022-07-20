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
    Route::group(['prefix' => 'product', 'namespace' => 'Modules\Product\Http\Controllers'], function(){
      /**
       * GET Routes
       */
      Route::get('add', [
        'as' => 'add', 'uses' => 'ProductController@addView'
      ]);      
      
      Route::get('edit/{id}', [
        'as' => 'edit', 'uses' => 'ProductController@editView'
      ]);
      
      Route::get('view/{id}', [
        'as' => 'edit', 'uses' => 'ProductController@viewView'
      ]);

      Route::get('list', [
        'as' => 'list', 'uses' => 'ProductController@listView'
      ]);

      Route::get('json/list', [
        'as' => 'Product.list', 'uses' => 'ProductController@jsonList'
      ]);

      Route::post('details', [
        'as' => 'details', 'uses' => 'ProductController@details'
      ]);
    
      
      /**
       * POST Routes
       */
      Route::post('add', [
        'as' => 'add', 'uses' => 'ProductController@add'
      ]);
      Route::post('edit/{id}', [
        'as' => 'Product.edit', 'uses' => 'ProductController@edit' 
      ]);
 
      Route::post('delete', [
        'as' => 'Product.delete', 'uses' => 'ProductController@delete'
      ]);
            
    });
});