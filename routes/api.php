<?php

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/companies', [CompanyController::class, 'store']);

//Route::get('companies', 'ArticleController@index');
//Route::get('articles/{id}', 'ArticleController@show');

//Route::put('articles/{id}', 'ArticleController@update');
//Route::delete('articles/{id}', 'ArticleController@delete');
