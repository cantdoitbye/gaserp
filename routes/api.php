<?php

use App\Http\Controllers\Api\ContactFormApiController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\EnquiryController;
use App\Http\Controllers\Api\v1\HolidayController;
use App\Http\Controllers\Api\v1\HotelController;
use App\Http\Controllers\Api\v1\RazorpayController;
use App\Http\Controllers\Api\v1\UserQueryController;
use App\Http\Controllers\Api\v1\VisaApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware(['cors'])->group(function () {

Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/user', [AuthController::class, 'user']);
    Route::get('/v1/logout', [AuthController::class, 'logout']);

    // Add user profile endpoint for logged-in users
    Route::get('/v1/profile', [AuthController::class, 'profile']);

});

Route::post('/v1/contact', [ContactFormApiController::class, 'store']);



// });
Route::get('/v1/csrf-token', function (Request $request) {
    $token = csrf_token();
    // \Log::info('Generated CSRF token: ' . $token);
    return response()->json(['csrf_token' => $token]);
});












