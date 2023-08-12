<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\QuestionController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/student-registrations', [AdminController::class, 'studentRegistrations'])->name('admin.registrations');
        Route::get('/student-registrations/search', [AdminController::class, 'studentSearch'])->name('admin.registrations.search');
        Route::get('/student-registrations/{id}', [AdminController::class, 'studentProfile'])->name('admin.student');

        /* ---- Events ---- */
        Route::get('/occasions', [OccasionController::class, 'index'])->name('admin.occasions.index');
        Route::post('/occasions', [OccasionController::class, 'store'])->name('admin.occasions.store');
        Route::patch('/occasions/{id}', [OccasionController::class, 'update'])->name('admin.occasions.update');
        Route::delete('/occasions/{id}', [OccasionController::class, 'destroy'])->name('admin.occasions.destroy');

        /* ---- Quiz ---- */
        Route::get('/quiz', [QuizController::class, 'index'])->name('admin.quiz.index');
        Route::get('/quiz/create', [QuizController::class, 'create'])->name('admin.quiz.create');
        Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('admin.quiz.show');
        Route::post('/quiz', [QuizController::class, 'store'])->name('admin.quiz.store');
        Route::get('/quiz/{slug}/edit', [QuizController::class, 'edit'])->name('admin.quiz.edit');
        Route::patch('/quiz/{id}', [QuizController::class, 'update'])->name('admin.quiz.update');
        Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('admin.quiz.destroy');
        Route::post('/quiz/{slug}', [QuizController::class, 'addRelation'])->name('admin.quiz.relate');
        Route::delete('/quiz/{exam}/{dept}', [QuizController::class, 'breakRelation'])->name('admin.quiz.breakup');

        /* ---- Questions ---- */
        Route::get('/quiz/{slug}/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
        Route::get('/quiz/{slug}/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
        Route::post('/quiz/{id}/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
        Route::get('/quiz/{slug}/questions/{ques}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
        Route::patch('/quiz/{id}/questions/{ques}', [QuestionController::class, 'update'])->name('admin.questions.update');
        Route::delete('/quiz/{id}/questions/{ques}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');

    });

});
