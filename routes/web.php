<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\QuizSectionController;
use App\Http\Controllers\SectionQuestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/cache', function() {
    //Clear route cache
    \Artisan::call('route:cache');
    //Clear config cache
    \Artisan::call('config:cache');
    // Clear application cache
    \Artisan::call('cache:clear');
    // Clear view cache
    \Artisan::call('view:clear');
    // Clear cache using reoptimized class
    \Artisan::call('optimize:clear');
   return redirect('/');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/student-registrations', [AdminController::class, 'studentRegistrations'])->name('admin.registrations');
        Route::get('/student-registrations/search', [AdminController::class, 'studentSearch'])->name('admin.registrations.search');
        Route::get('/student-registrations/{id}', [AdminController::class, 'studentProfile'])->name('admin.student.show');
        Route::get('/quiz-reports', [AdminController::class, 'quizReports'])->name('admin.quizreports');
        Route::get('/quiz-reports/{id}', [AdminController::class, 'quizReportsIndividual'])->name('admin.quizreports.individual');

        /* ---- Events ---- */
        Route::get('/occasions', [OccasionController::class, 'index'])->name('admin.occasions.index');
        Route::post('/occasions', [OccasionController::class, 'store'])->name('admin.occasions.store');
        Route::patch('/occasions/{id}', [OccasionController::class, 'update'])->name('admin.occasions.update');
        Route::delete('/occasions/{id}', [OccasionController::class, 'destroy'])->name('admin.occasions.destroy');

        /* ---- Department ---- */
        Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments.index');
        Route::get('/departments/create', [DepartmentController::class, 'create'])->name('admin.departments.create');
        Route::get('/departments/{slug}', [DepartmentController::class, 'show'])->name('admin.departments.show');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('admin.departments.store');
        Route::get('/departments/{slug}/edit', [DepartmentController::class, 'edit'])->name('admin.departments.edit');
        Route::patch('/departments/{id}', [DepartmentController::class, 'update'])->name('admin.departments.update');
        Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');

         /* ---- Classrooms ---- */
         Route::get('/classrooms', [ClassroomController::class, 'index'])->name('admin.classrooms.index');
         Route::get('/classrooms/create', [ClassroomController::class, 'create'])->name('admin.classrooms.create');
         Route::get('/classrooms/{slug}', [ClassroomController::class, 'show'])->name('admin.classrooms.show');
         Route::post('/classrooms', [ClassroomController::class, 'store'])->name('admin.classrooms.store');
         Route::get('/classrooms/{slug}/edit', [ClassroomController::class, 'edit'])->name('admin.classrooms.edit');
         Route::patch('/classrooms/{id}', [ClassroomController::class, 'update'])->name('admin.classrooms.update');
         Route::delete('/classrooms/{id}', [ClassroomController::class, 'destroy'])->name('admin.classrooms.destroy');

        /* ---- Quiz ---- */
        Route::get('/quiz', [QuizController::class, 'index'])->name('admin.quiz.index');
        Route::get('/quiz/create', [QuizController::class, 'create'])->name('admin.quiz.create');
        Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('admin.quiz.show');
        Route::post('/quiz', [QuizController::class, 'store'])->name('admin.quiz.store');
        Route::get('/quiz/{slug}/edit', [QuizController::class, 'edit'])->name('admin.quiz.edit');
        Route::patch('/quiz/{id}', [QuizController::class, 'update'])->name('admin.quiz.update');
        Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');
        Route::post('/quiz/assign/{id}', [QuizController::class, 'assign'])->name('admin.quiz.assign');
        Route::delete('/quiz/deassign/{dept}/{quiz}', [QuizController::class, 'deassign'])->name('admin.quiz.deassign');

        /* ---- Questions ---- */
        Route::get('/quiz/{slug}/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
        Route::get('/quiz/{slug}/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
        Route::post('/quiz/{id}/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
        Route::get('/quiz/{slug}/questions/{ques}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
        Route::patch('/quiz/{id}/questions/{ques}', [QuestionController::class, 'update'])->name('admin.questions.update');
        Route::delete('/quiz/{id}/questions/{ques}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');

        /* ---- Quiz Sections ---- */
        Route::get('/quiz/{slug}/create', [QuizSectionController::class, 'create'])->name('admin.quiz.sections.create');
        Route::post('/quiz/{slug}', [QuizSectionController::class, 'store'])->name('admin.quiz.sections.store');
        Route::get('/quiz/{slug}/{section}/edit', [QuizSectionController::class, 'edit'])->name('admin.quiz.sections.edit');
        Route::patch('/quiz/{slug}/{section}', [QuizSectionController::class, 'update'])->name('admin.quiz.sections.update');
        Route::delete('/quiz/{slug}/{section}', [QuizSectionController::class, 'destroy'])->name('admin.quiz.sections.destroy');

        /* ---- Questions within section ---- */
        Route::get('/quiz/{slug}/{section}/questions', [SectionQuestionController::class, 'index'])->name('admin.questionsInSection.index');
        Route::get('/quiz/{slug}/{section}/questions/create', [SectionQuestionController::class, 'create'])->name('admin.questionsInSection.create');
        Route::post('/quiz/{id}/{section}/questions', [SectionQuestionController::class, 'store'])->name('admin.questionsInSection.store');
        Route::get('/quiz/{slug}/{section}/questions/{ques}/edit', [SectionQuestionController::class, 'edit'])->name('admin.questionsInSection.edit');
        Route::patch('/quiz/{id}/{section}/questions/{ques}', [SectionQuestionController::class, 'update'])->name('admin.questionsInSection.update');
        Route::delete('/quiz/{id}/{section}/questions/{ques}', [SectionQuestionController::class, 'destroy'])->name('admin.questionsInSection.destroy');
    });

    Route::prefix('students')->group(function () {
        Route::get('/departments', [StudentController::class, 'departments'])->name('students.departments');
        Route::post('/departments', [StudentController::class, 'joinDepartment'])->name('students.departments.join');
        Route::get('/quiz', [StudentController::class, 'quiz'])->name('students.quiz');
        Route::get('/report-card', [StudentController::class, 'reportCard'])->name('students.reportCard');

        Route::get('/quiz/{slug}', [AssessmentController::class, 'instructions'])->name('students.quiz.instructions');
        Route::post('/quiz/{slug}/start', [AssessmentController::class, 'setupQuiz'])->name('students.quiz.setup');
        Route::get('/quiz/{slug}/stage', [ProgressController::class, 'startQuiz'])->name('students.quiz.start');
        Route::get('/quiz/{slug}/stage/{stage}', [ProgressController::class, 'nextSection'])->name('students.quiz.nextstage');
        Route::post('/quiz/{slug}/stage', [ProgressController::class, 'submitQuiz'])->name('students.quiz.submit');
        Route::post('/quiz/{slug}/stage/{stage}', [ProgressController::class, 'submitSection'])->name('students.quiz.submitstage');
        Route::get('/quiz/{slug}/scorecard', [ProgressController::class, 'scoreCard'])->name('students.quiz.scorecard');
        Route::get('/quiz/{slug}/pdf/questions', [AssessmentController::class, 'questionPDF'])->name('students.quiz.pdf');

        Route::get('/quiz/{quiz}/{student}', [AdminController::class, 'reportsViewIndividualStudent'])->name('admin.reportsViewIndividualStudent');
        Route::patch('/quiz/{pid}/{sid}', [ProgressController::class, 'changeStudentAttempt'])->name('admin.quiz.changeStudentAttempt');
    });

});
