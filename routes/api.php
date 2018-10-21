<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api', 'fill.last.seen']], function () {
    Route::get('transactions', 'TransactionController@index');
    Route::get('transactions/{transaction}', 'TransactionController@show');
    Route::post('transactions', 'TransactionController@store');
    Route::delete('transactions/{transaction}', 'TransactionController@delete');
    Route::get('totalinfo/positive/{from}/{to}', 'TotalInfoController@positive');
    Route::get('totalinfo/negative/{from}/{to}', 'TotalInfoController@negative');
    Route::get('totalinfo/total/{from}/{to}', 'TotalInfoController@total');
    Route::resource('totalinfo', 'TotalInfoController')->only(['index']);
});
