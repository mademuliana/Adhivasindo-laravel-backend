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
    Route::resource('students', StudentController::class);
});

// Admin-only routes
Route::middleware(['auth:api', \App\Http\Middleware\RoleMiddleware::class.':admin'])->group(function () {
    Route::resource('users', UserController::class);
});
