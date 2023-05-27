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
})->name('home');

Route::group(['prefix' => 'bank-accounts'], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[BankAccountsController::class, 'index']);
        Route::get('/create',[BankAccountsController::class, 'create']);
        Route::get('/{id}/edit',[BankAccountsController::class, 'edit']);
        Route::put('/{id}/update',[BankAccountsController::class, 'update']);
        Route::post('/store',[BankAccountsController::class, 'store']);
    });
});

Route::group(['prefix' => 'users','auth'], function(){
    Route::get('/profile',[HomeController::class, 'profile']);
    
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[HomeController::class,'index'])->name('index_users');
        Route::get('/create',[HomeController::class,'create'])->name('create_users');
        Route::get('/{id}/edit',[HomeController::class,'edit'])->name('edit_users');
        Route::post('/store',[HomeController::class,'store'])->name('store_users');
        Route::put('/{id}/update',[HomeController::class,'update'])->name('update_users');
    });
});

Route::get('/chat', function() {

});
    