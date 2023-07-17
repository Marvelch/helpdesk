<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GeneralAccessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestBooksController;
use App\Http\Controllers\RequestHardwareSoftwareController;
use App\Http\Controllers\RequestTicketController;
use App\Http\Controllers\TypeOfWorkController;
use App\Http\Controllers\UsersController;
use App\Models\company;
use App\Models\requestTicket;
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
})->name('/');

Auth::routes([
  'register' => false, 
//   'login' => false, 
]);

// Route::get('/usersas',[UsersController::class,'index'])->name('users.index');

Route::get('/home', function() {
    return view('pages.dashboard.index');
})->name('home')->middleware('auth');

Route::get('logout',[LoginController::class,'logout'])->middleware('auth');

Route::group(['prefix' => 'bank-accounts','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[BankAccountsController::class,'index'])->name('index_bank_accounts');
        Route::get('/create',[BankAccountsController::class,'create'])->name('create_bank_accounts');
        Route::get('/{id}/edit',[BankAccountsController::class,'edit'])->name('edit_bank_accounts');
        Route::get('/{id}/show',[BankAccountsController::class,'show'])->name('show_bank_accounts');
        Route::put('/{id}/update',[BankAccountsController::class,'update'])->name('update_bank_accounts');
        Route::post('/store',[BankAccountsController::class,'store'])->name('store_bank_accounts');
        Route::get('/download/{id}',[BankAccountsController::class,'download'])->name('download_bank_accounts');
        Route::post('/destroy/{id}',[BankAccountsController::class,'destroy'])->name('destroy_bank_accounts');
    });
});

Route::group(['prefix' => 'division','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/create',[DivisionController::class, 'create'])->name('create_division');
        Route::post('/store',[DivisionController::class, 'store'])->name('store_division');
    });
});

Route::group(['prefix' => 'general_access','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[GeneralAccessController::class, 'index'])->name('index_general_access');
    });
});


Route::group(['prefix' => 'request-tickets','middleware' => ['auth']], function(){
    Route::get('/',[RequestTicketController::class,'index'])->name('index_request_ticket');
    Route::get('/create',[RequestTicketController::class,'create'])->name('create_request_ticket');
    Route::post('/store',[RequestTicketController::class,'store'])->name('store_request_ticket');
    Route::get('/show/{id}',[RequestTicketController::class,'show'])->name('show_request_ticket');
    Route::put('/update/{id}',[RequestTicketController::class,'update'])->name('update_request_ticket');
    Route::get('/approve',[RequestTicketController::class,'approve'])->name('approve_request_ticket');
    Route::get('/search-company',[RequestTicketController::class,'searchCompany']);
    Route::get('/search-division/{id}',[RequestTicketController::class,'searchDivision']);
    Route::get('/searching-users',[RequestTicketController::class,'searchUsers']);
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        
    });
});

Route::group(['prefix' => 'request-hardware-software','middleware' => ['auth']], function(){
    
    Route::get('/',[RequestHardwareSoftwareController::class,'index'])->name('index_request_hardware_software');
    Route::get('/searching-inventory',[RequestHardwareSoftwareController::class,'searchInventory']);
    Route::get('/create',[RequestHardwareSoftwareController::class,'create'])->name('create_request_hardware_software');
    Route::post('/store',[RequestHardwareSoftwareController::class,'store'])->name('store_request_hardware_software');
    Route::post('/store/hardware-software',[RequestHardwareSoftwareController::class,'storeFromTicket'])->name('store_hardware_software_request_hardware_software');
    Route::get('/edit/{id}',[RequestHardwareSoftwareController::class,'edit'])->name('edit_request_hardware_software');
    Route::get('/show/{id}',[RequestHardwareSoftwareController::class,'show'])->name('show_request_hardware_software');

    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/create/{id}/request-ticket',[RequestHardwareSoftwareController::class,'createRequestTicket'])->name('create_ticket_request_hardware_software');
        Route::post('/delete/{id}/detail',[RequestHardwareSoftwareController::class,'destroyDetail'])->name('delete_detail_request_hardware_software');
        Route::put('/update',[RequestHardwareSoftwareController::class,'update'])->name('update_request_hardware_software');
    });
});

Route::group(['prefix' => 'users','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[HomeController::class,'index'])->name('index_users');
        Route::get('/create',[HomeController::class,'create'])->name('create_users');
        Route::get('/{id}/edit',[HomeController::class,'edit'])->name('edit_users');
        Route::post('/store',[HomeController::class,'store'])->name('store_users');
        Route::put('/{id}/update',[HomeController::class,'update'])->name('update_users');
    });
});

Route::group(['prefix' => 'type-of-work','auth'], function(){
    Route::get('/create',[TypeOfWorkController::class,'create'])->name('create_type_of_work');
    Route::post('/store',[TypeOfWorkController::class,'store'])->name('store_type_of_work');
});

Route::group(['prefix' => 'profile','auth'], function(){
     Route::get('/',[HomeController::class, 'profile'])->name('profile_users');
});

Route::group(['prefix' => 'notification','auth'], function(){
     Route::get('/',[NotificationController::class, 'index'])->name('index_notification');
});

Route::group(['prefix' => 'inventory','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[InventoryController::class,'index'])->name('index_inventory');
        Route::get('/create',[InventoryController::class,'create'])->name('create_inventory');
        Route::get('/create/transaction',[InventoryController::class,'createTransaction'])->name('create_transaction_inventory');
        Route::post('/store',[InventoryController::class,'store'])->name('store_inventory');
        Route::post('/store/transaction',[InventoryController::class,'storeTransaction'])->name('store_transaction_inventory');
        Route::get('/search/items',[InventoryController::class,'searchItemName']);
        Route::get('/show/{id}',[InventoryController::class,'show'])->name('show_inventory');
        Route::post('/destroy/{id}',[InventoryController::class,'destroy'])->name('destroy_inventory');
        Route::post('/scan',[InventoryController::class,'scanBercode'])->name('scan_inventory');
        Route::post('/store-barcode',[InventoryController::class,'storeBercode'])->name('store_barcode_transaction_inventory');
    });
});

Route::get('/logout', function(){
   Auth::logout();
   return Redirect::to('/');
});

Route::get('/pusher', function(){
   return view('pusher');
});

Route::get('test',[HomeController::class,'pusherNotif']);
