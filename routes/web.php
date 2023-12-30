<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\Auth_Admin\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CreditClassController;
use App\Http\Controllers\RegisterClassController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\StudentPointController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;

Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdmin'], function () {
	// get home page admin 
	Route::get('/', [AdminController::class, 'homePage']);
	Route::get('/home', [AdminController::class, 'homePage']);

	// get change pass
	Route::get('/change/password', [LoginController::class, 'getChangePassword']);
	Route::post('/change/password', [LoginController::class, 'changePassword']);

	// school year 
	Route::resource('school-year', SchoolYearController::class);
	Route::get('/new/school-year', function () {
		return view('school_year.new');
	});

	// faculty
	Route::resource('faculty', FacultyController::class);
	Route::get('/new/faculty', function () {
		return view('faculty.new');
	});

	// class
	Route::resource('class', ClassesController::class);
	Route::get('/new/class', function () {
		return view('class.new');
	});

	// subject
	Route::resource('subject', SubjectController::class);
	Route::get('/new/subject', function () {
		return view('subject.new');
	});

	// credit class
	Route::resource('credit-class', CreditClassController::class);
	Route::get('/new/credit-class', function () {
		return view('credit_class.new');
	});

	// register credit class
	Route::resource('register-class', RegisterClassController::class);
	Route::post('/register/class/delete', [RegisterClassController::class, 'destroyRegister']);
	Route::get('/register/credit-class', function () {
		return view('register_class.new');
	});

	// point management
	Route::resource('point', PointController::class);
	Route::get('/statistical',[PointController::class,'statistical'])->name('statistical');
	Route::post('/statistical-point-class',[PointController::class,'statisticalPointClass']);
	Route::get('point/detail/{student_id}/{credit_class_id}',[PointController::class, 'find']);
	Route::post('point/update/{student_id}/{credit_class_id}', [PointController::class, 'update']);

	Route::get('import/point/{credit_class_id}',[PointController::class, 'viewImport']);
	Route::post('/import/point', [PointController::class, 'import']);

	// point management
	Route::resource('student/point', StudentPointController::class);

	// lecturer point management
	Route::get('manage/credit-class', [StudentPointController::class, 'lecturerCreditClassManage']);
	Route::get('manage/point', [StudentPointController::class, 'lecturerPointManage']);
	Route::get('manage/point/{credit_class_id}',[StudentPointController::class, 'pointsByCreditClass']);

	// notification
	Route::get('/notify', [NotificationController::class, 'index']);
	Route::get('/new/notify', [NotificationController::class, 'viewNotify']);
	Route::post('/notify', [NotificationController::class, 'store']);
	Route::put('/notify/{id}', [NotificationController::class, 'update']);
	Route::get('/notify/{id}', [NotificationController::class, 'show']);
	Route::delete('/notify/{id}', [NotificationController::class, 'destroy']);

	// report
	Route::get('report/student/credit-class',[ReportController::class, 'reportStudentsByCreditClass']);
	Route::get('report/student/credit-class/{id}',[ReportController::class, 'show']);

	// report student 
	Route::get('report/student/gpa',[ReportController::class, 'progress']);
});

// admin
Route::group(['prefix' => 'admin', 'middleware' => 'CheckAdminLogin'], function () {
	// student
	Route::get('/student', [UserController::class, 'studentsIndex']);
	Route::post('/student', [UserController::class, 'store']);
	Route::put('/student/{id}', [UserController::class, 'updateUser']);
	Route::get('/student/{id}', [UserController::class, 'showStudent']);
	Route::post('/student/update', [UserController::class, 'updateInformationUser']);
	Route::delete('/student/{id}', [UserController::class, 'destroyAccount']);
	Route::get('/new/student', function () {
		return view('user.new_student');
	});

	// lecturer
	Route::get('/lecturer', [UserController::class, 'lecturersIndex']);
	Route::post('/lecturer', [UserController::class, 'store']);
	Route::put('/lecturer/{id}', [UserController::class, 'updateUser']);
	Route::get('/lecturer/{id}', [UserController::class, 'showLecturer']);
	Route::post('/lecturer/update', [UserController::class, 'updateInformationUser']);
	Route::delete('/lecturer/{id}', [UserController::class, 'destroyAccount']);
	Route::get('/new/lecturer', function () {
		return view('user.new_lecturer');
	});

	// administrator
	Route::get('/administrator', [UserController::class, 'administratorsIndex']);
	Route::post('/administrator', [UserController::class, 'store']);
	Route::put('/administrator/{id}', [UserController::class, 'updateUser']);
	Route::get('/administrator/{id}', [UserController::class, 'showAdministrator']);
	Route::post('/administrator/update', [UserController::class, 'updateInformationUser']);
	Route::delete('/administrator/{id}', [UserController::class, 'destroyAccount']);
	Route::get('/new/administrator', function () {
		return view('user.new_administrator');
	});
});

// admin
Route::group(['prefix' => 'admin'], function () {
	Route::get('/login', [LoginController::class, 'showLoginForm']);
	Route::post('/login', [LoginController::class, 'postLoginAdmin']);
	Route::get('/logout', [LoginController::class, 'logoutAdmin']);
});
