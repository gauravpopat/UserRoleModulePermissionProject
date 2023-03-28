<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModulePermissionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\ModulePermission;
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
<<<<<<< HEAD
    Route::post('create', 'create');
    Route::get('verify-email/{verification_code}', 'verifyEmail'); //Email Verification
    Route::post('login', 'login');
    Route::post('forgot-password-link', 'forgotPasswordLink'); //Reset Password Link
    Route::post('reset-password', 'resetPassword');
=======
    Route::post('create', 'create');    //Create User
    Route::get('verify-email/{verification_code}', 'verifyEmail'); // Email Verification
    Route::post('login', 'login'); // User login
    Route::post('forgot-password-link', 'forgotPasswordLink'); // Reset Password Mail Link
    Route::post('reset-password', 'resetPassword'); // Reset password
>>>>>>> develop
});

//User-Profile

Route::middleware(['auth:sanctum'])->group(function () {
<<<<<<< HEAD
    Route::controller(UserController::class)->prefix('user')->group(function(){
        Route::get('profile','show');
    });
});


//--ADMIN--//

Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    
=======
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('profile', 'list'); // User and their roles
        Route::post('update', 'update'); // Update user roles
        Route::get('delete', 'delete'); // Delete user and their roles
        Route::get('show', 'show'); // Show only user detail
    });
});

// Route::middleware(['auth:sanctum'])->group(function () {

>>>>>>> develop
    //Module
    Route::controller(ModuleController::class)->prefix('module')->group(function () {
        Route::get('list', 'list');
        Route::post('create', 'create');
        Route::post('update/{id}', 'update');
        Route::get('delete/{id}', 'delete');
        Route::get('show/{id}', 'show');
    });

    //Permission
    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('list', 'list');
        Route::post('create', 'create');
        Route::post('update/{id}', 'update');
        Route::get('delete/{id}', 'delete');
        Route::get('show/{id}', 'show');
    });

    //Role
<<<<<<< HEAD
    Route::controller(RoleController::class)->prefix('role')->group(function(){
        Route::get('list','list');
        Route::post('create','create');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','delete');
        Route::get('show/{id}','show');        
    });

    //Module Permission
    Route::controller(ModulePermissionController::class)->prefix('module-permission')->group(function(){
        Route::post('create','create');
    });

});
=======
    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('list', 'list');
        Route::post('create', 'create');
        Route::post('update/{id}', 'update');
        Route::get('delete/{id}', 'delete');
        Route::get('show/{id}', 'show');
    });

    //Module Permission
    Route::controller(ModulePermissionController::class)->prefix('module-permission')->group(function () {
        Route::post('create', 'create');
        Route::post('update/{id}','update');
        Route::get('delete/{id}','delete');
    });
// });
>>>>>>> develop
