<?php

use App\Http\Controllers\ApiController;
use Facade\FlareClient\Api;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('question',[ApiController::class,'index']);
Route::post('question',[ApiController::class,'store']);
Route::get('question/{id}',[ApiController::class,'show']);
Route::put('question/{id}',[ApiController::class,'update']);
Route::delete('question/{id}',[ApiController::class,'destroy']);

Route::post('saveResult',[ApiController::class,'storeResult']);

Route::get('paket/{id}',[ApiController::class,'showPaket']);
