<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\WishlistController;
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
    Route::patch('/update_course_status/{id}', [CourseController::class, 'update_status']);
    Route::get('/show/{id}', [CourseController::class, 'show']);
    Route::get('list_of_courses', [CourseController::class, 'list_of_courses']);



    Route::post('/enroll_in_course', [CartController::class, 'enroll_in_course']);
    Route::get('/my_cart', [CartController::class, 'show']);
    Route::delete('/delete_cart_course/{id}', [CartController::class, 'delete_cart_course']);
    Route::get('cart_count', [CartController::class, 'cart_count']);
    Route::post('place_order', [CheckoutController::class, 'place_order']);
    Route::get('orders', [CheckoutController::class, 'my_orders']);


    Route::get('wishlist', [WishlistController::class, 'show']);
    Route::post('add_to_wishlist', [WishlistController::class, 'add_to_wishlist']);
    Route::get('wishlist_count', [WishlistController::class, 'wishlist_count']);
    Route::delete('/remove_wishlist_item/{id}', [WishlistController::class, 'remove_wishlist_item']);

    Route::post('rating', [RatingController::class, 'rating']);
    Route::post('review', [ReviewController::class, 'review']);
    Route::post('update_review', [ReviewController::class, 'update_review']);
    Route::delete('/delete_review/{id}', [ReviewController::class, 'delete_review']);



    Route::post('/create_live_event', [VideoController::class, 'createLiveEvent']);
    Route::post('/end_event/{id}', [VideoController::class, 'endEvent']);
    Route::delete('/live_events/{liveEventId}', [VideoController::class, 'deleteEvent']);
    Route::get('/live_events', [VideoController::class, 'getAllLiveEvents']);




    Route::post('/upload', [VideoController::class, 'upload']);
    Route::get('/videos/{videoId}/links', [VideoController::class, 'getVideoLinks']);
    Route::delete('/videos/{videoId}', [VideoController::class, 'deleteVideo']);
});
