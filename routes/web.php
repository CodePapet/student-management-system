<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Students (administrator)
    Route::get('/students/create', [StudentController::class, 'create'])->middleware('permission:create students')->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->middleware('permission:create students')->name('students.store');
    Route::get('/students', [StudentController::class, 'index'])->middleware('permission:view students')->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'show'])->middleware('permission:view students')->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->middleware('permission:edit students')->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->middleware('permission:edit students')->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->middleware('permission:delete students')->name('students.destroy');

    // Courses (admin manages; lecturers see assigned; students see available)
    $viewCourses = 'permission:view courses|view assigned courses|view available courses';
    Route::get('/courses/create', [CourseController::class, 'create'])->middleware('permission:create courses')->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->middleware('permission:create courses')->name('courses.store');
    Route::get('/courses', [CourseController::class, 'index'])->middleware($viewCourses)->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->middleware($viewCourses)->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->middleware('permission:edit courses')->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->middleware('permission:edit courses')->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->middleware('permission:delete courses')->name('courses.destroy');
    Route::post('/courses/{course}/register', [RegistrationController::class, 'register'])->middleware('permission:register courses')->name('courses.register');

    // Registrations
    Route::get('/registrations/create', [RegistrationController::class, 'create'])->middleware('permission:manage registrations')->name('registrations.create');
    Route::post('/registrations', [RegistrationController::class, 'store'])->middleware('permission:manage registrations')->name('registrations.store');
    Route::get('/registrations', [RegistrationController::class, 'index'])->middleware('permission:manage registrations|view own registrations')->name('registrations.index');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->middleware('permission:manage registrations|view own registrations')->name('registrations.destroy');

    // User access (administrator)
    Route::middleware('permission:manage users')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
