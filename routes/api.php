<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SectionController;
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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'create_user']);
// Route::post('/instructor_register', [AuthController::class, 'instructor_register']);






Route::middleware('auth:sanctum')->group(function () {

    Route::post('/create_section', [SectionController::class, 'create_section']);
    Route::post('update_section', [SectionController::class, 'update_section']);
    Route::delete('/delete_section/{id}', [SectionController::class, 'delete_section']);
    Route::get('list_of_sections', [SectionController::class, 'list_of_sections']);


    Route::post('/create_course', [CourseController::class, 'create_course']);
    Route::post('update_course', [CourseController::class, 'update_course']);
    Route::delete('/delete_course/{id}', [CourseController::class, 'delete_course']);
    Route::get('/show/{id}', [CourseController::class, 'show']);
    Route::get('list_of_courses', [CourseController::class, 'list_of_courses']);



    Route::post('/enroll_in_course', [CartController::class, 'enroll_in_course']);
    Route::get('/my_cart', [CartController::class, 'show']);
    Route::delete('/delete_cart_course/{id}', [CartController::class, 'delete_cart_course']);
});
