<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
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

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum', 'role:admin')->get('/admin/list', [UserController::class, 'get_admin_list'])->name("get_admin_list");
Route::middleware('auth:sanctum', 'role:admin')->post('/add-admin', [AuthController::class, 'add_admin'])->name("add_admin");



Route::middleware('auth:sanctum', 'role:admin')->get('/counsellor/list', [UserController::class, 'get_counsellor_list'])->name("get_counsellor_list");


Route::middleware('auth:sanctum', 'role:admin')->post('/add-counsellor', [AuthController::class, 'add_counsellor'])->name("add_counsellor");


Route::middleware('auth:sanctum', 'role:admin|counsellor')->get('/student/list', [UserController::class, 'get_student_list'])->name("get_student_list");

Route::middleware('auth:sanctum', 'role:admin|counsellor')->post('/add-student', [AuthController::class, 'add_student'])->name("add_student");



Route::middleware('auth:sanctum')->patch('/update-profile', [UserController::class, 'update_profile'])->name("update_profile");

Route::middleware('auth:sanctum')->get('/get-profile/{id}', [UserController::class, 'get_profile'])->name("get_profile");

Route::middleware('auth:sanctum', 'role:admin|counsellor')->patch('/update-user-profile/{user}', [UserController::class, 'update_user_profile'])->name("update_user_profile");

Route::middleware('auth:sanctum', 'role:admin')->delete('/delete-user-profile/{user}', [UserController::class, 'delete_user_profile'])->name("delete_user_profile");





// Analytics
Route::middleware('auth:sanctum', 'role:admin|counsellor')->get('/user-count', [UserController::class, 'get_user_count'])->name("get_user_count");

// Student 

Route::middleware('auth:sanctum')->get('/student-detail/{id}', [StudentController::class, 'get_student_detail'])->name("get_student_detail");


Route::middleware('auth:sanctum', 'role:admin|counsellor')->post('/student-detail', [StudentController::class, 'store_student_detail'])->name("store_student_detail");



Route::middleware('auth:sanctum', 'role:admin|counsellor')->patch('/student-detail/{student:user_id}', [StudentController::class, 'update_student_detail'])->name("update_student_detail");

Route::get('/download-files/{student}', [StudentController::class, 'download_student_files'])->name("download_student_files");


