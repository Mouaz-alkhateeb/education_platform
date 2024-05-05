<?php

use App\Http\Controllers\Api\AuthController;
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

Route::post('/create_section', [SectionController::class, 'create_section']);
Route::patch('update_section', [SectionController::class, 'update_section']);
Route::delete('/delete_section/{id}', [SectionController::class, 'delete_section']);
Route::get('list_of_sections', [SectionController::class, 'list_of_sections']);


Route::post('/create_course', [CourseController::class, 'create_course']);
Route::patch('update_course', [CourseController::class, 'update_course']);
Route::delete('/delete_course/{id}', [CourseController::class, 'delete_course']);
Route::get('/show/{id}', [CourseController::class, 'show']);
Route::get('list_of_courses', [CourseController::class, 'list_of_courses']);
