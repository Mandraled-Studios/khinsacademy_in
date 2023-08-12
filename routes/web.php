<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\OccasionController;

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
    });

});
