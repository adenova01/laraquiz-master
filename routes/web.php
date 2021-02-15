<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaketUjianController;
use App\Http\Controllers\QuizMuridController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TryoutMuridController;
use App\Http\Controllers\Voyager\VoyagerController;
use App\Http\Controllers\PaketMuridController;
use App\Http\Controllers\ImportQbankController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/paket_ujian/{id}',[PaketUjianController::class,'show']);
Route::get('/quiz/{id}',[QuizMuridController::class,'show']);
Route::get('register',[RegisterController::class,'register']);
Route::post('registrasiUser',[RegisterController::class,'registrasiUser']);
Route::post('uploadQbank',[ImportQbankController::class,'store']);
Route::post('createTemplate',[ImportQbankController::class,'store']);



Route::group(['prefix' => 'tryout'], function () {
    Voyager::routes();

    Route::get('tryout-murid',[TryoutMuridController::class,'index']);
    Route::get('mulai-ujian/{id}',[TryoutMuridController::class,'mulai_ujian']);
    Route::get('beli-quis/{id}',[TryoutMuridController::class,'beli_quis']);
    Route::get('my-tryout',[TryoutMuridController::class,'my_tryout']);

    Route::get('paket-murid',[PaketMuridController::class,'index']);
    Route::get('beli-paket/{id}',[PaketMuridController::class,'beliPaket']);
    Route::get('/paket-murid/detail-paket/{id}',[PaketMuridController::class,'detailPaket']);
});

//Route::post('/admin/options/store', '\Controllers\Voyager\OptionsController@store');

/*Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});*/
