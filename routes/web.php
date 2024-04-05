<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\QccController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [AuthController::class, 'doLogout'])->middleware(['auth'])->name('doLogout');

Route::middleware(['auth', 'Superadmin'])->group(function () {
    // ------Home--------
    Route::get('/', [AppController::class, 'index'])->name('home');

    // ------QCC-------
    Route::get('/qcc/monitor/{id?}', [QccController::class, 'index'])->name('monitorQcc');
    Route::get('/qcc/monitor/member/{circle_id}', [QccController::class, 'member'])->name('monitorMember');

    // ------QCC ABSENSI START----
    Route::get('/qcc/absensi', [QccController::class, 'absensi'])->name('absensiQcc');
    Route::post('/qcc/absensi', [AbsenController::class, 'storeAbsensi'])->name('storeAbsensi');
    Route::get('/qcc/absensi/form/1', [AbsenController::class, 'form'])->name('formAbsensi');
    Route::get('/qcc/absensi/form/2', [AbsenController::class, 'form2'])->name('formAbsensi2');
    Route::get('/qcc/absensi/form/3', [AbsenController::class, 'form3'])->name('formAbsensi3');
    Route::get('/qcc/absensi/form/4', [AbsenController::class, 'form4'])->name('formAbsensi4');
    Route::get('/qcc/absensi/form/5', [AbsenController::class, 'form5'])->name('formAbsensi5');
    Route::get('/qcc/absensi/form/6', [AbsenController::class, 'form6'])->name('formAbsensi6');
    Route::get('/qcc/absensi/form/7', [AbsenController::class, 'form7'])->name('formAbsensi7');
    Route::get('/qcc/absensi/form/8', [AbsenController::class, 'form8'])->name('formAbsensi8');
    Route::get('/qcc/absensi/form/9', [AbsenController::class, 'form9'])->name('formAbsensi9');
    // ------QCC ABSENSI END----

    Route::get('/qcc/register', [QccController::class, 'register'])->name('registerQcc');
    Route::post('/qcc/register', [QccController::class, 'add'])->name('addAnggota');
    Route::get('/anggota/{id}/destroy', [QccController::class, 'destroy'])->name('destroy');
    Route::get('/qcc/notulen1', [QccController::class, 'notulen']);

    Route::get('/qcc/resume', [QccController::class, 'resume'])->name('resumeQcc');
    Route::get('/qcc/data-nqi', [QccController::class, 'dataNqi'])->name('dataNqiQcc');
    Route::get('/qcc/data-circle', [QccController::class, 'dataCircle'])->name('dataCircleQcc');

    // --------admin--------
    Route::get('/admin/karyawan', [AdminController::class, 'index'])->name('karyawan');
    Route::get('/admin/karyawan/form', [AdminController::class, 'form'])->name('form');
    Route::post('/admin/karyawan', [AdminController::class, 'add'])->name('add');
    Route::post('/admin/karyawan/import', [AdminController::class, 'import'])->name('importUsers');
    Route::get('/admin/control-step', [AdminController::class, 'controlStep'])->name('controlStep');
    Route::get('/admin/control-period', [AdminController::class, 'controlPeriod'])->name('controlPeriod');
    Route::post('/admin/control-period', [AdminController::class, 'tambahBaris'])->name('tambah-baris');
    Route::get('/admin/control-period/{id}', [AdminController::class, 'ubahPeriode'])->name('ubah-periode');
    Route::get('/admin/control-step/{id}', [AdminController::class, 'softDelete']);


    Route::resource('circles', CircleController::class);

    

    // getkaryawan
    Route::get('/karyawan/{npk}', [KaryawanController::class, 'getKaryawanByNPK']);
});
Route::middleware(['auth', 'Management'])->group(function () {
    // ------Home--------
    Route::get('/', [AppController::class, 'index'])->name('home');

    // ------QCC-------
    Route::get('/qcc/monitor/{id?}', [QccController::class, 'index'])->name('monitorQcc');
    Route::get('/qcc/monitor/circle/{circle_id}', [QccController::class, 'member'])->name('detailCircle');

    // ------QCC ABSENSI START----
    Route::get('/qcc/absensi', [QccController::class, 'absensi'])->name('absensiQcc');
    Route::get('/qcc/absensi/form/1', [AbsenController::class, 'form'])->name('formAbsensi');
    Route::get('/qcc/absensi/form/2', [AbsenController::class, 'form2'])->name('formAbsensi2')->middleware('check.schedule');
    Route::get('/qcc/absensi/form/3', [AbsenController::class, 'form3'])->name('formAbsensi3');
    Route::get('/qcc/absensi/form/4', [AbsenController::class, 'form4'])->name('formAbsensi4');
    Route::get('/qcc/absensi/form/5', [AbsenController::class, 'form5'])->name('formAbsensi5');
    Route::get('/qcc/absensi/form/6', [AbsenController::class, 'form6'])->name('formAbsensi6');
    Route::get('/qcc/absensi/form/7', [AbsenController::class, 'form7'])->name('formAbsensi7');
    Route::get('/qcc/absensi/form/8', [AbsenController::class, 'form8'])->name('formAbsensi8');
    Route::get('/qcc/absensi/form/9', [AbsenController::class, 'form9'])->name('formAbsensi9');
    // ------QCC ABSENSI END----

    // ------QCC NOTULEN START
    Route::post('/qcc/absensi/form/1', [NotulenController::class, 'add'])->name('addNotulen');
    Route::post('/qcc/absensi/form/2', [NotulenController::class, 'add_2'])->name('addNotulen2');
    Route::post('/qcc/absensi/form/3', [NotulenController::class, 'add_3'])->name('addNotulen3');
    Route::post('/qcc/absensi/form/4', [NotulenController::class, 'add_4'])->name('addNotulen4');
    Route::post('/qcc/absensi/form/5', [NotulenController::class, 'add_5'])->name('addNotulen5');
    Route::post('/qcc/absensi/form/6', [NotulenController::class, 'add_6'])->name('addNotulen6');
    Route::post('/qcc/absensi/form/7', [NotulenController::class, 'add_7'])->name('addNotulen7');
    Route::post('/qcc/absensi/form/8', [NotulenController::class, 'add_8'])->name('addNotulen8');
    Route::post('/qcc/absensi/form/9', [NotulenController::class, 'add_9'])->name('addNotulen9');

    // ------QCC NOTULEN END
    
    // ------QCC DOCS START-----
    Route::get('/qcc/absensi/doc/1', [DocumentController::class, 'doc1'])->name('doc1');
    Route::get('/qcc/absensi/download-pdf', [AbsenController::class, 'downloadPdf'])->name('downloadPdf');
    Route::get('/qcc/absensi/doc/2', [DocumentController::class, 'doc2'])->name('doc2');
    Route::get('/qcc/absensi/doc/3', [DocumentController::class, 'doc3'])->name('doc3');
    Route::get('/qcc/absensi/doc/4', [DocumentController::class, 'doc4'])->name('doc4');
    Route::get('/qcc/absensi/doc/5', [DocumentController::class, 'doc5'])->name('doc5');
    Route::get('/qcc/absensi/doc/6', [DocumentController::class, 'doc6'])->name('doc6');
    Route::get('/qcc/absensi/doc/7', [DocumentController::class, 'doc7'])->name('doc7');
    Route::get('/qcc/absensi/doc/8', [DocumentController::class, 'doc8'])->name('doc8');
    Route::get('/qcc/absensi/doc/9', [DocumentController::class, 'doc9'])->name('doc9');
Route::get('/lihat-file/{nama_file}', [DocumentController::class, 'lihatFile'])->name('lihatFile');

    // ------QCC DOCS START-----


    Route::get('/qcc/register', [QccController::class, 'register'])->name('registerQcc');
    Route::post('/qcc/register', [QccController::class, 'add'])->name('addAnggota');
    Route::get('/anggota/{id}/destroy', [QccController::class, 'destroy'])->name('destroy');
    Route::get('/qcc/notulen1', [QccController::class, 'notulen']);

    Route::get('/qcc/resume', [QccController::class, 'resume'])->name('resumeQcc');
    Route::get('/qcc/data-nqi', [QccController::class, 'dataNqi'])->name('dataNqiQcc');
    Route::get('/qcc/data-circle', [QccController::class, 'dataCircle'])->name('dataCircleQcc');
    
    Route::get('/profile', [AppController::class, 'profile'])->name('profile');
    

    Route::resource('circles', CircleController::class);

    

    // getkaryawan
    Route::get('/karyawan/{npk}', [KaryawanController::class, 'getKaryawanByNPK']);
});