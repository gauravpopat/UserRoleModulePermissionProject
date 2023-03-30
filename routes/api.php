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

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('create', 'create');    //Create User
    Route::get('verify-email/{verification_code}', 'verifyEmail'); // Email Verification
    Route::post('login', 'login'); // User login
    Route::post('forgot-password-link', 'forgotPasswordLink'); // Reset Password Mail Link
    Route::post('reset-password', 'resetPassword'); // Reset password
});

//Module
Route::controller(ModuleController::class)->prefix('module')->group(function () {
    Route::get('list', 'list');
    Route::post('create', 'create');
    Route::post('update/{id}', 'update');
    Route::get('show/{id}', 'show');
    Route::get('delete/{id}', 'delete');
});

//Permission
Route::controller(PermissionController::class)->prefix('permission')->group(function () {
    Route::get('list', 'list');
    Route::post('create', 'create');
    Route::post('update/{id}', 'update');
    Route::get('show/{id}', 'show');
    Route::get('delete/{id}', 'delete');
});

//Role
Route::controller(RoleController::class)->prefix('role')->group(function () {
    Route::get('list', 'list');
    Route::post('create', 'create');
    Route::post('update/{id}', 'update');
    Route::get('show/{id}', 'show');
    Route::get('delete/{id}', 'delete');
});

//Module Permission
Route::controller(ModulePermissionController::class)->prefix('module-permission')->group(function () {
    Route::post('create', 'create');
    Route::post('update/{id}', 'update');
    Route::get('show/{id}', 'show');
    Route::get('delete/{id}', 'delete');
});

Route::middleware('auth:sanctum')->group(function () {

    //User Profile
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('list', 'list'); // User and their roles
        Route::post('update', 'update'); // Update user roles
        Route::get('show', 'show'); // Show only user detail
        Route::get('delete', 'delete'); // Delete user and their roles
    });

    //Middleware
    //Company Module
    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:company,list_access']);
        Route::post('create', 'create')->middleware(['hasAccess:company,create_access']);
        Route::post('update', 'update')->middleware(['hasAccess:company,update_access']);
        Route::get('show/{id}', 'show')->middleware(['hasAccess:company,show_access']);
        Route::get('delete', 'delete')->middleware(['hasAccess:company,delete_access']);
    });

    //Project Module
    Route::controller(ProjectController::class)->prefix('project')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:project,list_access']);
        Route::post('create', 'create')->middleware(['hasAccess:project,create_access']);
        Route::post('update', 'update')->middleware(['hasAccess:project,update_access']);
        Route::get('show/{id}', 'show')->middleware(['hasAccess:project,show_access']);
        Route::get('delete', 'delete')->middleware(['hasAccess:project,delete_access']);
    });

    //Employee Module
    Route::controller(EmployeeController::class)->prefix('employee')->group(function () {
        Route::post('list', 'list')->middleware(['hasAccess:employee,list_access']);
        Route::post('create', 'create')->middleware(['hasAccess:employee,create_access']);
        Route::post('update', 'update')->middleware(['hasAccess:employee,update_access']);
        Route::get('show/{id}', 'show')->middleware(['hasAccess:employee,show_access']);
        Route::get('delete', 'delete')->middleware(['hasAccess:employee,delete_access']);
    });
});
