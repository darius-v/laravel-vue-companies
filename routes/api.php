<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
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

Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::put('companies/{id}', [CompanyController::class, 'update']);
Route::delete('companies/{id}', [CompanyController::class, 'delete']);
Route::post('companies/{id}/logo', [CompanyController::class, 'uploadLogo']);
Route::patch('companies/{id}/contact', [CompanyController::class, 'addContact']);

Route::get('contacts/{query}', [ContactController::class, 'search']);

