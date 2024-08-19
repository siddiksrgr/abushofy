<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CheckOngkirController;

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

Route::get('/provinces', [CheckOngkirController::class, 'provinces'])->name('api-provinces');
Route::get('/cities/{id}', [CheckOngkirController::class, 'cities'])->name('api-regencies');
Route::post('/checkOngkir', [CheckOngkirController::class, 'checkOngkir']);
