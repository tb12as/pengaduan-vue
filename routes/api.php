<?php

use App\Http\Controllers\Admin\CetakController;
use App\Http\Controllers\Admin\MasyarakatController;
use App\Http\Controllers\Admin\PengaduanController as PengaduanAdminController;
use App\Http\Controllers\Admin\TanggapanController;
use App\Http\Controllers\Masyarakat\PengaduanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->group(function() {
	Route::get('/user/role', fn() => Auth::user()->getRoles());

	Route::middleware('role:masyarakat')->prefix('/masyarakat/')->group(function() {
		Route::resource('pengaduan', PengaduanController::class)->except([
			'create', 'edit'
		]);
	});

	Route::middleware(['role:admin|petugas'])->prefix('/admin/')->group(function() {
		Route::resource('pengaduan', PengaduanAdminController::class)->except([
			'create', 'edit'
		]);
		Route::resource('tanggapan', TanggapanController::class)->except([
			'create', 'edit'
		]);
		Route::get('/user-count', [MasyarakatController::class, 'count']);
		Route::post('/valid/{pengaduan:id}', [PengaduanAdminController::class, 'isValid']);

		Route::get('/pengaduan/search/{query}', [PengaduanAdminController::class, 'search']);
	});

	Route::middleware('role:admin')->group(function() {
		Route::get('/admin/cetak/{pengaduan:id}', [CetakController::class, 'cetakPdf']);
	});
});