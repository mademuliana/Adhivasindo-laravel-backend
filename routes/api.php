<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

// Login route (accessible by everyone)
Route::post('login', [AuthenticationController::class, 'login'])->name('login');

// Student-only routes
Route::middleware(['auth:api', \App\Http\Middleware\RoleMiddleware::class.':student'])->group(function () {
    Route::get('student-profile', [UserController::class, 'studentProfile']);
});

// Admin-only routes
Route::middleware(['auth:api', \App\Http\Middleware\RoleMiddleware::class.':admin'])->group(function () {
    Route::get('student-search', [StudentController::class, 'search']);
    Route::post('create-student', [UserController::class, 'createStudent']);
    Route::resource('users', UserController::class);
    Route::resource('students', StudentController::class);
});

