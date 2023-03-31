<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// app\http\middleware\authenticate.php
Route::get('unauthenticated', function () {
    return error('Unauthenticated', 'Token not found', 'unauthenticated');
})->name('unauthenticated');


// Authetication
Route::controller(AuthController::class)->group(function () {
    Route::post('create', 'create');    //Create User
    Route::get('verify-email/{verification_code}', 'verifyEmail'); // Email Verification
    Route::post('login', 'login'); // User login
    Route::post('forgot-password-link', 'forgotPasswordLink'); // Reset Password Mail Link
    Route::post('reset-password', 'resetPassword'); // Reset password
});

// Module
Route::controller(ModuleController::class)->prefix('module')->group(function () {
    Route::get('list', 'list'); // List of Modules
    Route::post('create', 'create'); // Create Module
    Route::post('update/{id}', 'update'); // Update Module
    Route::get('show/{id}', 'show'); // Show Module
    Route::get('delete/{id}', 'delete'); // Delete Module
});

// Permission
Route::controller(PermissionController::class)->prefix('permission')->group(function () {
    Route::get('list', 'list'); //List of Permissions
    Route::post('create', 'create'); // Create Permission
    Route::post('update/{id}', 'update'); // Update Permission
    Route::get('show/{id}', 'show'); // Show Permission
    Route::get('delete/{id}', 'delete'); // Delete Permission
});

//Role
Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('list', 'list'); //List of Roles
    Route::post('create', 'create'); // Create Role
    Route::post('update/{id}', 'update'); // Update Role
    Route::get('show/{id}', 'show'); // Show Role
    Route::get('delete/{id}', 'delete'); // Delete Role
});

//Module Permission
Route::controller(ModulePermissionController::class)->prefix('module-permission')->group(function () {
    Route::post('create', 'create'); // Create Module Permission with CRUD ACCEESS
    Route::post('update/{id}', 'update'); // Update Module Permission
    Route::get('show/{id}', 'show'); // Show Module Permission
    Route::get('delete/{id}', 'delete'); // Delete Module Permission
});


//For Logged in User
Route::middleware('auth:sanctum')->group(function () {

    //User Profile
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::post('update', 'update'); // Update user roles
        Route::get('show', 'show'); // User with roles.
        Route::get('logout', 'logout'); // Logout the user.
        Route::get('delete', 'delete'); // Delete user and their roles
    });

    //Middleware
    //Company Module
    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:company,list_access']); // List of Companies
        Route::post('create', 'create')->middleware(['hasAccess:company,create_access']); // Create Company
        Route::post('update', 'update')->middleware(['hasAccess:company,update_access']); // Update Company
        Route::get('show/{id}', 'show')->middleware(['hasAccess:company,show_access']); // Show Company
        Route::get('delete', 'delete')->middleware(['hasAccess:company,delete_access']); // Delete Company
    });

    //Project Module
    Route::controller(ProjectController::class)->prefix('project')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:project,list_access']); // List of Projects
        Route::post('create', 'create')->middleware(['hasAccess:project,create_access']); // Create Project
        Route::post('update', 'update')->middleware(['hasAccess:project,update_access']); // Update Project
        Route::get('show/{id}', 'show')->middleware(['hasAccess:project,show_access']); // Show Project
        Route::get('delete', 'delete')->middleware(['hasAccess:project,delete_access']); // Delete Project
    });

    //Employee Module
    Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:employee,list_access']); // List of Employees
        Route::post('create', 'create')->middleware(['hasAccess:employee,create_access']); // Create Employee
        Route::post('update', 'update')->middleware(['hasAccess:employee,update_access']); // Update Employee
        Route::get('show/{id}', 'show')->middleware(['hasAccess:employee,show_access']); // Show Employee
        Route::get('delete', 'delete')->middleware(['hasAccess:employee,delete_access']); // Delete Employee
    });
});
