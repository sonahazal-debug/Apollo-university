<?php

// Route::redirect('/', '/login');

use App\Http\Controllers\Admin\ExamManagementController;
use App\Http\Controllers\Admin\ExamPatternController;
use App\Http\Controllers\Admin\QuestionManagementController;
use App\Http\Controllers\Frontend\UserController;

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Category Management
    Route::delete('category-managements/destroy', 'CategoryManagementController@massDestroy')->name('category-managements.massDestroy');
    Route::post('category-managements/media', 'CategoryManagementController@storeMedia')->name('category-managements.storeMedia');
    Route::post('category-managements/ckmedia', 'CategoryManagementController@storeCKEditorImages')->name('category-managements.storeCKEditorImages');
    Route::post('category-managements/parse-csv-import', 'CategoryManagementController@parseCsvImport')->name('category-managements.parseCsvImport');
    Route::post('category-managements/process-csv-import', 'CategoryManagementController@processCsvImport')->name('category-managements.processCsvImport');
    Route::resource('category-managements', 'CategoryManagementController');

    // Course
    Route::delete('courses/destroy', 'CourseController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/parse-csv-import', 'CourseController@parseCsvImport')->name('courses.parseCsvImport');
    Route::post('courses/process-csv-import', 'CourseController@processCsvImport')->name('courses.processCsvImport');
    Route::resource('courses', 'CourseController');

    // Exam Pattern
    Route::delete('exam-patterns/destroy', 'ExamPatternController@massDestroy')->name('exam-patterns.massDestroy');
    Route::post('exam-patterns/parse-csv-import', 'ExamPatternController@parseCsvImport')->name('exam-patterns.parseCsvImport');
    Route::post('exam-patterns/process-csv-import', 'ExamPatternController@processCsvImport')->name('exam-patterns.processCsvImport');
    Route::resource('exam-patterns', 'ExamPatternController');

    // Exam Management
    Route::delete('exam-managements/destroy', 'ExamManagementController@massDestroy')->name('exam-managements.massDestroy');
    Route::post('exam-managements/media', 'ExamManagementController@storeMedia')->name('exam-managements.storeMedia');
    Route::post('exam-managements/ckmedia', 'ExamManagementController@storeCKEditorImages')->name('exam-managements.storeCKEditorImages');
    Route::post('exam-managements/parse-csv-import', 'ExamManagementController@parseCsvImport')->name('exam-managements.parseCsvImport');
    Route::post('exam-managements/process-csv-import', 'ExamManagementController@processCsvImport')->name('exam-managements.processCsvImport');
    Route::resource('exam-managements', 'ExamManagementController');

    // Question Management
    Route::delete('question-managements/destroy', 'QuestionManagementController@massDestroy')->name('question-managements.massDestroy');
    Route::post('question-managements/media', 'QuestionManagementController@storeMedia')->name('question-managements.storeMedia');
    Route::post('question-managements/ckmedia', 'QuestionManagementController@storeCKEditorImages')->name('question-managements.storeCKEditorImages');
    Route::post('question-managements/parse-csv-import', 'QuestionManagementController@parseCsvImport')->name('question-managements.parseCsvImport');
    Route::post('question-managements/process-csv-import', 'QuestionManagementController@processCsvImport')->name('question-managements.processCsvImport');
    Route::resource('question-managements', 'QuestionManagementController');


    Route::get('/add-question/{slug}', [QuestionManagementController::class, 'addQuestion'])
    ->name('add-questions');

    Route::get('/all-questions/{slug}', [QuestionManagementController::class, 'allQuestions'])
    ->name('all-questions');


    Route::get('/get-exam-category/{category_id}/{course_id}', [QuestionManagementController::class, 'getExamCategory']);

    // Student
    Route::delete('students/destroy', 'StudentController@massDestroy')->name('students.massDestroy');
    Route::post('students/parse-csv-import', 'StudentController@parseCsvImport')->name('students.parseCsvImport');
    Route::post('students/process-csv-import', 'StudentController@processCsvImport')->name('students.processCsvImport');
    Route::resource('students', 'StudentController');

    // Result Management
    Route::delete('result-managements/destroy', 'ResultManagementController@massDestroy')->name('result-managements.massDestroy');
    Route::post('result-managements/parse-csv-import', 'ResultManagementController@parseCsvImport')->name('result-managements.parseCsvImport');
    Route::post('result-managements/process-csv-import', 'ResultManagementController@processCsvImport')->name('result-managements.processCsvImport');
    Route::resource('result-managements', 'ResultManagementController');

    // Setting
    Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    Route::post('settings/media', 'SettingController@storeMedia')->name('settings.storeMedia');
    Route::post('settings/ckmedia', 'SettingController@storeCKEditorImages')->name('settings.storeCKEditorImages');
    Route::post('settings/parse-csv-import', 'SettingController@parseCsvImport')->name('settings.parseCsvImport');
    Route::post('settings/process-csv-import', 'SettingController@processCsvImport')->name('settings.processCsvImport');
    Route::resource('settings', 'SettingController');

    // Seo
    Route::delete('seos/destroy', 'SeoController@massDestroy')->name('seos.massDestroy');
    Route::post('seos/media', 'SeoController@storeMedia')->name('seos.storeMedia');
    Route::post('seos/ckmedia', 'SeoController@storeCKEditorImages')->name('seos.storeCKEditorImages');
    Route::post('seos/parse-csv-import', 'SeoController@parseCsvImport')->name('seos.parseCsvImport');
    Route::post('seos/process-csv-import', 'SeoController@processCsvImport')->name('seos.processCsvImport');
    Route::resource('seos', 'SeoController');

    // Head Script
    Route::delete('head-scripts/destroy', 'HeadScriptController@massDestroy')->name('head-scripts.massDestroy');
    Route::post('head-scripts/parse-csv-import', 'HeadScriptController@parseCsvImport')->name('head-scripts.parseCsvImport');
    Route::post('head-scripts/process-csv-import', 'HeadScriptController@processCsvImport')->name('head-scripts.processCsvImport');
    Route::resource('head-scripts', 'HeadScriptController');

    // Body Script
    Route::delete('body-scripts/destroy', 'BodyScriptController@massDestroy')->name('body-scripts.massDestroy');
    Route::post('body-scripts/parse-csv-import', 'BodyScriptController@parseCsvImport')->name('body-scripts.parseCsvImport');
    Route::post('body-scripts/process-csv-import', 'BodyScriptController@processCsvImport')->name('body-scripts.processCsvImport');
    Route::resource('body-scripts', 'BodyScriptController');

    Route::get('/key-sheet/{id}/{course_id}/', [ExamManagementController::class, 'KeySheet'])->name('key-sheet');


Route::get('get-course-categories', [ExamPatternController::class, 'getCourseCategories'])
->name('get-course-categories');


    // Home Content
    Route::delete('home-contents/destroy', 'HomeContentController@massDestroy')->name('home-contents.massDestroy');
    Route::post('home-contents/parse-csv-import', 'HomeContentController@parseCsvImport')->name('home-contents.parseCsvImport');
    Route::post('home-contents/process-csv-import', 'HomeContentController@processCsvImport')->name('home-contents.processCsvImport');
    Route::resource('home-contents', 'HomeContentController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});


Route::get('/',[UserController::class,'homePage'])->name('home');


Route::post('/student-login',[UserController::class,'login'])->name('StudentLogin');

Route::get('/student-logout', [UserController::class, 'logout'])->name('StudentLogout');

Route::get('/testSeries', [UserController::class, 'testSeries'])->name('test-series');

Route::get('/exam-page/{course_id}/{exam_name}/{exam_id}/{student_id}', [UserController::class, 'examPage'])->name('exam-page');

Route::post('/finish-submit',[UserController::class,'FinishSubmit'])->name('finish-submit');


Route::get('/result-sheet/{student_id}/{course_id}/{exam_id}/', [UserController::class, 'resultSheet'])->name('result-sheet');

// Route::get('/key-sheet',[UserController::class,'key'])->name('key.sheet');
