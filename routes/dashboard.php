<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/alerts', [App\Http\Controllers\Dashboard\DashboardController::class, 'alerts'])->name('dashboard.alerts');
Route::post('/dail-alert', [App\Http\Controllers\Dashboard\DashboardController::class, 'sendDailyAlerts'])->name('dashboard.daily_alert');
Route::post('/weekly-alert', [App\Http\Controllers\Dashboard\DashboardController::class, 'sendWeeklyAlerts'])->name('dashboard.weekly_alert');

Route::get('/users', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('dashboard.users.index');
Route::get('/users/{id}/edit', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('dashboard.users.edit');
Route::patch('/users/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('dashboard.users.update');
Route::delete('/users/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('dashboard.users.destroy');
Route::post('/users/message', [App\Http\Controllers\Dashboard\UserController::class, 'message'])->name('dashboard.users.message');
Route::post('/users/{id}/status', [App\Http\Controllers\Dashboard\UserController::class, 'status'])->name('dashboard.users.status');
Route::post('/users/{id}/verify', [App\Http\Controllers\Dashboard\UserController::class, 'verify'])->name('dashboard.users.verify');
Route::post('/users/{id}/password', [App\Http\Controllers\Dashboard\UserController::class, 'password'])->name('dashboard.users.password');

Route::get('/organisations', [App\Http\Controllers\Dashboard\OrganisationController::class, 'index'])->name('dashboard.organisations.index');
Route::get('/organisations/create', [App\Http\Controllers\Dashboard\OrganisationController::class, 'create'])->name('dashboard.organisations.create');
Route::post('/organisations', [App\Http\Controllers\Dashboard\OrganisationController::class, 'store'])->name('dashboard.organisations.store');
Route::get('/organisations/{id}/edit', [App\Http\Controllers\Dashboard\OrganisationController::class, 'edit'])->name('dashboard.organisations.edit');
Route::patch('/organisations/{id}', [App\Http\Controllers\Dashboard\OrganisationController::class, 'update'])->name('dashboard.organisations.update');
Route::delete('/organisations/{id}', [App\Http\Controllers\Dashboard\OrganisationController::class, 'destroy'])->name('dashboard.organisations.destroy');

Route::get('/universities', [App\Http\Controllers\Dashboard\UniversityController::class, 'index'])->name('dashboard.universities.index');
Route::get('/universities/create', [App\Http\Controllers\Dashboard\UniversityController::class, 'create'])->name('dashboard.universities.create');
Route::post('/universities', [App\Http\Controllers\Dashboard\UniversityController::class, 'store'])->name('dashboard.universities.store');
Route::get('/universities/{id}/edit', [App\Http\Controllers\Dashboard\UniversityController::class, 'edit'])->name('dashboard.universities.edit');
Route::patch('/universities/{id}', [App\Http\Controllers\Dashboard\UniversityController::class, 'update'])->name('dashboard.universities.update');
Route::delete('/universities/{id}', [App\Http\Controllers\Dashboard\UniversityController::class, 'destroy'])->name('dashboard.universities.destroy');

Route::get('/threads', [App\Http\Controllers\Dashboard\ThreadController::class, 'index'])->name('dashboard.threads.index');
Route::get('/threads/{id}/edit', [App\Http\Controllers\Dashboard\ThreadController::class, 'edit'])->name('dashboard.threads.edit');
Route::patch('/threads/{id}', [App\Http\Controllers\Dashboard\ThreadController::class, 'update'])->name('dashboard.threads.update');
Route::delete('/threads/{id}', [App\Http\Controllers\Dashboard\ThreadController::class, 'destroy'])->name('dashboard.threads.destroy');
Route::post('/threads/{id}/close', [App\Http\Controllers\Dashboard\ThreadController::class, 'close'])->name('dashboard.threads.close');
Route::post('/threads/{id}/open', [App\Http\Controllers\Dashboard\ThreadController::class, 'open'])->name('dashboard.threads.open');
Route::post('/threads/{id}/park', [App\Http\Controllers\Dashboard\ThreadController::class, 'park'])->name('dashboard.threads.park');
Route::post('/threads/{id}/unpark', [App\Http\Controllers\Dashboard\ThreadController::class, 'unpark'])->name('dashboard.threads.unpark');

Route::get('/replies', [App\Http\Controllers\Dashboard\ReplyController::class, 'index'])->name('dashboard.replies.index');
Route::get('/replies/{id}/edit', [App\Http\Controllers\Dashboard\ReplyController::class, 'edit'])->name('dashboard.replies.edit');
Route::patch('/replies/{id}', [App\Http\Controllers\Dashboard\ReplyController::class, 'update'])->name('dashboard.replies.update');
Route::delete('/replies/{id}', [App\Http\Controllers\Dashboard\ReplyController::class, 'destroy'])->name('dashboard.replies.destroy');
Route::post('/replies/{id}/park', [App\Http\Controllers\Dashboard\ReplyController::class, 'park'])->name('dashboard.replies.park');
Route::post('/replies/{id}/unpark', [App\Http\Controllers\Dashboard\ReplyController::class, 'unpark'])->name('dashboard.replies.unpark');

Route::get('/groups', [App\Http\Controllers\Dashboard\GroupController::class, 'index'])->name('dashboard.groups.index');
Route::get('/groups/create', [App\Http\Controllers\Dashboard\GroupController::class, 'create'])->name('dashboard.groups.create');
Route::post('/groups', [App\Http\Controllers\Dashboard\GroupController::class, 'store'])->name('dashboard.groups.store');
Route::get('/groups/{id}/edit', [App\Http\Controllers\Dashboard\GroupController::class, 'edit'])->name('dashboard.groups.edit');
Route::patch('/groups/{id}', [App\Http\Controllers\Dashboard\GroupController::class, 'update'])->name('dashboard.groups.update');
Route::delete('/groups/{id}', [App\Http\Controllers\Dashboard\GroupController::class, 'destroy'])->name('dashboard.groups.destroy');


Route::get('/companies', [App\Http\Controllers\Dashboard\CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/create', [App\Http\Controllers\Dashboard\CompanyController::class, 'create'])->name('companies.create');
Route::post('/companies', [App\Http\Controllers\Dashboard\CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/{id}/edit', [App\Http\Controllers\Dashboard\CompanyController::class, 'edit'])->name('companies.edit');
Route::patch('/companies/{id}', [App\Http\Controllers\Dashboard\CompanyController::class, 'update'])->name('companies.update');
Route::delete('/companies/{id}', [App\Http\Controllers\Dashboard\CompanyController::class, 'destroy'])->name('companies.destroy');
Route::get('companies-data', 'CompanyController@dataTable')->name('companies.dataTable');


//    GROUP FOR QUIZ
Route::resource('groups-for-quiz', 'GroupForQuizController');
Route::post('groups-for-quiz/add-new-group', 'GroupForQuizController@addNewGroup')->name('groups-for-quiz.add-new-group');
Route::get('groups-for-quiz/get-groups/data', 'GroupForQuizController@dataTable')->name('groups-for-quiz.dataTable');
Route::get('groups-for-quiz/retrieve-all/data', 'GroupForQuizController@retrieveAll')->name('groups-for-quiz.retrieve-all');


//    QUIZ
Route::resource('forms', 'QuizController')->except(['show', 'update']);
Route::get('form/{id}/reports', 'QuizController@reports')->name('quiz-reports');
Route::get('scribes', 'QuizController@scribes')->name('scribes.index');
Route::get('scribes-data', 'QuizController@scribesDataTable')->name('scribes.data');
Route::get('form/reports/export', 'QuizController@reportsExport')->name('reports_export');
Route::get('form/answers/export', 'QuizController@answersExport')->name('reports_answers');
Route::get('form/export', 'QuizController@export')->name('quiz.export');
Route::get('form/export/pdf', 'QuizController@exportPdf')->name('quiz.exportPdf');
Route::get('form/export/{id}', 'QuizController@onlyExport')->name('quiz.onlyExport');
Route::get('form/export/pdf/{id}', 'QuizController@onlyExportPdf')->name('quiz.onlyExportPdf');
Route::post('form/import', [\App\Http\Controllers\Dashboard\QuizController::class, 'importForForm'])->name('quiz.import_for_form');
Route::get('/quizAll', 'QuizController@dataTable')->name('quiz.dataTable');
Route::get('/form/{quiz_id}/get-reports', 'QuizController@reportsDataTable')->name('quiz.report.dataTable');
Route::get('/form/reports/{id}/report', 'QuizController@retrieveReportByID')->name('quiz.report');
Route::delete('/form/reports/{id}/report/destroy', 'QuizController@retrieveReportByIdDestroy')->name('quiz.report.destroy');
Route::get('/forms/reports/archive', [\App\Http\Controllers\Dashboard\QuizController::class, 'archive'])->name('archive.index');
Route::get('/forms/{id}/reports/archive', [\App\Http\Controllers\Dashboard\QuizController::class, 'archiveByForm'])->name('archive_by_form.index');



//    QUIZ API
Route::get('/api/forms/reports/archive', [\App\Http\Controllers\Dashboard\QuizController::class, 'archiveDatatable'])->name('archive.datatable');
Route::get('/api/forms/{id}/reports/archive', [\App\Http\Controllers\Dashboard\QuizController::class, 'archiveByFormDatatable'])->name('archive_by_form.datatable');
Route::get('/api-quiz', 'QuizController@retrieveAllQuizes');
Route::get('/api-quiz/{quiz_id}', 'QuizController@retrieveOneByID');
Route::post('/api-quiz', 'QuizController@createQuiz');
Route::patch('/api-quiz-is_active/{quiz_id}', 'QuizController@quizIsActive');
Route::patch('/api-quiz/{quiz_id}/update', 'QuizController@updateQuiz');
Route::delete('/api-quiz/{quiz_id}', 'QuizController@deleteQuiz');
Route::get('/api/quiz-groups/{id?}', 'QuizController@groups');
Route::get('/api/quiz-companies/{id?}', 'QuizController@companies');
Route::patch('/api/quiz-status/change/{id}', 'QuizController@quizStatusChange');
Route::post('/quiz-clone/{id}', 'QuizController@quizClone');
Route::post('/quiz/{id}/question-fields-required', 'QuizController@quizQuestionFieldsIsRequired');
Route::patch('/quizes/{id}', [\App\Http\Controllers\Dashboard\QuizController::class, 'updateSelfVerification'])->name('quiz.update');
Route::get('/quizes/{id}/self-verification', [\App\Http\Controllers\Dashboard\QuizController::class, 'getSelfVerification'])->name('quiz.get.self-verification');
Route::get('/quizes/{id}/change-list', [\App\Http\Controllers\Dashboard\QuizController::class, 'reportChangeList'])->name('quiz.get.change-list');

//    QUESTIONS API
Route::post('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@cloneQuestionWithAnswers');
Route::get('/quiz/{quiz_id}/questions', 'QuestionController@retrieveAllQuestionByQuizID');
Route::post('/quiz/{quiz_id}/questions', 'QuestionController@createQuestion');
Route::patch('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@updateQuestion');
Route::patch('/quiz/{quiz_id}/questions/{question_id}/questionInfo', 'QuestionController@updateQuestionInfo');
Route::delete('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@deleteQuestion');
Route::patch('/quiz/{quiz_id}/questions', 'QuestionController@changeQuestionOrderByQuizID');
Route::get('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@retrieveOneByID');


//    ANSWERS API
Route::post('/questions/{question_id}/answers', 'AnswerController@createAnswer');
Route::get('/questions/{question_id}/answers/{answer_id}', 'AnswerController@retrieveOneByID');
Route::patch('/questions/{question_id}/update-answers', 'AnswerController@updateAnswer');
Route::delete('/questions/{question_id}/answers/{answer_id}', 'AnswerController@deleteAnswer');
Route::delete('/questions/{question_id}/answers', 'AnswerController@deleteAnswerByQuestionID');
Route::get('/questions/{question_id}/answers', 'AnswerController@retrieveAllByQuestionID');
Route::patch('/questions/{question_id}/answers', 'AnswerController@changeAnswerOrderByQuestionID');
