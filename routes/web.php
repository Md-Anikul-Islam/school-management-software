<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AssignmentController;
use App\Http\Controllers\admin\ClassNameController;
use App\Http\Controllers\admin\SectionNameContoller;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\SyllabusController;
use App\Http\Controllers\admin\TeacherController;
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

    //teacher
    Route::get('/teacher-list', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/teacher-create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('/teacher-store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/teacher-edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit');
    Route::get('/teacher-show/{id}', [TeacherController::class, 'show'])->name('teacher.show');
    Route::put('/teacher-update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::delete('/teacher-delete/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
    Route::put('/teacher-update-status/{id}', [TeacherController::class, 'update_status'])->name('teacher.update_status');
    Route::post('/teacher/{id}/upload-document', [TeacherController::class, 'uploadDocument'])->name('teacher.uploadDocument');
    Route::get('/teacher/download-document/{id}', [TeacherController::class, 'downloadDocument'])->name('teacher.downloadDocument');
    Route::post('/teacher/{id}/update-routine', [TeacherController::class, 'updateRoutine'])->name('teacher.updateRoutine');
    Route::get('/teachers/{id}/profile-pdf', [TeacherController::class, 'downloadProfilePdf'])->name('teacher.profilePdf');

    //className
    Route::get('/class-list', [ClassNameController::class, 'index'])->name('class.index');
    Route::get('/class-create', [ClassNameController::class, 'create'])->name('class.create');
    Route::post('/class-store', [ClassNameController::class, 'store'])->name('class.store');
    Route::get('/class-edit/{id}', [ClassNameController::class, 'edit'])->name('class.edit');
    Route::put('/class-update/{id}', [ClassNameController::class, 'update'])->name('class.update');
    Route::delete('/class-delete/{id}', [ClassNameController::class, 'destroy'])->name('class.destroy');

    //section
    Route::get('/section-list', [SectionNameContoller::class, 'index'])->name('section.index');
    Route::get('/section-create', [SectionNameContoller::class, 'create'])->name('section.create');
    Route::post('/section-store', [SectionNameContoller::class, 'store'])->name('section.store');
    Route::get('/section-edit/{id}', [SectionNameContoller::class, 'edit'])->name('section.edit');
    Route::put('/section-update/{id}', [SectionNameContoller::class, 'update'])->name('section.update');
    Route::delete('/section-delete/{id}', [SectionNameContoller::class, 'destroy'])->name('section.destroy');

    //subject
    Route::get('/subject-list', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subject-create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subject-store', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('/subject-edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::put('/subject-update/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject-delete/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    //syllabus
    Route::get('/syllabus-list', [SyllabusController::class, 'index'])->name('syllabus.index');
    Route::get('/syllabus-create', [SyllabusController::class, 'create'])->name('syllabus.create');
    Route::post('/syllabus-store', [SyllabusController::class, 'store'])->name('syllabus.store');
    Route::get('/syllabus-edit/{id}', [SyllabusController::class, 'edit'])->name('syllabus.edit');
    Route::put('/syllabus-update/{id}', [SyllabusController::class, 'update'])->name('syllabus.update');
    Route::delete('/syllabus-delete/{id}', [SyllabusController::class, 'destroy'])->name('syllabus.destroy');

    //assignment
    Route::get('/assignment-list', [AssignmentController::class, 'index'])->name('assignment.index');
    Route::get('/assignment-create', [AssignmentController::class, 'create'])->name('assignment.create');
    Route::post('/assignment-store', [AssignmentController::class, 'store'])->name('assignment.store');
    Route::get('/assignment-edit/{id}', [AssignmentController::class, 'edit'])->name('assignment.edit');
    Route::put('/assignment-update/{id}', [AssignmentController::class, 'update'])->name('assignment.update');
    Route::delete('/assignment-delete/{id}', [AssignmentController::class, 'destroy'])->name('assignment.destroy');
    Route::get('/admin/fetch-sections', [AssignmentController::class, 'fetchSections'])->name('fetch.sections');
    Route::get('/admin/fetch-subjects', [AssignmentController::class, 'fetchSubjects']);


    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


});

require __DIR__.'/auth.php';
