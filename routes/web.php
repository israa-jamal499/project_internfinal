<?php

use App\Http\Controllers\Cms\Admin\AdminController;
use App\Http\Controllers\Cms\Admin\CityController;
use App\Http\Controllers\Cms\Admin\CollegeController;
use App\Http\Controllers\Cms\Admin\SpecializationController;
use App\Http\Controllers\Cms\Admin\SupervisorController;
use App\Http\Controllers\Cms\Supervisor\SupervisorController as  SupervisorSupervisorController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Cms\Admin\StudentController;
use App\Http\Controllers\Cms\Supervisor\StudentHourController as SupervisorStudentHourController;
use App\Http\Controllers\Front\WeeklyReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\Admin\CompanyController;
use App\Http\Controllers\Cms\Admin\OpportunityController as AdminOpportunityController;
use App\Http\Controllers\Cms\Company\ApplicationController;
use App\Http\Controllers\Cms\Company\InternshipController;
use App\Http\Controllers\Cms\Admin\InternshipController as AdminInternshipController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Cms\Company\OpportunityController;
use App\Http\Controllers\Cms\Supervisor\EvaluationController;
use App\Http\Controllers\Cms\Company\EvaluationController as CompanyEvaluationController ;
use App\Http\Controllers\Front\OpportunityController as FrontOpportunityController;
use App\Http\Controllers\Front\ApplicationController as FrontApplicationController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Cms\Company\HomeController as CompanyHomeController ;
use App\Http\Controllers\Front\StudentApplicationController;
use App\Http\Controllers\Front\StudentController as FrontStudentController;
use App\Http\Controllers\Cms\Supervisor\WeeklyReportController as SupervisorWeeklyReportController;
use App\Http\Controllers\Front\StudentHourController;
use App\Http\Controllers\Cms\Supervisor\StudentController as SupervisorStudentController;
use App\Http\Controllers\Cms\Admin\CertificateController;
use App\Http\Controllers\Front\StudentMessageController;
use App\Http\Controllers\Cms\Supervisor\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Cms\Admin\ReportController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/', function () {
    return view('parent');
});

Route::prefix('cms/admin')->name('admin.')->group(function () {
    Route::get('students/trashed', [StudentController::class, 'trashed'])->name('students.trashed');
   Route::post('students/restore/{id}', [StudentController::class, 'restore'])->name('students.restore');
Route::post('students/force-all', [StudentController::class, 'forceAll'])->name('students.forceAll');
Route::delete('students/force/{id}', [StudentController::class, 'force'])->name('students.force');
    Route::resource('students', StudentController::class);

    Route::get('opportunities/trashed', [AdminOpportunityController::class, 'trashed'])->name('opportunities.trashed');
Route::post('opportunities/restore/{id}', [AdminOpportunityController::class, 'restore'])->name('opportunities.restore');
Route::post('opportunities/force-all', [AdminOpportunityController::class, 'forceAll'])->name('opportunities.forceAll');
Route::delete('opportunities/force/{id}', [AdminOpportunityController::class, 'force'])->name('opportunities.force');

Route::resource('opportunities', AdminOpportunityController::class);

    Route::post('companies/restore/{id}', [CompanyController::class, 'restore'])->name('companies.restore');
Route::post('companies/force-all', [CompanyController::class, 'forceAll'])->name('companies.forceAll');
Route::get('companies/trashed', [CompanyController::class, 'trashed'])->name('companies.trashed');
Route::delete('companies/force/{id}', [CompanyController::class, 'force'])->name('companies.force');

Route::resource('companies', CompanyController::class);

   Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    Route::get('/reports', [ReportController::class, 'index'])->name('cms.admin.report');

    Route::get('/certificates', [CertificateController::class, 'index'])->name('admin.certificates.index');
Route::post('/certificates/store', [CertificateController::class, 'store'])->name('admin.certificates.store');
Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('admin.certificates.show');

Route::get('/notifications', [NotificationController::class, 'adminIndex'])->name('notifications');

    Route::get('colleges/trashed', [CollegeController::class, 'trashed'])->name('colleges.trashed');
    Route::get('colleges/restore/{id}', [CollegeController::class, 'restore'])->name('colleges.restore');
    Route::delete('colleges/force/{id}', [CollegeController::class, 'force'])->name('colleges.force');
    Route::delete('colleges/force-all', [CollegeController::class, 'forceAll'])->name('colleges.forceAll');

    Route::resource('colleges', CollegeController::class);

    Route::get('specializations/trashed', [SpecializationController::class, 'trashed'])->name('specializations.trashed');
    Route::get('specializations/restore/{id}', [SpecializationController::class, 'restore'])->name('specializations.restore');
    Route::delete('specializations/force/{id}', [SpecializationController::class, 'force'])->name('specializations.force');
    Route::delete('specializations/force-all', [SpecializationController::class, 'forceAll'])->name('specializations.forceAll');

    Route::resource('specializations', SpecializationController::class);

    Route::get('cities/trashed', [CityController::class, 'trashed'])->name('cities.trashed');
    Route::get('cities/restore/{id}', [CityController::class, 'restore'])->name('cities.restore');
    Route::delete('cities/force/{id}', [CityController::class, 'force'])->name('cities.force');

    Route::resource('cities', CityController::class);
    Route::get('admins/trashed', [AdminController::class, 'trashed'])->name('admins.trashed');
Route::get('admins/restore/{id}', [AdminController::class, 'restore'])->name('admins.restore');
Route::delete('admins/force/{id}', [AdminController::class, 'force'])->name('admins.force');
Route::delete('admins/force-all', [AdminController::class, 'forceAll'])->name('admins.forceAll');
Route::resource('admins', AdminController::class);

    Route::resource('admins', AdminController::class);
    Route::get('supervisors/trashed', [SupervisorController::class, 'trashed'])->name('supervisors.trashed');
Route::get('supervisors/restore/{id}', [SupervisorController::class, 'restore'])->name('supervisors.restore');
Route::delete('supervisors/force/{id}', [SupervisorController::class, 'force'])->name('supervisors.force');
Route::delete('supervisors/force-all', [SupervisorController::class, 'forceAll'])->name('supervisors.forceAll');
Route::resource('supervisors', SupervisorController::class);

Route::get('supervisors/trashed', [AdminInternshipController::class, 'trashed'])->name('supervisors.trashed');
Route::get('supervisors/restore/{id}', [AdminInternshipController::class, 'restore'])->name('supervisors.restore');
Route::delete('supervisors/force/{id}', [AdminInternshipController::class, 'force'])->name('supervisors.force');
Route::delete('supervisors/force-all', [AdminInternshipController::class, 'forceAll'])->name('supervisors.forceAll');
Route::resource('internships', AdminInternshipController::class);


Route::get('/change-password', [AdminController::class, 'editPassword'])->name('password.edit');
Route::put('/change-password', [AdminController::class, 'updatePassword'])->name('password.update');
});




Route::prefix('front/auth')->name('front.auth.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register-student', [AuthController::class, 'registerStudent'])->name('register-student');
    Route::post('/register-student', [AuthController::class, 'storeStudent'])->name('register-student.store');

    Route::get('/register-company', [AuthController::class, 'registerCompany'])->name('register-company');
    Route::post('/register-company', [AuthController::class, 'storeCompany'])->name('register-company.store');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/forget_password', function () {
        return view('front.auth.forget_password');
    })->name('forgot-password');

    Route::get('/register-new', function () {
        return view('front.auth.register-type');
    })->name('register-new');
});


Route::prefix('front/home')->name('front.home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('front.home.index');

    Route::get('/about', function () {
        return view('front.home.about');
    })->name('about');

    Route::get('/how-it-works', function () {
        return view('front.home.how-it-works');
    })->name('how-it-works');

    Route::get('/opportunities', [FrontOpportunityController::class, 'index'])->name('opportunities');
    Route::get('/opportunity-details/{id}', [FrontOpportunityController::class, 'show'])->name('opportunity-details');

Route::post('/opportunity-details/{id}/apply', [FrontApplicationController::class, 'store'])
    ->name('opportunities.apply');

});




Route::prefix('front/student')->name('front.student.')->group(function () {
Route::get('/certificate', [FrontStudentController::class, 'certificate'])->name('certificate');

    Route::get('/dashboard', [FrontStudentController::class, 'dashboard'])->name('dashboard');
   Route::get('/profile', [FrontStudentController::class, 'profile'])->name('profile');
Route::put('/profile/update', [FrontStudentController::class, 'updateProfile'])->name('profile.update');

Route::get('/change-password', [FrontStudentController::class, 'editPassword'])->name('password.edit');
Route::put('/change-password', [FrontStudentController::class, 'updatePassword'])->name('password.update');

    Route::get('/hours', [StudentHourController::class, 'index'])->name('hours');
Route::post('/hours', [StudentHourController::class, 'store'])->name('hours.store');
Route::delete('/hours/{id}', [StudentHourController::class, 'destroy'])->name('hours.destroy');

    Route::get('/internship', [FrontStudentController::class, 'internship'])->name('internship');

    Route::get('/notifications', [NotificationController::class, 'studentIndex'])->name('notifications');

    Route::get('/applications', [StudentApplicationController::class, 'index'])->name('applications');
    Route::delete('/applications/{id}', [StudentApplicationController::class, 'destroy'])->name('applications.destroy');

    Route::get('/weekly-reports', [WeeklyReportController::class, 'index'])->name('weekly-reports');
Route::post('/weekly-reports', [WeeklyReportController::class, 'store'])->name('weekly-reports.store');
Route::get('/weekly-reports/{id}', [WeeklyReportController::class, 'show'])->name('weekly-reports.show');

    Route::get('/messages', [StudentMessageController::class, 'index'])->name('messages');
Route::post('/messages/send', [StudentMessageController::class, 'send'])->name('messages.send');
});





Route::prefix('cms/company')->group(function () {

    Route::get('opportunities/trashed', [OpportunityController::class, 'trashed'])->name('opportunities.trashed');
Route::post('opportunities/restore/{id}', [OpportunityController::class, 'restore'])->name('opportunities.restore');
Route::post('opportunities/force-all', [OpportunityController::class, 'forceAll'])->name('opportunities.forceAll');
Route::delete('opportunities/force/{id}', [OpportunityController::class, 'force'])->name('opportunities.force');
Route::resource('opportunities', OpportunityController::class);

    Route::view('/parent', 'cms.company.parent')->name('parent');

    Route::get('/dashboard', [CompanyHomeController::class, 'dashboard'])->name('cms.company.dashboard');


Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
Route::put('/applications/{id}', [ApplicationController::class, 'update'])->name('applications.update');

    Route::get('/evaluation', [CompanyEvaluationController::class, 'index'])->name('cms.company.evaluation');
Route::post('/evaluation', [CompanyEvaluationController::class, 'store'])->name('cms.company.evaluation.store');



   Route::get('/notifications', [NotificationController::class, 'companyIndex'])->name('notifications');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
Route::delete('/notifications/delete/{id}', [NotificationController::class, 'delete'])
        ->name('notifications.delete');

    Route::delete('/notifications/clear', [NotificationController::class, 'clearAll'])
        ->name('notifications.clear');


   Route::get('/interns', [InternshipController::class, 'index'])->name('cms.company.interns');
Route::post('/interns/{id}/stop', [InternshipController::class, 'stop'])->name('cms.company.interns.stop');


Route::get('/profile', [CompanyHomeController::class, 'profile'])->name('company.profile');
Route::put('/profile/update', [CompanyHomeController::class, 'updateProfile'])->name('profile.update');

Route::get('/change-password', [CompanyHomeController::class, 'editPassword'])->name('password.edit');
Route::put('/change-password', [CompanyHomeController::class, 'updatePassword'])->name('password.update');

   Route::get('/profileintern/{id}', [InternshipController::class, 'show'])->name('cms.company.internsprofile');




});





Route::prefix('cms/supervisor')->group(function () {

Route::get('students/trashed', [SupervisorStudentController::class, 'trashed'])->name('cms.supervisor.students.trashed');
Route::post('students/restore/{id}', [SupervisorStudentController::class, 'restore'])->name('cms.supervisor.students.restore');
Route::post('students/force-all', [SupervisorStudentController::class, 'forceAll'])->name('cms.supervisor.students.forceAll');
Route::delete('students/force/{id}', [SupervisorStudentController::class, 'force'])->name('cms.supervisor.students.force');

Route::resource('students', SupervisorStudentController::class)
    ->names('cms.supervisor.students');

    Route::view('/parent', 'cms.supervisor.parent')->name('parent');
   Route::get('/dashboard', [SupervisorSupervisorController::class, 'dashboard'])
    ->name('cms.supervisor.dashboard');

     Route::get('/evaluation', [EvaluationController::class, 'index'])->name('cms.supervisor.evaluation');
Route::post('/evaluation', [EvaluationController::class, 'store'])->name('cms.supervisor.evaluation.store');

Route::get('/hours', [SupervisorStudentHourController::class, 'index'])->name('cms.supervisor.hours');
Route::get('/hours/{id}', [SupervisorStudentHourController::class, 'show'])->name('cms.supervisor.hours.show');
Route::put('/hours/{id}', [SupervisorStudentHourController::class, 'update'])->name('cms.supervisor.hours.update');



   Route::get('/messages', [MessageController::class, 'index'])->name('cms.supervisor.messages');
Route::get('/messages/{id}', [MessageController::class, 'show'])->name('cms.supervisor.messages.show');
Route::post('/messages/reply', [MessageController::class, 'reply'])->name('cms.supervisor.messages.reply');
Route::post('/messages/{id}/mark-read', [MessageController::class, 'markRead'])->name('cms.supervisor.messages.markRead');
Route::post('/messages/{id}/toggle-save', [MessageController::class, 'toggleSave'])->name('cms.supervisor.messages.toggleSave');

Route::get('/notifications', [NotificationController::class, 'supervisorIndex'])->name('cms.supervisor.notifications');

  Route::get('/weekly-reports', [SupervisorWeeklyReportController::class, 'index'])->name('cms.supervisor.weekly-reports');
Route::get('/weekly-reports/{id}', [SupervisorWeeklyReportController::class, 'show'])->name('cms.supervisor.weekly-reports.show');
Route::put('/weekly-reports/{id}', [SupervisorWeeklyReportController::class, 'update'])->name('cms.supervisor.weekly-reports.update');
    Route::get('/profile', [SupervisorSupervisorController::class, 'profile'])->name('cms.supervisor.profile');
Route::put('/profile/update', [SupervisorSupervisorController::class, 'updateProfile'])->name('cms.supervisor.profile.update');

Route::get('/change-password', [SupervisorSupervisorController::class, 'editPassword'])->name('cms.supervisor.password.edit');
Route::put('/change-password', [SupervisorSupervisorController::class, 'updatePassword'])->name('cms.supervisor.password.update');



});


Route::post('/images', [ImageController::class, 'store'])->name('images.store');
Route::delete('/images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
