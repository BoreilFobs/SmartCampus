<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController as PublicLevelController;
use App\Http\Controllers\CourseController as PublicCourseController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\LevelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/level/{level:slug}', [PublicLevelController::class, 'show'])->name('level.show');
Route::get('/course/{course:slug}', [PublicCourseController::class, 'show'])->name('course.show');

/*
|--------------------------------------------------------------------------
| User Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes in this group require authentication AND admin privileges.
| Protected by the 'admin' middleware.
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Level Management
    Route::resource('levels', LevelController::class);
    
    // Course Management
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/reorder', [CourseController::class, 'reorder'])->name('courses.reorder');
    
    // Video Management
    Route::resource('videos', VideoController::class);
    Route::post('videos/{video}/reorder', [VideoController::class, 'reorder'])->name('videos.reorder');
    
    // Notes Management
    Route::resource('notes', NoteController::class);
});

require __DIR__.'/auth.php';

