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
use App\Http\Controllers\admin\HostelMemberController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\MarkController;
use App\Http\Controllers\admin\SectionNameContoller;
use App\Http\Controllers\admin\SliderController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\SubjectController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\SyllabusController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\admin\WarehouseController;
use App\Http\Controllers\admin\QuestionGroupController;
use App\Http\Controllers\admin\QuestionLevelController;
use App\Http\Controllers\admin\QuestionBankController;
use App\Http\Controllers\admin\InstructionController;
use App\Http\Controllers\admin\VendorController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\admin\AssetCategoryController;
use App\Http\Controllers\admin\AssetController;
use App\Http\Controllers\admin\AssetAssignmentController;
use App\Http\Controllers\admin\PurchaseController;
use App\Http\Controllers\admin\LeaveCategoryController;
use App\Http\Controllers\admin\LeaveAssignController;
use App\Http\Controllers\admin\LeaveApplyController;
use App\Http\Controllers\admin\LeaveApplicationController;
use App\Http\Controllers\admin\NoticeController;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\admin\HolidayController;
use App\Http\Controllers\admin\TransportController;
use App\Http\Controllers\admin\TransportMemberController;
use App\Http\Controllers\admin\ActivitiesCategoryController;
use App\Http\Controllers\admin\ActivitiesController;
use App\Http\Controllers\admin\ChildCareController;
use App\Http\Controllers\admin\LibraryController;
use App\Http\Controllers\admin\LibraryMemberController;
use App\Http\Controllers\admin\CandidateController;
use App\Http\Controllers\admin\SponsorController;
use App\Http\Controllers\admin\SponsorshipController;
use App\Http\Controllers\admin\FeeTypesController;
use App\Http\Controllers\admin\ExpenseController;
use App\Http\Controllers\admin\IncomeController;
use App\Http\Controllers\admin\BooksController;
use App\Http\Controllers\admin\IssueController;
use App\Http\Controllers\admin\EbooksController;
use App\Http\Controllers\admin\MediaController;
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

    // Hostel member routes
    Route::get('hostel-members', [HostelMemberController::class, 'index'])->name('hostel-members.index');
    Route::get('hostel-members/create/{studentId}', [HostelMemberController::class, 'create'])->name('hostel-members.create');
    Route::post('hostel-members', [HostelMemberController::class, 'store'])->name('hostel-members.store');
    Route::get('hostel-members/{hostelMember}', [HostelMemberController::class, 'show'])->name('hostel-members.show');
    Route::get('hostel-members/{hostelMember}/edit', [HostelMemberController::class, 'edit'])->name('hostel-members.edit');
    Route::put('hostel-members/{hostelMember}', [HostelMemberController::class, 'update'])->name('hostel-members.update');
    Route::delete('hostel-members/{hostelMember}', [HostelMemberController::class, 'destroy'])->name('hostel-members.destroy');
    Route::get('hostel-members/{hostelMember}/pdf', [HostelMemberController::class, 'pdf'])->name('hostel-members.pdf');
    Route::get('/get-hostel-categories/{hostelId}', [HostelMemberController::class, 'getHostelCategories']);

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
    Route::get('/question-bank/{id}/download-pdf', [QuestionBankController::class, 'downloadPdf'])->name('question-bank.download.pdf');

    //instruction
    Route::get('/instruction-list', [InstructionController::class, 'index'])->name('instruction.index');
    Route::get('/instruction-show/{id}', [InstructionController::class, 'show'])->name('instruction.show');
    Route::get('/instruction-create', [InstructionController::class, 'create'])->name('instruction.create');
    Route::post('/instruction-store', [InstructionController::class, 'store'])->name('instruction.store');
    Route::get('/instruction-edit/{id}', [InstructionController::class, 'edit'])->name('instruction.edit');
    Route::put('/instruction-update/{id}', [InstructionController::class, 'update'])->name('instruction.update');
    Route::delete('/instruction-delete/{id}', [InstructionController::class, 'destroy'])->name('instruction.destroy');

    //mark
    Route::get('/mark-list', [MarkController::class, 'index'])->name('mark.index');
    Route::get('/mark-create', [MarkController::class, 'create'])->name('mark.create');
    Route::post('/mark-store', [MarkController::class, 'store'])->name('mark.store');
    Route::get('/mark-edit/{id}', [MarkController::class, 'edit'])->name('mark.edit');
    Route::put('/mark-update/{id}', [MarkController::class, 'update'])->name('mark.update');
    Route::delete('/mark-delete/{id}', [MarkController::class, 'destroy'])->name('mark.destroy');
    Route::post('/get-exam-students', [MarkController::class, 'getExamStudents'])->name('get.exam.students');

    //student
    Route::get('/student-list', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student-create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student-store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student-edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student-update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student-delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

    //vendor
    Route::get('/vendor-list', [VendorController::class, 'index'])->name('vendor.index');
    Route::get('/vendor-create', [VendorController::class, 'create'])->name('vendor.create');
    Route::post('/vendor-store', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor-edit/{id}', [VendorController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor-update/{id}', [VendorController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor-delete/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');

    //location
    Route::get('/location-list', [LocationController::class, 'index'])->name('location.index');
    Route::get('/location-create', [LocationController::class, 'create'])->name('location.create');
    Route::post('/location-store', [LocationController::class, 'store'])->name('location.store');
    Route::get('/location-edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('/location-update/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/location-delete/{id}', [LocationController::class, 'destroy'])->name('location.destroy');

    //asset category
    Route::get('/asset-category-list', [AssetCategoryController::class, 'index'])->name('asset-category.index');
    Route::get('/asset-category-create', [AssetCategoryController::class, 'create'])->name('asset-category.create');
    Route::post('/asset-category-store', [AssetCategoryController::class, 'store'])->name('asset-category.store');
    Route::get('/asset-category-edit/{id}', [AssetCategoryController::class, 'edit'])->name('asset-category.edit');
    Route::put('/asset-category-update/{id}', [AssetCategoryController::class, 'update'])->name('asset-category.update');
    Route::delete('/asset-category-delete/{id}', [AssetCategoryController::class, 'destroy'])->name('asset-category.destroy');

    //asset
    Route::get('/asset-list', [AssetController::class, 'index'])->name('asset.index');
    Route::get('/asset-create', [AssetController::class, 'create'])->name('asset.create');
    Route::post('/asset-store', [AssetController::class, 'store'])->name('asset.store');
    Route::get('/asset-edit/{id}', [AssetController::class, 'edit'])->name('asset.edit');
    Route::put('/asset-update/{id}', [AssetController::class, 'update'])->name('asset.update');
    Route::delete('/asset-delete/{id}', [AssetController::class, 'destroy'])->name('asset.destroy');
    Route::get('/asset-show/{id}', [AssetController::class, 'show'])->name('asset.show');
    Route::get('/assets/{id}/download-pdf', [AssetController::class, 'downloadPdf'])->name('asset.download.pdf');

    //asset assignment
    Route::get('/asset-assignment-list', [AssetAssignmentController::class, 'index'])->name('asset-assignment.index');
    Route::get('/asset-assignment-create', [AssetAssignmentController::class, 'create'])->name('asset-assignment.create');
    Route::post('/asset-assignment-store', [AssetAssignmentController::class, 'store'])->name('asset-assignment.store');
    Route::get('/asset-assignment-edit/{id}', [AssetAssignmentController::class, 'edit'])->name('asset-assignment.edit');
    Route::put('/asset-assignment-update/{id}', [AssetAssignmentController::class, 'update'])->name('asset-assignment.update');
    Route::delete('/asset-assignment-delete/{id}', [AssetAssignmentController::class, 'destroy'])->name('asset-assignment.destroy');
    Route::get('/asset-assignment-show/{id}', [AssetAssignmentController::class, 'show'])->name('asset-assignment.show');
    Route::get('/asset-assignment/{id}/download-pdf', [AssetAssignmentController::class, 'downloadPdf'])->name('asset-assignment.download.pdf');

    //purchase
    Route::get('/purchase-list', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase-create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase-store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase-edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase-update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase-delete/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    Route::put('/purchase-approve/{id}', [PurchaseController::class, 'is_approved'])->name('purchase.is_approved');

    //leave category
    Route::get('/leave-category-list', [LeaveCategoryController::class, 'index'])->name('leave-category.index');
    Route::get('/leave-category-create', [LeaveCategoryController::class, 'create'])->name('leave-category.create');
    Route::post('/leave-category-store', [LeaveCategoryController::class, 'store'])->name('leave-category.store');
    Route::get('/leave-category-edit/{id}', [LeaveCategoryController::class, 'edit'])->name('leave-category.edit');
    Route::put('/leave-category-update/{id}', [LeaveCategoryController::class, 'update'])->name('leave-category.update');
    Route::delete('/leave-category-delete/{id}', [LeaveCategoryController::class, 'destroy'])->name('leave-category.destroy');

    //leave assign
    Route::get('/leave-assign-list', [LeaveAssignController::class, 'index'])->name('leave-assign.index');
    Route::get('/leave-assign-create', [LeaveAssignController::class, 'create'])->name('leave-assign.create');
    Route::post('/leave-assign-store', [LeaveAssignController::class, 'store'])->name('leave-assign.store');
    Route::get('/leave-assign-edit/{id}', [LeaveAssignController::class, 'edit'])->name('leave-assign.edit');
    Route::put('/leave-assign-update/{id}', [LeaveAssignController::class, 'update'])->name('leave-assign.update');
    Route::delete('/leave-assign-delete/{id}', [LeaveAssignController::class, 'destroy'])->name('leave-assign.destroy');

    //leave apply
    Route::get('/leave-apply-list', [LeaveApplyController::class, 'index'])->name('leave-apply.index');
    Route::get('/leave-apply-create', [LeaveApplyController::class, 'create'])->name('leave-apply.create');
    Route::post('/leave-apply-store', [LeaveApplyController::class, 'store'])->name('leave-apply.store');
    Route::get('/leave-apply-edit/{id}', [LeaveApplyController::class, 'edit'])->name('leave-apply.edit');
    Route::put('/leave-apply-update/{id}', [LeaveApplyController::class, 'update'])->name('leave-apply.update');
    Route::delete('/leave-apply-delete/{id}', [LeaveApplyController::class, 'destroy'])->name('leave-apply.destroy');

    //leave application
    Route::get('/leave-application-list', [LeaveApplicationController::class, 'index'])->name('leave-application.index');
    Route::post('/approve/{id}', [LeaveApplicationController::class, 'approve'])->name('leave-application.approve');
    Route::post('/decline/{id}', [LeaveApplicationController::class, 'decline'])->name('leave-application.decline');
    Route::get('/show/{id}', [LeaveApplicationController::class, 'show'])->name('leave-application.show');
    Route::get('/leave-application/pdf/{id}', [LeaveApplicationController::class, 'pdf'])->name('leave-application.pdf');

    //notice
    Route::get('/notice-list', [NoticeController::class, 'index'])->name('notice.index');
    Route::get('/notice-create', [NoticeController::class, 'create'])->name('notice.create');
    Route::post('/notice-store', [NoticeController::class, 'store'])->name('notice.store');
    Route::get('/notice-edit/{id}', [NoticeController::class, 'edit'])->name('notice.edit');
    Route::put('/notice-update/{id}', [NoticeController::class, 'update'])->name('notice.update');
    Route::delete('/notice-delete/{id}', [NoticeController::class, 'destroy'])->name('notice.destroy');
    Route::get('/notice-show/{id}', [NoticeController::class, 'show'])->name('notice.show');
    Route::get('/notice/pdf/{id}', [NoticeController::class, 'pdf'])->name('notice.pdf');

    //event
    Route::get('/event-list', [EventController::class, 'index'])->name('event.index');
    Route::get('/event-create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event-store', [EventController::class, 'store'])->name('event.store');
    Route::get('/event-edit/{id}', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event-update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event-delete/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::get('/event-show/{id}', [EventController::class, 'show'])->name('event.show');
    Route::get('/event/pdf/{id}', [EventController::class, 'pdf'])->name('event.pdf');

    //holiday
    Route::get('/holiday-list', [HolidayController::class, 'index'])->name('holiday.index');
    Route::get('/holiday-create', [HolidayController::class, 'create'])->name('holiday.create');
    Route::post('/holiday-store', [HolidayController::class, 'store'])->name('holiday.store');
    Route::get('/holiday-edit/{id}', [HolidayController::class, 'edit'])->name('holiday.edit');
    Route::put('/holiday-update/{id}', [HolidayController::class, 'update'])->name('holiday.update');
    Route::delete('/holiday-delete/{id}', [HolidayController::class, 'destroy'])->name('holiday.destroy');
    Route::get('/holiday-show/{id}', [HolidayController::class, 'show'])->name('holiday.show');
    Route::get('/holiday/pdf/{id}', [HolidayController::class, 'pdf'])->name('holiday.pdf');

    //transport
    Route::get('/transport-list', [TransportController::class, 'index'])->name('transport.index');
    Route::get('/transport-create', [TransportController::class, 'create'])->name('transport.create');
    Route::post('/transport-store', [TransportController::class, 'store'])->name('transport.store');
    Route::get('/transport-edit/{id}', [TransportController::class, 'edit'])->name('transport.edit');
    Route::put('/transport-update/{id}', [TransportController::class, 'update'])->name('transport.update');
    Route::delete('/transport-delete/{id}', [TransportController::class, 'destroy'])->name('transport.destroy');

    //transport member
    Route::get('transport-members', [TransportMemberController::class, 'index'])->name('transport-members.index');
    Route::get('transport-members/create/{studentId}', [TransportMemberController::class, 'create'])->name('transport-members.create');
    Route::post('transport-members', [TransportMemberController::class, 'store'])->name('transport-members.store');
    Route::get('transport-members/{transportMember}', [TransportMemberController::class, 'show'])->name('transport-members.show');
    Route::get('transport-members/{transportMember}/edit', [TransportMemberController::class, 'edit'])->name('transport-members.edit');
    Route::put('transport-members/{transportMember}', [TransportMemberController::class, 'update'])->name('transport-members.update');
    Route::delete('transport-members/{transportMember}', [TransportMemberController::class, 'destroy'])->name('transport-members.destroy');
    Route::get('get-fare/{transportId}', [TransportMemberController::class, 'getFare'])->name('get-fare');
    Route::get('transport-members/{transportMember}/pdf', [TransportMemberController::class, 'pdf'])->name('transport-members.pdf');

    //activities category
    Route::get('/activities-category-list', [ActivitiesCategoryController::class, 'index'])->name('activities-category.index');
    Route::get('/activities-category-create', [ActivitiesCategoryController::class, 'create'])->name('activities-category.create');
    Route::post('/activities-category-store', [ActivitiesCategoryController::class, 'store'])->name('activities-category.store');
    Route::get('/activities-category-edit/{id}', [ActivitiesCategoryController::class, 'edit'])->name('activities-category.edit');
    Route::put('/activities-category-update/{id}', [ActivitiesCategoryController::class, 'update'])->name('activities-category.update');
    Route::delete('/activities-category-delete/{id}', [ActivitiesCategoryController::class, 'destroy'])->name('activities-category.destroy');

    //activities
    Route::get('/activities-list', [ActivitiesController::class, 'index'])->name('activities.index');
    Route::get('/activities-create', [ActivitiesController::class, 'create'])->name('activities.create');
    Route::post('/activities-store', [ActivitiesController::class, 'store'])->name('activities.store');
    Route::delete('/activities-delete/{id}', [ActivitiesController::class, 'destroy'])->name('activities.destroy');

    //childcare
    Route::get('/childcare-list', [ChildCareController::class, 'index'])->name('childcare.index');
    Route::get('/childcare-create', [ChildCareController::class, 'create'])->name('childcare.create');
    Route::post('/childcare-store', [ChildCareController::class, 'store'])->name('childcare.store');
    Route::get('/childcare-edit/{id}', [ChildCareController::class, 'edit'])->name('childcare.edit');
    Route::put('/childcare-update/{id}', [ChildCareController::class, 'update'])->name('childcare.update');
    Route::delete('/childcare-delete/{id}', [ChildCareController::class, 'destroy'])->name('childcare.destroy');
    Route::get('/get-students-by-class', [ChildCareController::class, 'getStudentsByClass'])->name('get-students-by-class');


    //library
    Route::get('/library-list', [LibraryController::class, 'index'])->name('library.index');
    Route::get('/library-create', [LibraryController::class, 'create'])->name('library.create');
    Route::post('/library-store', [LibraryController::class, 'store'])->name('library.store');
    Route::get('/library-edit/{id}', [LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/library-update/{id}', [LibraryController::class, 'update'])->name('library.update');
    Route::delete('/library-delete/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');

    //library member
    Route::get('library-members', [LibraryMemberController::class, 'index'])->name('library-members.index');
    Route::get('library-members/create/{studentId}', [LibraryMemberController::class, 'create'])->name('library-members.create');
    Route::post('library-members', [LibraryMemberController::class, 'store'])->name('library-members.store');
    Route::get('library-members/{libraryMember}', [LibraryMemberController::class, 'show'])->name('library-members.show');
    Route::get('library-members/{libraryMember}/edit', [LibraryMemberController::class, 'edit'])->name('library-members.edit');
    Route::put('library-members/{libraryMember}', [LibraryMemberController::class, 'update'])->name('library-members.update');
    Route::delete('library-members/{libraryMember}', [LibraryMemberController::class, 'destroy'])->name('library-members.destroy');
    Route::get('library-members/{libraryMember}/pdf', [LibraryMemberController::class, 'pdf'])->name('library-members.pdf');
    Route::get('/get-library-details/{libraryId}', [LibraryMemberController::class, 'getLibraryDetails']);


    //books
    Route::get('/books-list', [BooksController::class, 'index'])->name('books.index');
    Route::get('/books-create', [BooksController::class, 'create'])->name('books.create');
    Route::post('/books-store', [BooksController::class, 'store'])->name('books.store');
    Route::get('/books-edit/{id}', [BooksController::class, 'edit'])->name('books.edit');
    Route::put('/books-update/{id}', [BooksController::class, 'update'])->name('books.update');
    Route::delete('/books-delete/{id}', [BooksController::class, 'destroy'])->name('books.destroy');

    //issue
    Route::get('/issue-list', [IssueController::class, 'index'])->name('issue.index');
    Route::get('/issue-create', [IssueController::class, 'create'])->name('issue.create');
    Route::post('/issue-store', [IssueController::class, 'store'])->name('issue.store');
    Route::get('/issue-edit/{id}', [IssueController::class, 'edit'])->name('issue.edit');
    Route::put('/issue-update/{id}', [IssueController::class, 'update'])->name('issue.update');
    Route::delete('/issue-delete/{id}', [IssueController::class, 'destroy'])->name('issue.destroy');

    //ebooks
    Route::get('/ebooks-list', [EbooksController::class, 'index'])->name('ebooks.index');
    Route::get('/ebooks-create', [EbooksController::class, 'create'])->name('ebooks.create');
    Route::post('/ebooks-store', [EbooksController::class, 'store'])->name('ebooks.store');
    Route::get('/ebooks-edit/{id}', [EbooksController::class, 'edit'])->name('ebooks.edit');
    Route::put('/ebooks-update/{id}', [EbooksController::class, 'update'])->name('ebooks.update');
    Route::delete('/ebooks-delete/{id}', [EbooksController::class, 'destroy'])->name('ebooks.destroy');
    Route::get('/ebooks/view/{ebook}', [EbooksController::class, 'view'])->name('ebooks.view');


    //media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media/folders', [MediaController::class, 'createFolder'])->name('media.createFolder');
    Route::get('/media/folders/{folder}/create', [MediaController::class, 'createFolderForm'])->name('media.createFolderForm');
    Route::post('/media/images', [MediaController::class, 'uploadImage'])->name('media.uploadImage');
    Route::get('/media/folders/{folder}', [MediaController::class, 'showFolder'])->name('media.showFolder');
    Route::delete('/media/{mediaItem}', [MediaController::class, 'destroy'])->name('media.destroy');

    Route::get('/candidate', [CandidateController::class, 'index'])->name('candidate.index');
    Route::get('/candidate/create', [CandidateController::class, 'create'])->name('candidate.create');
    Route::post('/candidate', [CandidateController::class, 'store'])->name('candidate.store');
    Route::get('/candidate/{id}', [CandidateController::class, 'show'])->name('candidate.show');
    Route::get('/candidate/{id}/edit', [CandidateController::class, 'edit'])->name('candidate.edit');
    Route::put('/candidate/{id}', [CandidateController::class, 'update'])->name('candidate.update');
    Route::delete('/candidate/{id}', [CandidateController::class, 'destroy'])->name('candidate.destroy');
    Route::get('/candidate/pdf/{id}', [CandidateController::class, 'pdf'])->name('candidate.pdf');
    Route::get('/get-student-data/{studentId}', [CandidateController::class, 'getStudentData']);

    //sponsor
    Route::get('/sponsor-list', [SponsorController::class, 'index'])->name('sponsor.index');
    Route::get('/sponsor-create', [SponsorController::class, 'create'])->name('sponsor.create');
    Route::post('/sponsor-store', [SponsorController::class, 'store'])->name('sponsor.store');
    Route::get('/sponsor-edit/{id}', [SponsorController::class, 'edit'])->name('sponsor.edit');
    Route::put('/sponsor-update/{id}', [SponsorController::class, 'update'])->name('sponsor.update');
    Route::delete('/sponsor-delete/{id}', [SponsorController::class, 'destroy'])->name('sponsor.destroy');
    Route::get('/sponsor-show/{id}', [SponsorController::class, 'show'])->name('sponsor.show');
    Route::get('/sponsor/pdf/{id}', [SponsorController::class, 'pdf'])->name('sponsor.pdf');

    //sponsorship
    Route::get('/sponsorship-list', [SponsorshipController::class, 'index'])->name('sponsorship.index');
    Route::get('/sponsorship-create', [SponsorshipController::class, 'create'])->name('sponsorship.create');
    Route::post('/sponsorship-store', [SponsorshipController::class, 'store'])->name('sponsorship.store');
    Route::get('/sponsorship-edit/{id}', [SponsorshipController::class, 'edit'])->name('sponsorship.edit');
    Route::put('/sponsorship-update/{id}', [SponsorshipController::class, 'update'])->name('sponsorship.update');
    Route::delete('/sponsorship-delete/{id}', [SponsorshipController::class, 'destroy'])->name('sponsorship.destroy');
    Route::get('/sponsorship-renew/{id}', [SponsorshipController::class, 'renew'])->name('sponsorship.renew');
    Route::post('/renew-sponsorship/{id}', [SponsorshipController::class, 'renew_sponsorship'])->name('sponsorship.renew_sponsorship');

    //feetypes
    Route::get('/fee-types', [FeeTypesController::class, 'index'])->name('fee-types.index');
    Route::get('/fee-types/create', [FeeTypesController::class, 'create'])->name('fee-types.create');
    Route::post('/fee-types', [FeeTypesController::class, 'store'])->name('fee-types.store');
    Route::get('/fee-types/{id}/edit', [FeeTypesController::class, 'edit'])->name('fee-types.edit');
    Route::put('/fee-types/{id}', [FeeTypesController::class, 'update'])->name('fee-types.update');
    Route::delete('/fee-types/{id}', [FeeTypesController::class, 'destroy'])->name('fee-types.destroy');

    //expenses
    Route::get('/expenses-list', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses-create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses-store', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses-edit/{id}', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::post('/expenses-update/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses-delete/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    //incomes
    Route::get('/incomes-list', [IncomeController::class, 'index'])->name('incomes.index');
    Route::get('/incomes-create', [IncomeController::class, 'create'])->name('incomes.create');
    Route::post('/incomes-store', [IncomeController::class, 'store'])->name('incomes.store');
    Route::get('/incomes-edit/{id}', [IncomeController::class, 'edit'])->name('incomes.edit');
    Route::post('/incomes-update/{id}', [IncomeController::class, 'update'])->name('incomes.update');
    Route::delete('/incomes-delete/{id}', [IncomeController::class, 'destroy'])->name('incomes.destroy');

    //Role and User Section
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


});

require __DIR__ . '/auth.php';
