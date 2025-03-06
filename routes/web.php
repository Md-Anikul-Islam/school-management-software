<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(callback: function () {

    //Slider Section
    Route::get('/slider-list', [SliderController::class, 'index'])->name('slider.list');
    Route::post('/slider-store', [SliderController::class, 'store'])->name('slider.store');
    Route::put('/slider-update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::get('/slider-delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/unauthorized-action', [AdminDashboardController::class, 'unauthorized'])->name('unauthorized.action');

    //student
    Route::get('/student-list', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student-create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student-store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student-edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::get('/student-show/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::put('/student-update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student-delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    Route::put('/student-update-status/{id}', [StudentController::class, 'update_status'])->name('student.update_status');


    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


});

require __DIR__.'/auth.php';
