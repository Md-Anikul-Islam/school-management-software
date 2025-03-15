<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AssignmentController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ClassNameController;
use App\Http\Controllers\admin\ExamController;
use App\Http\Controllers\admin\ExamScheduleController;
use App\Http\Controllers\admin\GradeController;
use App\Http\Controllers\admin\GuardianController;
use App\Http\Controllers\admin\HostelController;
use App\Http\Controllers\admin\HostelCategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SectionNameContoller;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\SyllabusController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\admin\WarehouseController;
use App\Http\Controllers\admin\QuestionGroupController;
use App\Http\Controllers\admin\QuestionLevelController;
use App\Http\Controllers\admin\QuestionBankController;
use App\Http\Controllers\FrontendAdmissionController;
use App\Http\Controllers\FrontendBlogController;
use App\Http\Controllers\FrontendContactController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FrontendEventController;
use App\Http\Controllers\FrontendGalleryController;
use App\Http\Controllers\FrontendNoticeController;
use App\Http\Controllers\FrontendPrivacyController;
use App\Http\Controllers\FrontendTeachersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/', [FrontendController::class, 'index']);
Route::get('/about-us', [AboutUsController::class, 'aboutUs'])->name('about');
Route::get('/teachers', [FrontendTeachersController::class, 'teachers'])->name('teachers');
Route::get('/privacy', [FrontendPrivacyController::class, 'privacy'])->name('privacy');
Route::get('/notice', [FrontendNoticeController::class, 'notice'])->name('notice');
Route::get('/gallery', [FrontendGalleryController::class, 'gallery'])->name('gallery');
Route::get('/blog', [FrontendBlogController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [FrontendBlogController::class, 'blogDetails'])->name('blog.details');
Route::get('/contact', [FrontendContactController::class, 'contact'])->name('contact');
Route::get('/event', [FrontendEventController::class, 'event'])->name('event');
Route::get('/event/{slug}', [FrontendEventController::class, 'eventDetails'])->name('event.details');
Route::get('/admission', [FrontendAdmissionController::class, 'admission'])->name('admission');


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

    //exam
    Route::get('/exam-list', [ExamController::class, 'index'])->name('exam.index');
    Route::get('/exam-create', [ExamController::class, 'create'])->name('exam.create');
    Route::post('/exam-store', [ExamController::class, 'store'])->name('exam.store');
    Route::get('/exam-edit/{id}', [ExamController::class, 'edit'])->name('exam.edit');
    Route::put('/exam-update/{id}', [ExamController::class, 'update'])->name('exam.update');
    Route::delete('/exam-delete/{id}', [ExamController::class, 'destroy'])->name('exam.destroy');

    //exam schedule
    Route::get('/exam-schedule-list', [ExamScheduleController::class, 'index'])->name('exam-schedule.index');
    Route::get('/exam-schedule-create', [ExamScheduleController::class, 'create'])->name('exam-schedule.create');
    Route::post('/exam-schedule-store', [ExamScheduleController::class, 'store'])->name('exam-schedule.store');
    Route::get('/exam-schedule-edit/{id}', [ExamScheduleController::class, 'edit'])->name('exam-schedule.edit');
    Route::put('/exam-schedule-update/{id}', [ExamScheduleController::class, 'update'])->name('exam-schedule.update');
    Route::delete('/exam-schedule-delete/{id}', [ExamScheduleController::class, 'destroy'])->name('exam-schedule.destroy');
    Route::get('/admin/fetch-sections', [ExamScheduleController::class, 'fetchSections'])->name('fetch.sections');
    Route::get('/admin/fetch-subjects', [ExamScheduleController::class, 'fetchSubjects']);

    //grade
    Route::get('/grade-list', [GradeController::class, 'index'])->name('grade.index');
    Route::get('/grade-create', [GradeController::class, 'create'])->name('grade.create');
    Route::post('/grade-store', [GradeController::class, 'store'])->name('grade.store');
    Route::get('/grade-edit/{id}', [GradeController::class, 'edit'])->name('grade.edit');
    Route::put('/grade-update/{id}', [GradeController::class, 'update'])->name('grade.update');
    Route::delete('/grade-delete/{id}', [GradeController::class, 'destroy'])->name('grade.destroy');

    //guardian
    Route::get('/guardian-list', [GuardianController::class, 'index'])->name('guardian.index');
    Route::get('/guardian-create', [GuardianController::class, 'create'])->name('guardian.create');
    Route::post('/guardian-store', [GuardianController::class, 'store'])->name('guardian.store');
    Route::get('/guardian-edit/{id}', [GuardianController::class, 'edit'])->name('guardian.edit');
    Route::put('/guardian-update/{id}', [GuardianController::class, 'update'])->name('guardian.update');
    Route::delete('/guardian-delete/{id}', [GuardianController::class, 'destroy'])->name('guardian.destroy');
    Route::get('/guardian-show/{id}', [GuardianController::class, 'show'])->name('guardian.show');
    Route::put('/guardian-update-status/{id}', [GuardianController::class, 'update_status'])->name('guardian.update_status');
    Route::post('/guardian/{id}/upload-document', [GuardianController::class, 'uploadDocument'])->name('guardian.uploadDocument');
    Route::get('/guardian/download-document/{id}', [GuardianController::class, 'downloadDocument'])->name('guardian.downloadDocument');
    Route::get('/guardians/{id}/profile-pdf', [GuardianController::class, 'downloadProfilePdf'])->name('guardian.profilePdf');

    //category
    Route::get('/category-list', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category-store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category-edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //product
    Route::get('/product-list', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product-store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product-edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product-update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product-delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    //warehouse
    Route::get('/warehouse-list', [WarehouseController::class, 'index'])->name('warehouse.index');
    Route::get('/warehouse-create', [WarehouseController::class, 'create'])->name('warehouse.create');
    Route::post('/warehouse-store', [WarehouseController::class, 'store'])->name('warehouse.store');
    Route::get('/warehouse-edit/{id}', [WarehouseController::class, 'edit'])->name('warehouse.edit');
    Route::put('/warehouse-update/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
    Route::delete('/warehouse-delete/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');

    //supplier
    Route::get('/supplier-list', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/supplier-create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/supplier-store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier-edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier-update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier-delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    //hostel
    Route::get('/hostel-list', [HostelController::class, 'index'])->name('hostel.index');
    Route::get('/hostel-create', [HostelController::class, 'create'])->name('hostel.create');
    Route::post('/hostel-store', [HostelController::class, 'store'])->name('hostel.store');
    Route::get('/hostel-edit/{id}', [HostelController::class, 'edit'])->name('hostel.edit');
    Route::put('/hostel-update/{id}', [HostelController::class, 'update'])->name('hostel.update');
    Route::delete('/hostel-delete/{id}', [HostelController::class, 'destroy'])->name('hostel.destroy');

    //hostel category
    Route::get('/hostel-category-list', [HostelCategoryController::class, 'index'])->name('hostel-category.index');
    Route::get('/hostel-category-create', [HostelCategoryController::class, 'create'])->name('hostel-category.create');
    Route::post('/hostel-category-store', [HostelCategoryController::class, 'store'])->name('hostel-category.store');
    Route::get('/hostel-category-edit/{id}', [HostelCategoryController::class, 'edit'])->name('hostel-category.edit');
    Route::put('/hostel-category-update/{id}', [HostelCategoryController::class, 'update'])->name('hostel-category.update');
    Route::delete('/hostel-category-delete/{id}', [HostelCategoryController::class, 'destroy'])->name('hostel-category.destroy');

    //question group
    Route::get('/question-group-list', [QuestionGroupController::class, 'index'])->name('question-group.index');
    Route::get('/question-group-create', [QuestionGroupController::class, 'create'])->name('question-group.create');
    Route::post('/question-group-store', [QuestionGroupController::class, 'store'])->name('question-group.store');
    Route::get('/question-group-edit/{id}', [QuestionGroupController::class, 'edit'])->name('question-group.edit');
    Route::put('/question-group-update/{id}', [QuestionGroupController::class, 'update'])->name('question-group.update');
    Route::delete('/question-group-delete/{id}', [QuestionGroupController::class, 'destroy'])->name('question-group.destroy');

    //question level
    Route::get('/question-level-list', [QuestionLevelController::class, 'index'])->name('question-level.index');
    Route::get('/question-level-create', [QuestionLevelController::class, 'create'])->name('question-level.create');
    Route::post('/question-level-store', [QuestionLevelController::class, 'store'])->name('question-level.store');
    Route::get('/question-level-edit/{id}', [QuestionLevelController::class, 'edit'])->name('question-level.edit');
    Route::put('/question-level-update/{id}', [QuestionLevelController::class, 'update'])->name('question-level.update');
    Route::delete('/question-level-delete/{id}', [QuestionLevelController::class, 'destroy'])->name('question-level.destroy');

    //question bank
    Route::get('/question-bank-list', [QuestionBankController::class, 'index'])->name('question-bank.index');
    Route::get('/question-bank-create', [QuestionBankController::class, 'create'])->name('question-bank.create');
    Route::post('/question-bank-store', [QuestionBankController::class, 'store'])->name('question-bank.store');
    Route::get('/question-bank-show/{id}', [QuestionBankController::class, 'show'])->name('question-bank.show');
    Route::get('/question-bank-edit/{id}', [QuestionBankController::class, 'edit'])->name('question-bank.edit');
    Route::put('/question-bank-update/{id}', [QuestionBankController::class, 'update'])->name('question-bank.update');
    Route::delete('/question-bank-delete/{id}', [QuestionBankController::class, 'destroy'])->name('question-bank.destroy');



    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


});

require __DIR__.'/auth.php';
