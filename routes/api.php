<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//--USER--//

//Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('create', 'create');    //Create User
    Route::get('verify-email/{verification_code}', 'verifyEmail'); // Email Verification
    Route::post('login', 'login'); // User login
    Route::post('forgot-password-link', 'forgotPasswordLink'); // Reset Password Mail Link
    Route::post('reset-password', 'resetPassword'); // Reset password
});

//User-Profile

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('profile', 'list'); // User and their roles
        Route::post('update', 'update'); // Update user roles
        Route::get('show', 'show'); // Show only user detail
        Route::get('delete', 'delete'); // Delete user and their roles
    });
});

// Route::middleware(['auth:sanctum'])->group(function () {

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


//Blog Module
Route::controller(BlogController::class)->prefix('blog')->group(function(){
    Route::post('create','returnResponse');
    Route::post('update','returnResponse');
    Route::get('show','returnResponse');
    Route::get('delete','returnResponse');
});

//Employee Module
Route::controller(EmployeeController::class)->prefix('employee')->group(function(){
    Route::post('create','returnResponse');
    Route::post('update','returnResponse');
    Route::get('show','returnResponse');
    Route::get('delete','returnResponse');
});

//Employee Module
Route::controller(CourseController::class)->prefix('course')->group(function(){
    Route::post('create','returnResponse');
    Route::post('update','returnResponse');
    Route::get('show','returnResponse');
    Route::get('delete','returnResponse');
});


// });
