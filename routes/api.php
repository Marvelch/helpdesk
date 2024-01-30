<?php

use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\JobDescController;
use App\Http\Controllers\RequestTicketController;
use App\Http\Controllers\WorkTypeController;
use App\Models\requestTicket;
use App\Models\WorkType;
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

Route::get('/news',[NewsApiController::class,'getAll']);

Route::prefix('news')->group(function() {
    Route::get('/getAll',[NewsApiController::class,'getAll']);
});

Route::prefix('jobs')->group(function() {
    Route::get('work-type',[WorkTypeController::class,'getData']);

    // CREATE NEW REQUEST TICKET
    Route::post('store',[RequestTicketController::class,'storeReqApi']);
});
