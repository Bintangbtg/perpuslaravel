<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\bukucontroller;
use App\http\Controllers\kelascontroller;
use App\http\Controllers\siswacontroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getkelas',[kelascontroller::class,'getkelas']);
Route::post('/addkelas',[kelascontroller::class,'addkelas']);
Route::put('/updatekelas/{id}', [kelascontroller::class, 'updatekelas']);
Route::get('/getkelasById/{id}', [kelascontroller::class, 'getkelasById']);
Route::delete('/deletekelas/{id}', [kelascontroller::class, 'deletekelas']);

Route::get('/getsiswa',[siswacontroller::class,'getsiswa']);
Route::post('/addsiswa',[siswacontroller::class,'addsiswa']);
Route::put('/updatesiswa/{id}', [siswacontroller::class, 'updatesiswa']);
Route::get('/getsiswaById/{id}', [siswacontroller::class, 'getsiswaById']);
Route::delete('/deletesiswa/{id}', [siswacontroller::class, 'deletesiswa']);

Route::get('/getbuku',[bukucontroller::class,'getbuku']);
Route::post('/addbuku',[bukucontroller::class,'addbuku']);
Route::put('/updatebuku/{id}', [bukucontroller::class, 'updatebuku']);
Route::get('/getbukuById/{id}', [bukucontroller::class, 'getbukuById']);
Route::delete('/deletebuku/{id}', [bukucontroller::class, 'deletebuku']);