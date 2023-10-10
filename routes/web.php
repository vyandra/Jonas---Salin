<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\StudentController;
use App\Models\Jurusan;
use App\Http\Controllers\JurusanController;

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

// Route::get('/', [ProductController::class, 'index']);
// Route::get('/cart', [ProductController::class, 'cart']);
// Route::get('/categories', [ProductController::class, 'categories']);



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){

    Route::get('dashboard', [DashboardController::class, 'index']);

 // Rute untuk menampilkan semua siswa
 Route::get('dashboard', [StudentController::class, 'dashboard'])->name('admin.dashboard');

 // Rute untuk menampilkan form penambahan siswa
 Route::get('dashboard-add', [StudentController::class, 'create'])->name('student.create');

 // Rute untuk menyimpan data siswa baru
 Route::post('dashboard-add', [StudentController::class, 'store'])->name('student.store');

   // Rute untuk menampilkan form edit siswa
   Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

   // Rute untuk memperbarui data siswa
   Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');

   Route::get('/admin/restore', [StudentController::class, 'restore'])->name('admin.restore');

 Route::resource('students', StudentController::class);
 Route::get('admin/student-detail/{id}', [StudentController::class, 'getStudentDetail'])->name('student.detail');


    Route::get('master_karyawan', [DashboardController::class, 'karyawan'])->name('admin.master_karyawan');

    Route::get('/files', [DashboardController::class, 'master_karyawan'])->name('files.index');
    Route::post('/files', 'FileController@store')->name('files.store');

    Route::get('/dashboard/files/{id}/detail', [DashboardController::class, 'showFileDetail'])->name('dashboard.showFileDetail');

    // Define the dashboard.upload route here
    Route::post('/dashboard/upload', [DashboardController::class, 'upload'])->name('dashboard.upload');


     Route::get('/dashboard/files/{id}/edit', [DashboardController::class, 'editFile'])->name('dashboard.editFile');

     Route::put('/dashboard/files/{id}', [DashboardController::class, 'updateFile'])->name('dashboard.updateFile');

    Route::delete('/dashboard/files/{id}', [DashboardController::class, 'deleteFile'])->name('dashboard.deleteFile');

    Route::get('/pdf-viewer/{id}', [DashboardController::class, 'showPdfViewer'])->name('pdf-viewer');

    Route::get('/admin/master_karyawan/create', [DashboardController::class, 'createEmployeeForm'])->name('dashboard.createEmployeeForm');

    Route::post('/admin/master_karyawan/store', [DashboardController::class, 'storeEmployee'])->name('dashboard.storeEmployee');

    Route::get('/admin/restore-all', [DashboardController::class, 'restoreAll'])->name('admin.restoreAll');


    Route::get('admin/student-details/{id}', [StudentController::class, 'showStudentDetails'])->name('student.details');



});
