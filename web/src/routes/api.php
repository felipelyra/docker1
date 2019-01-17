<?php

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
//use App\Http\Resources\Api\V1\ProductResource;


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

 
/**
 * API GENERIC ROUTES
 */
Route::get('/login','ApiController@accessToken');

// App v1 API
Route::group([
    'middleware' => 'apiversion:1',
//    'namespace'  => 'App\Http\Controllers',
    'prefix'     => '/v1',
    ], function ($router) {
        require base_path('routes/app_api.v1.php');
});
  
// App v1 API
Route::group([
    'middleware' => 'apiversion:2',
//    'namespace'  => 'App\Http\Controllers\',
    'prefix'     => '/v2',
    ], function ($router) {
        require base_path('routes/app_api.v2.php');
});
