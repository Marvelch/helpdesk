<?php

use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('pages.dashboard.index');
});

Route::group(['prefix' => 'bank-accounts'], function(){
    Route::get('/',[BankAccountsController::class, 'index']);
    Route::get('/create',[BankAccountsController::class, 'create']);
    Route::get('/{id}/edit',[BankAccountsController::class, 'edit']);
    Route::put('/{id}/update',[BankAccountsController::class, 'update']);
    Route::post('/store',[BankAccountsController::class, 'store']);
});

Route::group(['prefix' => 'users','auth'], function(){
    Route::get('/profile',[HomeController::class, 'profile']);
    
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[HomeController::class,'index'])->name('add-users');
    });

    Route::post('/store',[HomeController::class,'store']);
});