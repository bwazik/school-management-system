<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\SchoolManagement\StagesController;
use App\Http\Controllers\SchoolManagement\GradesController;
use App\Http\Controllers\SchoolManagement\ClassroomsController;
use App\Http\Controllers\SchoolManagement\SubjectsController;
use App\Http\Controllers\Users\ParentsController;
use App\Http\Controllers\Users\TeachersController;
use App\Http\Controllers\StudentsManagement\StudentsController;
use App\Http\Controllers\StudentsManagement\PromotionsController;
use App\Http\Controllers\StudentsManagement\GraduationsController;
use App\Http\Controllers\Finance\FeesController;
use App\Http\Controllers\Finance\InvoicesController;
use App\Http\Controllers\Finance\ReceiptsController;
use App\Http\Controllers\Finance\PaymentsController;
use App\Http\Controllers\Finance\RefundsController;
use App\Http\Controllers\StudentActivities\AttendancesController;
use App\Http\Controllers\StudentActivities\QuizzesController;
use App\Http\Controllers\StudentActivities\QuestionsController;
use App\Http\Controllers\StudentActivities\OnlineClassesController;
use App\Http\Controllers\StudentActivities\LibraryController;
use App\Http\Controllers\Settings\SettingsController;
use Livewire\Livewire;

Auth::routes(['register' => false, 'confirm' => false, 'reset' => false]);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'guest']
    ], function(){
        Auth::routes(['register' => false, 'confirm' => false, 'reset' => false, 'logout' => false]);

        Route::get('/', function () {
            return view('auth.login');
        });
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function(){

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    # Start School Management
        # Stages
        Route::controller(StagesController::class)->group(function() {
            Route::group(['prefix' => 'stages'], function () {
                Route::get('/', 'index')->name('stages');
                Route::post('add', 'add')->name('addStage');
                Route::post('edit', 'edit')->name('editStage');
                Route::post('delete', 'delete')->name('deleteStage');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedStages');
            });
        });

        # Grades
        Route::controller(GradesController::class)->group(function() {
            Route::group(['prefix' => 'grades'], function () {
                Route::get('/', 'index')->name('grades');
                Route::post('add', 'add')->name('addGrade');
                Route::post('edit', 'edit')->name('editGrade');
                Route::post('delete', 'delete')->name('deleteGrade');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedGrades');
                Route::post('filter-by-stage', 'filter')->name('filterByStage');
            });
        });

        # Classrooms
        Route::controller(ClassroomsController::class)->group(function() {
            Route::group(['prefix' => 'classrooms'], function () {
                Route::get('/', 'index')->name('getStagesWithClassrooms');
                Route::get('/{stageId}', 'getAllClassrooms')->name('getAllClassrooms');
                Route::get('/stages/{id}', 'getGradesByAjax')->name('getGradesByAjax');
                Route::get('/grades/{id}', 'getClassroomsByAjax')->name('getClassroomsByAjax');
                Route::get('/teachers/{id}', 'getTeachersByAjax')->name('getTeachersByAjax');
                Route::post('add', 'add')->name('addClassroom');
                Route::post('edit', 'edit')->name('editClassroom');
                Route::post('delete', 'delete')->name('deleteClassroom');
            });
        });

        # Subjects
        Route::controller(SubjectsController::class)->group(function() {
            Route::group(['prefix' => 'subjects'], function () {
                Route::get('/', 'index')->name('subjects');
                Route::post('add', 'add')->name('addSubject');
                Route::post('edit', 'edit')->name('editSubject');
                Route::post('delete', 'delete')->name('deleteSubject');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedSubjects');
            });
        });
    # End School Management

    # Start Users
        # Parents
        Route::group(['prefix' => 'parents'], function () {
            Route::view('/', 'users.parents.index')->name('parents');
            Route::view('/{id}', 'users.parents.edit.index')->name('editParent');

            Route::controller(ParentsController::class)->group(function() {
                Route::post('delete', 'delete')->name('deleteParent');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedParents');

                Route::get('{id}/details', 'parentDetails')->name('parentDetails');
                Route::post('attachments/add/{parent_id}', 'addAttachment')->name('addParentAttachment');
                Route::post('attachment/show/{father_national_id}/{file}', 'showAttachment');
                Route::post('attachment/download/{father_national_id}/{file}', 'downloadAttachment');
                Route::post('attachment/delete/{id}/{father_national_id}/{file}', 'deleteAttachment');
                Route::post('deleteAllAttachments/{parent_id}', 'deleteAllAttachments')->name('deleteAllParentAttachments');

            });
        });

        # Teachers
        Route::controller(TeachersController::class)->group(function() {
            Route::group(['prefix' => 'teachers'], function () {
                Route::get('/', 'index')->name('teachers');
                Route::post('add', 'add')->name('addTeacher');
                Route::post('edit', 'edit')->name('editTeacher');
                Route::post('delete', 'delete')->name('deleteTeacher');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedTeachers');
                Route::get('{id}', 'teacherDetails')->name('teacherDetails');
                Route::post('attachments/add/{teacher_id}', 'addAttachment')->name('addTeacherAttachment');
                Route::post('attachment/show/{email}/{file}', 'showAttachment');
                Route::post('attachment/download/{email}/{file}', 'downloadAttachment');
                Route::post('attachment/delete/{id}/{email}/{file}', 'deleteAttachment');
                Route::post('deleteAllAttachments/{teacher_id}', 'deleteAllAttachments')->name('deleteAllTeacherAttachments');
            });
        });
    # End Users

    # Start Students Management
        # Students
        Route::controller(StudentsController::class)->group(function() {
            Route::group(['prefix' => 'students'], function () {
                Route::get('/', 'index')->name('students');
                Route::post('add', 'add')->name('addStudent');
                Route::post('edit', 'edit')->name('editStudent');
                Route::post('delete', 'delete')->name('deleteStudent');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedStudents');
                Route::post('graduate', 'graduate')->name('mainGraduateStudent');
                Route::post('graduate-selected', 'graduateSelected')->name('mainGraduateSelectedStudents');
                Route::get('{id}', 'studentDetails')->name('studentDetails');
                Route::post('attachments/add/{student_id}', 'addAttachment')->name('addStudentAttachment');
                Route::post('attachment/show/{email}/{file}', 'showAttachment');
                Route::post('attachment/download/{email}/{file}', 'downloadAttachment');
                Route::post('attachment/delete/{id}/{email}/{file}', 'deleteAttachment');
                Route::post('deleteAllAttachments/{student_id}', 'deleteAllAttachments')->name('deleteAllStudentAttachments');
            });
        });

        # Promotions
        Route::controller(PromotionsController::class)->group(function() {
            Route::group(['prefix' => 'promotions'], function () {
                Route::get('/', 'index')->name('promotions');
                Route::post('add', 'add')->name('addPromotion');
                Route::post('revert', 'revert')->name('revertStudent');
                Route::post('revert-selected', 'revertSelected')->name('revertSelectedStudents');
                Route::post('graduate', 'graduate')->name('graduateStudent');
                Route::post('graduate-selected', 'graduateSelected')->name('graduateSelectedStudents');
            });
        });

        # Graduations
        Route::controller(GraduationsController::class)->group(function() {
            Route::group(['prefix' => 'graduations'], function () {
                Route::get('/', 'index')->name('graduations');
                Route::post('add', 'add')->name('addGraduation');
                Route::post('return', 'return')->name('returnStudent');
                Route::post('return-selected', 'returnSelected')->name('returnSelectedStudents');
                Route::post('delete', 'delete')->name('forceDeleteStudent');
                Route::post('delete-selected', 'deleteSelected')->name('forceDeleteSelectedStudents');
            });
        });
    # End Students Management

    # Start Finance
        # Fees
        Route::controller(FeesController::class)->group(function() {
            Route::group(['prefix' => 'fees'], function () {
                Route::get('/', 'index')->name('fees');
                Route::post('add', 'add')->name('addFee');
                Route::post('edit', 'edit')->name('editFee');
                Route::post('delete', 'delete')->name('deleteFee');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedFees');
                Route::get('amount/{id}', 'getFeeAmount')->name('getFeeAmount');
            });
        });

        # Invoices
        Route::controller(InvoicesController::class)->group(function() {
            Route::group(['prefix' => 'invoices'], function () {
                Route::get('/', 'index')->name('invoices');
                Route::get('student/{id}', 'getStudentDetails');
                Route::post('student/add', 'addStudentInvoice')->name('addStudentInvoice');
                Route::post('add', 'add')->name('addInvoice');
                Route::post('delete', 'delete')->name('deleteInvoice');
            });
        });

        # Receipts
        Route::controller(ReceiptsController::class)->group(function() {
            Route::group(['prefix' => 'receipts'], function () {
                Route::get('/', 'index')->name('receipts');
                Route::post('student/add', 'addStudentReceipt')->name('addStudentReceipt');
                Route::post('add', 'add')->name('addReceipt');
                Route::post('edit', 'edit')->name('editReceipt');
                Route::post('delete', 'delete')->name('deleteReceipt');
            });
        });

        # Payments
        Route::controller(PaymentsController::class)->group(function() {
            Route::group(['prefix' => 'payments'], function () {
                Route::get('/', 'index')->name('payments');
                Route::post('student/add', 'addStudentPayment')->name('addStudentPayment');
                Route::post('add', 'add')->name('addPayment');
                Route::post('edit', 'edit')->name('editPayment');
                Route::post('delete', 'delete')->name('deletePayment');
            });
        });

        # Refunds
        Route::controller(RefundsController::class)->group(function() {
            Route::group(['prefix' => 'refunds'], function () {
                Route::get('/', 'index')->name('refunds');
                Route::post('student/add', 'addStudentRefund')->name('addStudentRefund');
                Route::get('student/{id}', 'getStudentBalance');
                Route::post('add', 'add')->name('addRefund');
                Route::post('edit', 'edit')->name('editRefund');
                Route::post('delete', 'delete')->name('deleteRefund');
            });
        });
    # End Finance

    # Start Student Activities
        # Attendances
        Route::controller(AttendancesController::class)->group(function() {
            Route::group(['prefix' => 'attendances'], function () {
                Route::get('/', 'index')->name('attendances');
                Route::get('stage/{stageId}', 'getAllClassrooms')->name('getAllClassroomsAttendance');
                Route::get('/{classroomId}', 'getStudentsWithAttendances')->name('getStudentsWithAttendances');
                Route::post('add', 'add')->name('addAttendance');
            });
        });

        # Quizzes
        Route::controller(QuizzesController::class)->group(function() {
            Route::group(['prefix' => 'quizzes'], function () {
                Route::get('/', 'index')->name('quizzes');
                Route::post('add', 'add')->name('addQuiz');
                Route::post('edit', 'edit')->name('editQuiz');
                Route::post('delete', 'delete')->name('deleteQuiz');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedQuizzes');
            });
        });

        # Questions
        Route::controller(QuestionsController::class)->group(function() {
            Route::group(['prefix' => 'questions'], function () {
                Route::get('/{quizId}', 'index')->name('questions');
                Route::post('add', 'add')->name('addQuestion');
                Route::post('change', 'change')->name('changeAnswer');
                Route::post('edit', 'edit')->name('editQuestion');
                Route::post('delete', 'delete')->name('deleteQuestion');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedQuestions');
            });
        });

        # Online Classes
        Route::controller(OnlineClassesController::class)->group(function() {
            Route::group(['prefix' => 'online-classes'], function () {
                Route::get('/', 'index')->name('onlineClasses');
                Route::post('add', 'add')->name('addOnlineClass');
                Route::post('edit', 'edit')->name('editOnlineClass');
                Route::post('delete', 'delete')->name('deleteOnlineClass');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedOnlineClasses');
            });
        });

        # Library
        Route::controller(LibraryController::class)->group(function() {
            Route::group(['prefix' => 'library'], function () {
                Route::get('/', 'index')->name('library');
                Route::post('add', 'add')->name('addBook');
                Route::post('show/{teacher_email}/{file_name}', 'show');
                Route::post('download/{teacher_email}/{file_name}', 'download');
                Route::post('edit', 'edit')->name('editBook');
                Route::post('delete', 'delete')->name('deleteBook');
                Route::post('delete-selected', 'deleteSelected')->name('deleteSelectedBooks');
            });
        });
    # End Student Activities

    # Start Settings
        Route::controller(SettingsController::class)->group(function() {
            Route::group(['prefix' => 'settings'], function () {
                Route::get('/', 'index')->name('settings');
                Route::post('edit', 'edit')->name('editSettings');
            });
        });
    # End Settings

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });
});
