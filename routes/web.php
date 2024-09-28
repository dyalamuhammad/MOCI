<?php

use App\Exports\SsExport;
use App\Http\Controllers\AbsenCbiController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AbsenDtController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CbiController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\DocumentCbiController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentDtController;
use App\Http\Controllers\DtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KsController;
use App\Http\Controllers\NotulenCbiController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\NotulenDtController;
use App\Http\Controllers\QccController;
use App\Http\Controllers\SsController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Excel;

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

Route::get('/', [HomeController::class, 'index'])->name('dashboard-home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [AuthController::class, 'doLogout'])->middleware(['auth'])->name('doLogout');

Route::middleware(['auth', 'Superadmin'])->group(function () {
    // ------Home--------
    Route::get('/moci', [AppController::class, 'index'])->name('home');
   

    Route::post('/power-meter-data', [AppController::class, 'getData'])->name('getPowerMeter');
    Route::get('/power-meter', [AppController::class, 'indexPmm']);


    // Home Admin Dashboard (slides)
    Route::get('/dashboard-admin/slides', [HomeController::class, 'slides'])->name('adminSlides');
    Route::get('/dashboard-admin/slides/forms', [HomeController::class, 'forms'])->name('formSlides');
    Route::post('/slides/forms', [HomeController::class, 'add'])->name('addSlides');
    Route::get('/dashboard-admin/slides/{id}/edit', [HomeController::class, 'edit'])->name('editSlides');
    Route::put('/dashboard-admin/slides/{id}/edit', [HomeController::class, 'update'])->name('updateSlides');
    Route::delete('/dashboard-admin/slides/{id}/delete', [HomeController::class, 'softDelete'])->name('softDeleteSlide');
    // Home Admin Dashboard
    Route::get('/dashboard-admin', [HomeController::class, 'admin'])->name('adminHome');
    Route::put('/dashboard-admin/upload', [HomeController::class, 'updateGeneralSettings'])->name('uploadAdmin');
    Route::post('/knowledge-sharing/upload', [KsController::class, 'add'])->name('uploadFileKs');

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

    // ------DT-------------
    Route::get('/dt/monitor/{id?}', [DtController::class, 'index'])->name('monitorDt');
    Route::get('/dt/monitor/circle/{circle_id}', [DtController::class, 'member'])->name('detailCircleDt');
    Route::get('/dt/resume', [DtController::class, 'resume'])->name('resumeDt');

    /*
    ===============================
    ---------ADMIN STARTS HERE-----
    ===============================
    */
    // ------KARYAWAN----------
    Route::get('/admin/karyawan', [AdminController::class, 'index'])->name('karyawan');
    Route::get('/admin/karyawan/form', [AdminController::class, 'form'])->name('form');
    Route::post('/admin/karyawan', [AdminController::class, 'add'])->name('add');
    Route::get('/admin/karyawan/{id}/edit', [AdminController::class, 'editUser'])->name('edit-user');
    Route::put('/admin/karyawan/{id}/edit', [AdminController::class, 'updateUser'])->name('update-user');
    Route::post('/admin/karyawan/import', [AdminController::class, 'import'])->name('importUsers');
    Route::get('/admin/download-format', [AdminController::class, 'downloadFormat'])->name('downloadFormatUser');
    Route::get('/admin/download-list', [AdminController::class, 'downloadList'])->name('downloadListUser');
    Route::get('/search-users', [AdminController::class, 'searchUsers'])->name('searchUsers');
    Route::get('/admin/karyawan/{id}', [AdminController::class, 'softDeleteUser'])->name('softDeleteUser');
    // -------KARYAWAN END-------

    // ------PERIODE & LANGKAH-----
    Route::get('/admin/control-step', [AdminController::class, 'controlStep'])->name('controlStep');
    Route::get('/admin/control-period', [AdminController::class, 'controlPeriod'])->name('controlPeriod');
    Route::post('/admin/control-period', [AdminController::class, 'tambahBaris'])->name('tambah-baris');
    Route::get('/admin/control-period/{id}/edit', [AdminController::class, 'editPeriode'])->name('edit-periode');
    Route::put('/admin/control-period/{id}/edit', [AdminController::class, 'updatePeriode'])->name('update-periode');
    Route::get('/admin/control-step/{id}', [AdminController::class, 'softDelete']);
    // ------PERIODE & LANGKAH END-----
    
    // --------MEMBER START----------
    Route::get('/admin/control-member', [AdminController::class, 'controlMember'])->name('control-member');
    Route::post('/admin/pindah-circle', [AdminController::class, 'pindahCircle'])->name('pindah-circle');
    // --------MEMBER END------------

    // --------LEADER START----------
    Route::get('/admin/control-leader', [AdminController::class, 'controlLeader'])->name('control-leader');
    Route::post('/admin/pindah-leader', [AdminController::class, 'pindahLeader'])->name('pindah-leader');
    Route::post('/update-npk-leader', [AdminController::class, 'updateNpkLeader'])->name('update.npk_leader');
    Route::post('/update-npk-leader-dt', [AdminController::class, 'updateNpkLeaderDt'])->name('update.npk_leader_dt');
    // --------LEADER START----------
    
    // --------ORGANIZATION START--------
    // group
    Route::get('/admin/control-group', [AdminController::class, 'group'])->name('group');
    Route::get('/admin/control-group/form', [AdminController::class, 'formGroup'])->name('form-group');
    Route::post('/admin/control-group', [AdminController::class, 'addGroup'])->name('add-group');
    Route::get('/admin/control-group/{id}/edit', [AdminController::class, 'editGroup'])->name('edit-group');
    Route::put('/admin/control-group/{id}/edit', [AdminController::class, 'updateGroup'])->name('update-group');
    Route::get('/admin/control-group/{id}', [AdminController::class, 'softDeleteGroup'])->name('softDeleteGroup');
    Route::post('/admin/control-group/import', [AdminController::class, 'importGroup'])->name('importGroup');
    Route::get('/admin/download-format-group', [AdminController::class, 'downloadGroup'])->name('downloadFormatGroup');

    // section
    Route::get('/admin/control-section', [AdminController::class, 'section'])->name('section');
    Route::get('/admin/control-section/form', [AdminController::class, 'formSection'])->name('form-section');
    Route::post('/admin/control-section', [AdminController::class, 'addSection'])->name('add-section');
    Route::get('/admin/control-section/{id}/edit', [AdminController::class, 'editSection'])->name('edit-section');
    Route::put('/admin/control-section/{id}/edit', [AdminController::class, 'updateSection'])->name('update-section');
    Route::get('/admin/control-section/{id}', [AdminController::class, 'softDeleteSection'])->name('softDeleteSection');
    Route::post('/admin/control-section/import', [AdminController::class, 'importSection'])->name('importSection');
    Route::get('/admin/download-format-section', [AdminController::class, 'downloadSection'])->name('downloadFormatSection');
    // department
    Route::get('/admin/control-department', [AdminController::class, 'department'])->name('department');
    Route::get('/admin/control-department/form', [AdminController::class, 'formDepartment'])->name('form-department');
    Route::post('/admin/control-department', [AdminController::class, 'addDepartment'])->name('add-department');
    Route::get('/admin/control-department/{id}/edit', [AdminController::class, 'editDepartment'])->name('edit-department');
    Route::put('/admin/control-department/{id}/edit', [AdminController::class, 'updateDepartment'])->name('update-department');
    Route::get('/admin/control-department/{id}', [AdminController::class, 'softDeleteDepartment'])->name('softDeleteDepartment');
    Route::post('/admin/control-dept/import', [AdminController::class, 'importDept'])->name('importDept');
    Route::get('/admin/download-format-dept', [AdminController::class, 'downloadDept'])->name('downloadFormatDept');

    
    
    // --------ORGANIZATION ENDS---------



    Route::resource('circles', CircleController::class);

    

    // getkaryawan
    Route::get('/karyawan/{npk}', [KaryawanController::class, 'getKaryawanByNPK'])->name('getKaryawan');
    // export karyawan
    Route::get('export-users', [AdminController::class, 'exportUsers'])->name('export.users');

    /*
    ===============================
    ---------ADMIN ENDS HERE-------
    ===============================
    */

    /*
    ===============================
    ---------SS STARTS HERE--------
    ===============================
    */
    Route::post('/ss/clean-files-ss', [SsController::class, 'cleanFilesSs'])->name('cleanFileSsTahunan');
    Route::post('/ss/clean-files', [SsController::class, 'cleanFiles'])->name('clean-files-ss');
    Route::post('/delete-selected', [SsController::class, 'deleteSelected'])->name('deleteSelected');


    Route::get('/download-format-bulanan', [SsController::class, 'downloadFormatBulanan'])->name('downloadFormatSsBulanan');
    Route::get('/download-format', [SsController::class, 'downloadFormat'])->name('downloadFormatSs');
    Route::get('/ss', [SsController::class, 'index'])->name('ss');
    Route::get('/ss-bulanan', [SsController::class, 'ssBulanan'])->name('ssBulanan');
    Route::post('/ss-bulanan', [SsController::class, 'importBulanan'])->name('importSsBulanan');
    Route::post('/ss', [SsController::class, 'import'])->name('importSs');
    // Route::get('/export-ss', function () {
    //     return Excel::download(new SsExport, 'ss.xlsx');
    // });
    /*
    ===============================
    ---------SS ENDS HERE--------
    ===============================
    */
});


Route::middleware(['auth', 'Management'])->group(function () {
    // ------Home--------
   
    
    

    // Knowledge Sharing
    Route::get('/knowledge-sharing', [KsController::class, 'index'])->name('home-ks');
    Route::post('/knowledge-sharing/upload', [KsController::class, 'add'])->name('uploadFileKs');
    Route::post('/clean-files', [KsController::class, 'cleanFiles'])->name('clean-files');




    // ---------------MOCI--------------------
    Route::get('/dashboard-moci', [AppController::class, 'praDashboard'])->name('pra-moci');
    Route::get('/moci', [AppController::class, 'index'])->name('home');
    Route::get('/profile', [AppController::class, 'profile'])->name('profile');
    Route::post('/profile', [AppController::class, 'editPassword'])->name('editPassword');
    Route::post('/profile/edit', [AppController::class, 'editProfile'])->name('edit-profile');

    /*
    ===============================
    ---------QCC STARTS HERE-------
    ===============================
    */
    Route::get('/qcc/monitor/{id?}', [QccController::class, 'index'])->name('monitorQcc');
    Route::get('/qcc/monitor/circle/{circle_id}', [QccController::class, 'member'])->name('detailCircle');
    Route::get('/qcc/register', [QccController::class, 'register'])->name('registerQcc');
    Route::post('/qcc/register', [QccController::class, 'add'])->name('addAnggota');
    Route::get('/qcc/resume', [QccController::class, 'resume'])->name('resumeQcc');
    Route::get('/qcc/data-nqi', [QccController::class, 'dataNqi'])->name('dataNqiQcc');
    Route::get('/qcc/data-circle', [QccController::class, 'dataCircle'])->name('dataCircleQcc');
    Route::get('/anggota/{id}/destroy', [QccController::class, 'destroy'])->name('destroy');
    Route::get('/qcc/notulen1', [QccController::class, 'notulen']);

    // ------QCC ABSENSI START----
    Route::get('/qcc/absensi', [QccController::class, 'absensi'])->name('absensiQcc');
    Route::get('/qcc/absensi/form/1', [AbsenController::class, 'form'])->name('formAbsensi');
    Route::get('/qcc/absensi/form/1/{id}', [AbsenController::class, 'update'])->name('updateNotulen');
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
    Route::get('/download-nqi-file/{fileName}', [DocumentController::class, 'downloadNqiFile'])->name('download_nqi_file');
    
    Route::get('/lihat-file/{nama_file}', [DocumentController::class, 'lihatFile'])->name('lihatFile');
    // ------QCC DOCS END-----

    // ------QCC APPROVE START-----
    Route::post('/approve-circle/1/{id}', [CircleController::class, 'approve'])->name('approveQcc1');
    Route::post('/approve-circle/2/{id}', [CircleController::class, 'approveL2'])->name('approveQcc2');
    Route::post('/approve-circle/3/{id}', [CircleController::class, 'approveL3'])->name('approveQcc3');
    Route::post('/approve-circle/4/{id}', [CircleController::class, 'approveL4'])->name('approveQcc4');
    Route::post('/approve-circle/5/{id}', [CircleController::class, 'approveL5'])->name('approveQcc5');
    Route::post('/approve-circle/6/{id}', [CircleController::class, 'approveL6'])->name('approveQcc6');
    Route::post('/approve-circle/7/{id}', [CircleController::class, 'approveL7'])->name('approveQcc7');
    Route::post('/approve-circle/8/{id}', [CircleController::class, 'approveL8'])->name('approveQcc8');
    Route::post('/approve-circle/9/{id}', [CircleController::class, 'approveL9'])->name('approveQcc9');
    // ------QCC APPROVE END-----

    // -------QCC APPROVE WITH COMMENT START-------
    Route::post('/approve-comment/1', [ApproveController::class, 'approveComment'])->name('approveCommentQcc');
    Route::post('/approve-comment/2', [ApproveController::class, 'approveComment2'])->name('approveCommentQcc2');
    Route::post('/approve-comment/3', [ApproveController::class, 'approveComment3'])->name('approveCommentQcc3');
    Route::post('/approve-comment/4', [ApproveController::class, 'approveComment4'])->name('approveCommentQcc4');
    Route::post('/approve-comment/5', [ApproveController::class, 'approveComment5'])->name('approveCommentQcc5');
    Route::post('/approve-comment/6', [ApproveController::class, 'approveComment6'])->name('approveCommentQcc6');
    Route::post('/approve-comment/7', [ApproveController::class, 'approveComment7'])->name('approveCommentQcc7');
    Route::post('/approve-comment/8', [ApproveController::class, 'approveComment8'])->name('approveCommentQcc8');
    Route::post('/approve-comment/9', [ApproveController::class, 'approveComment9'])->name('approveCommentQcc9');
    // -------QCC APPROVE WITH COMMENT END-------


    Route::resource('circles', CircleController::class);

    

    // getkaryawan
    Route::get('/karyawan/{npk}', [KaryawanController::class, 'getKaryawanByNPK'])->name('getKaryawan');

    /*
    ===============================
    ---------QCC ENDS HERE---------
    ===============================
    */

    /*
    ===============================
    ---------DT STARTS HERE--------
    ===============================
    */
    Route::get('/dt/monitor/{id?}', [DtController::class, 'index'])->name('monitorDt');
    Route::get('/dt/monitor/circle/{circle_id}', [DtController::class, 'member'])->name('detailCircleDt');
    Route::get('/dt/resume', [DtController::class, 'resume'])->name('resumeDt');
    Route::get('/dt/register', [DtController::class, 'register'])->name('registerDt');
    // Route::post('/dt/register', [DtController::class, 'add'])->name('addAnggotaDt');
    Route::post('/dt/register', [CircleController::class, 'storeDt'])->name('addAnggotaDt');

    
    // -----DT ABSENSI START----
    Route::get('/dt/absensi', [DtController::class, 'absensi'])->name('absensiDt');
    Route::get('/dt/absensi/form/1', [AbsenDtController::class, 'form'])->name('formAbsensiDt');
    Route::get('/dt/absensi/form/2', [AbsenDtController::class, 'form2'])->name('formAbsensiDt2')->middleware('check.schedule');
    Route::get('/dt/absensi/form/3', [AbsenDtController::class, 'form3'])->name('formAbsensiDt3');
    Route::get('/dt/absensi/form/4', [AbsenDtController::class, 'form4'])->name('formAbsensiDt4');
    Route::get('/dt/absensi/form/5', [AbsenDtController::class, 'form5'])->name('formAbsensiDt5');
    Route::get('/dt/absensi/form/6', [AbsenDtController::class, 'form6'])->name('formAbsensiDt6');
    Route::get('/dt/absensi/form/7', [AbsenDtController::class, 'form7'])->name('formAbsensiDt7');
    Route::get('/dt/absensi/form/8', [AbsenDtController::class, 'form8'])->name('formAbsensiDt8');
    Route::get('/dt/absensi/form/9', [AbsenDtController::class, 'form9'])->name('formAbsensiDt9');
    // -----DT ABSENSI END----

    // ------DT NOTULEN START------
    Route::post('/dt/absensi/form/1', [NotulenDtController::class, 'add'])->name('addNotulenDt');
    Route::post('/dt/absensi/form/2', [NotulenDtController::class, 'add_2'])->name('addNotulenDt2');
    Route::post('/dt/absensi/form/3', [NotulenDtController::class, 'add_3'])->name('addNotulenDt3');
    Route::post('/dt/absensi/form/4', [NotulenDtController::class, 'add_4'])->name('addNotulenDt4');
    Route::post('/dt/absensi/form/5', [NotulenDtController::class, 'add_5'])->name('addNotulenDt5');
    Route::post('/dt/absensi/form/6', [NotulenDtController::class, 'add_6'])->name('addNotulenDt6');
    Route::post('/dt/absensi/form/7', [NotulenDtController::class, 'add_7'])->name('addNotulenDt7');
    Route::post('/dt/absensi/form/8', [NotulenDtController::class, 'add_8'])->name('addNotulenDt8');
    Route::post('/dt/absensi/form/9', [NotulenDtController::class, 'add_9'])->name('addNotulenDt9');
    // ------DT NOTULEN END-----

    // ------DT DOCS START-----
    Route::get('/dt/absensi/doc/1', [DocumentDtController::class, 'doc1'])->name('docDt1');
    Route::get('/dt/absensi/download-pdf', [AbsenController::class, 'downloadPdf'])->name('downloadPdf');
    Route::get('/dt/absensi/doc/2', [DocumentDtController::class, 'doc2'])->name('docDt2');
    Route::get('/dt/absensi/doc/3', [DocumentDtController::class, 'doc3'])->name('docDt3');
    Route::get('/dt/absensi/doc/4', [DocumentDtController::class, 'doc4'])->name('docDt4');
    Route::get('/dt/absensi/doc/5', [DocumentDtController::class, 'doc5'])->name('docDt5');
    Route::get('/dt/absensi/doc/6', [DocumentDtController::class, 'doc6'])->name('docDt6');
    Route::get('/dt/absensi/doc/7', [DocumentDtController::class, 'doc7'])->name('docDt7');
    Route::get('/dt/absensi/doc/8', [DocumentDtController::class, 'doc8'])->name('docDt8');
    Route::get('/dt/absensi/doc/9', [DocumentDtController::class, 'doc9'])->name('docDt9');
    // lihat nqi file
    Route::get('/download-nqi-file/{fileName}', [DocumentDtController::class, 'downloadNqiFile'])->name('download_nqi_file');
    Route::get('/lihat-file/{nama_file}', [DocumentDtController::class, 'lihatFile'])->name('lihatFile');
    // ------DT DOCS END-----

    // ------DT APPROVE START-----
    Route::post('/approve-dt/1/{id}', [CircleController::class, 'approveDt'])->name('approveDt1');
    Route::post('/approve-dt/2/{id}', [CircleController::class, 'approveDt2'])->name('approveDt2');
    Route::post('/approve-dt/3/{id}', [CircleController::class, 'approveDt3'])->name('approveDt3');
    Route::post('/approve-dt/4/{id}', [CircleController::class, 'approveDt4'])->name('approveDt4');
    Route::post('/approve-dt/5/{id}', [CircleController::class, 'approveDt5'])->name('approveDt5');
    Route::post('/approve-dt/6/{id}', [CircleController::class, 'approveDt6'])->name('approveDt6');
    Route::post('/approve-dt/7/{id}', [CircleController::class, 'approveDt7'])->name('approveDt7');
    Route::post('/approve-dt/8/{id}', [CircleController::class, 'approveDt8'])->name('approveDt8');
    Route::post('/approve-dt/9/{id}', [CircleController::class, 'approveDt9'])->name('approveDt9');
    // ------DT APPROVE END-----

    // -------DT APPROVE WITH COMMENT START-------
    Route::post('/approve-comment-dt/1', [ApproveController::class, 'approveCommentDt'])->name('approveCommentDt');
    Route::post('/approve-comment-dt/2', [ApproveController::class, 'approveCommentDt2'])->name('approveCommentDt2');
    Route::post('/approve-comment-dt/3', [ApproveController::class, 'approveCommentDt3'])->name('approveCommentDt3');
    Route::post('/approve-comment-dt/4', [ApproveController::class, 'approveCommentDt4'])->name('approveCommentDt4');
    Route::post('/approve-comment-dt/5', [ApproveController::class, 'approveCommentDt5'])->name('approveCommentDt5');
    Route::post('/approve-comment-dt/6', [ApproveController::class, 'approveCommentDt6'])->name('approveCommentDt6');
    Route::post('/approve-comment-dt/7', [ApproveController::class, 'approveCommentDt7'])->name('approveCommentDt7');
    Route::post('/approve-comment-dt/8', [ApproveController::class, 'approveCommentDt8'])->name('approveCommentDt8');
    Route::post('/approve-comment-dt/9', [ApproveController::class, 'approveCommentDt9'])->name('approveCommentDt9');
    // -------DT APPROVE WITH COMMENT END-------
    
    /*
    ===============================
    ---------DT ENDS HERE----------
    ===============================
    */

    
    /*
    ===============================
    ---------CBI STARTS HERE-------
    ===============================
    */
    Route::get('/cbi/monitor/{id?}', [CbiController::class, 'index'])->name('monitorCbi');
    Route::get('/cbi/monitor/circle/{circle_id}', [CbiController::class, 'member'])->name('detailCircleCbi');
    Route::get('/cbi/resume', [CbiController::class, 'resume'])->name('resumeCbi');
    
    // -----CBI ABSENSI START----
    Route::get('/cbi/absensi', [CbiController::class, 'absensi'])->name('absensiCbi');
    Route::get('/cbi/absensi/form/1', [AbsenCbiController::class, 'form'])->name('formAbsensiCbi');
    Route::get('/cbi/absensi/form/2', [AbsenCbiController::class, 'form2'])->name('formAbsensiCbi2')->middleware('check.schedule');
    Route::get('/cbi/absensi/form/3', [AbsenCbiController::class, 'form3'])->name('formAbsensiCbi3');
    Route::get('/cbi/absensi/form/4', [AbsenCbiController::class, 'form4'])->name('formAbsensiCbi4');
    Route::get('/cbi/absensi/form/5', [AbsenCbiController::class, 'form5'])->name('formAbsensiCbi5');
    Route::get('/cbi/absensi/form/6', [AbsenCbiController::class, 'form6'])->name('formAbsensiCbi6');
    Route::get('/cbi/absensi/form/7', [AbsenCbiController::class, 'form7'])->name('formAbsensiCbi7');
    Route::get('/cbi/absensi/form/8', [AbsenCbiController::class, 'form8'])->name('formAbsensiCbi8');
    Route::get('/cbi/absensi/form/9', [AbsenCbiController::class, 'form9'])->name('formAbsensiCbi9');
    // -----CBI ABSENSI END----

    // ------CBI NOTULEN START------
    Route::post('/cbi/absensi/form/1', [NotulenCbiController::class, 'add'])->name('addNotulenCbi');
    Route::post('/cbi/absensi/form/2', [NotulenCbiController::class, 'add_2'])->name('addNotulenCbi2');
    Route::post('/cbi/absensi/form/3', [NotulenCbiController::class, 'add_3'])->name('addNotulenCbi3');
    Route::post('/cbi/absensi/form/4', [NotulenCbiController::class, 'add_4'])->name('addNotulenCbi4');
    Route::post('/cbi/absensi/form/5', [NotulenCbiController::class, 'add_5'])->name('addNotulenCbi5');
    Route::post('/cbi/absensi/form/6', [NotulenCbiController::class, 'add_6'])->name('addNotulenCbi6');
    Route::post('/cbi/absensi/form/7', [NotulenCbiController::class, 'add_7'])->name('addNotulenCbi7');
    Route::post('/cbi/absensi/form/8', [NotulenCbiController::class, 'add_8'])->name('addNotulenCbi8');
    Route::post('/cbi/absensi/form/9', [NotulenCbiController::class, 'add_9'])->name('addNotulenCbi9');
    // ------CBI NOTULEN END-----

    // ------CBI DOCS START-----
    Route::get('/cbi/absensi/doc/1', [DocumentCbiController::class, 'doc1'])->name('docCbi1');
    Route::get('/cbi/absensi/download-pdf', [AbsenController::class, 'downloadPdf'])->name('downloadPdf');
    Route::get('/cbi/absensi/doc/2', [DocumentCbiController::class, 'doc2'])->name('docCbi2');
    Route::get('/cbi/absensi/doc/3', [DocumentCbiController::class, 'doc3'])->name('docCbi3');
    Route::get('/cbi/absensi/doc/4', [DocumentCbiController::class, 'doc4'])->name('docCbi4');
    Route::get('/cbi/absensi/doc/5', [DocumentCbiController::class, 'doc5'])->name('docCbi5');
    Route::get('/cbi/absensi/doc/6', [DocumentCbiController::class, 'doc6'])->name('docCbi6');
    Route::get('/cbi/absensi/doc/7', [DocumentCbiController::class, 'doc7'])->name('docCbi7');
    Route::get('/cbi/absensi/doc/8', [DocumentCbiController::class, 'doc8'])->name('docCbi8');
    Route::get('/cbi/absensi/doc/9', [DocumentCbiController::class, 'doc9'])->name('docCbi9');
    // ------CBI DOCS END-----
    
    // ------CBI APPROVE START-----
    Route::post('/approve-cbi/1/{id}', [CircleController::class, 'approveCbi'])->name('approveCbi1');
    Route::post('/approve-cbi/2/{id}', [CircleController::class, 'approveCbi2'])->name('approveCbi2');
    Route::post('/approve-cbi/3/{id}', [CircleController::class, 'approveCbi3'])->name('approveCbi3');
    Route::post('/approve-cbi/4/{id}', [CircleController::class, 'approveCbi4'])->name('approveCbi4');
    Route::post('/approve-cbi/5/{id}', [CircleController::class, 'approveCbi5'])->name('approveCbi5');
    Route::post('/approve-cbi/6/{id}', [CircleController::class, 'approveCbi6'])->name('approveCbi6');
    Route::post('/approve-cbi/7/{id}', [CircleController::class, 'approveCbi7'])->name('approveCbi7');
    Route::post('/approve-cbi/8/{id}', [CircleController::class, 'approveCbi8'])->name('approveCbi8');
    Route::post('/approve-cbi/9/{id}', [CircleController::class, 'approveCbi9'])->name('approveCbi9');
    // ------CBI APPROVE END-----
    
    // -------CBI APPROVE WITH COMMENT START-------
    Route::post('/approve-comment-cbi/1', [ApproveController::class, 'approveCommentCbi'])->name('approveCommentCbi');
    Route::post('/approve-comment-cbi/2', [ApproveController::class, 'approveCommentCbi2'])->name('approveCommentCbi2');
    Route::post('/approve-comment-cbi/3', [ApproveController::class, 'approveCommentCbi3'])->name('approveCommentCbi3');
    Route::post('/approve-comment-cbi/4', [ApproveController::class, 'approveCommentCbi4'])->name('approveCommentCbi4');
    Route::post('/approve-comment-cbi/5', [ApproveController::class, 'approveCommentCbi5'])->name('approveCommentCbi5');
    Route::post('/approve-comment-cbi/6', [ApproveController::class, 'approveCommentCbi6'])->name('approveCommentCbi6');
    Route::post('/approve-comment-cbi/7', [ApproveController::class, 'approveCommentCbi7'])->name('approveCommentCbi7');
    Route::post('/approve-comment-cbi/8', [ApproveController::class, 'approveCommentCbi8'])->name('approveCommentCbi8');
    Route::post('/approve-comment-cbi/9', [ApproveController::class, 'approveCommentCbi9'])->name('approveCommentCbi9');
    // -------CBI APPROVE WITH COMMENT END-------
    
    /*
    ===============================
    ---------CBI ENDS HERE---------
    ===============================
    */
    
    
    
    
    /*
    ===============================
    ---------SS STARTS HERE---------
    ===============================
    */

    Route::get('/ss', [SsController::class, 'index'])->name('ss');
    Route::get('/ss-bulanan', [SsController::class, 'ssBulanan'])->name('ssBulanan');
    /*
    ===============================
    ---------SS ENDS HERE---------
    ===============================
    */

});