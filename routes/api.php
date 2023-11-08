<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\bukucontroller;
use App\http\Controllers\kelascontroller;
use App\http\Controllers\siswacontroller;
use App\http\Controllers\TransaksiController;
use App\http\Controllers\API\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
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

Route::post('pinjam_buku', [TransaksiController::class,'pinjamBuku']);
Route::post('tambah_item/{id}',[TransaksiController::class,'tambahItem']);
Route::post('mengembalikan_buku',[TransaksiController::class,'mengembalikanBuku']);