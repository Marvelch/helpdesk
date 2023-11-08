<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\GeneralAccessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestBooksController;
use App\Http\Controllers\RequestHardwareSoftwareController;
use App\Http\Controllers\RequestTicketController;
use App\Http\Controllers\TypeOfWorkController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkTypeController;
use App\Models\bankAccounts;
use App\Models\company;
use App\Models\inventory;
use App\Models\RequestHardwareSoftware;
use App\Models\requestTicket;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;

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

Route::post('/telegram/webhook', 'TelegramController@handleWebhook');

Route::get('/telegram',function() {
    $telegram = new \Telegram\Bot\Api(env('TELEGRAM_TOKEN'));
    $response = $telegram->setWebhook(['url' => 'https://localhost:8000/telegram/webhook']);
});

Route::get('/', function () {
    return view('welcome');
})->name('/');

Auth::routes([
  'register' => false,
//   'login' => false,
]);

// Route::get('/usersas',[UsersController::class,'index'])->name('users.index');

Route::get('/home', function() {
    $users = User::all();
        $online_users = 0;
        foreach ($users as $user) {
            if (Cache::has('user-online' . $user->id)){
                $online_users++;
            }
        }

    $countUsers = User::all()->count();

    $countPasswordManagers = bankAccounts::all()->count();

    $countRequestTicket = requestTicket::all()->count();

    $countInventory = inventory::all()->count();

    $complate = RequestHardwareSoftware::select('id', 'created_at')
        ->where('status',2)
        ->whereYear('created_at', '=', date('Y',strtotime(Now())))
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
    });

    $complateCount = [];
    $resultComplate = [];

    foreach ($complate as $key => $value) {
        $complateCount[(int)$key] = count($value);
    }

    for ($i = 0; $i <= 11; $i++) {
        if (!empty($complateCount[$i])) {
            $resultComplate[] = $complateCount[$i];
        } else {
            $resultComplate[] = 0;
        }
    }

    // Uncompleted
    $uncompleted = RequestHardwareSoftware::select('id', 'created_at')
        ->where('status',3)
        ->whereYear('created_at', '=', date('Y',strtotime(Now())))
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
    });

    $uncompletedCount = [];
    $resultUncompleted = [];

    foreach ($uncompleted as $key => $value) {
        $uncompletedCount[(int)$key] = count($value);
    }

    for ($i = 0; $i <= 11; $i++) {
        if (!empty($uncompletedCount[$i])) {
            $resultUncompleted[] = $uncompletedCount[$i];
        } else {
            $resultUncompleted[] = 0;
        }
    }

    // InProgress
    $inprogress = RequestHardwareSoftware::select('id', 'created_at')
        ->where('status',1)
        ->whereYear('created_at', '=', date('Y',strtotime(Now())))
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
    });

    $inprogressCount = [];
    $resultinprogress = [];

    foreach ($inprogress as $key => $value) {
        $inprogressCount[(int)$key] = count($value);
    }

    for ($i = 0; $i <= 11; $i++) {
        if (!empty($inprogressCount[$i])) {
            $resultinprogress[] = $inprogressCount[$i];
        } else {
            $resultinprogress[] = 0;
        }
    }

    //Checking
    $checking = RequestHardwareSoftware::select('id', 'created_at')
        ->where('status',0)
        ->whereYear('created_at', '=', date('Y',strtotime(Now())))
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
    });

    $checkingCount = [];
    $resultchecking = [];

    foreach ($checking as $key => $value) {
        $checkingCount[(int)$key] = count($value);
    }

    for ($i = 0; $i <= 11; $i++) {
        if (!empty($checkingCount[$i])) {
            $resultchecking[] = $checkingCount[$i];
        } else {
            $resultchecking[] = 0;
        }
    }

    //Inventory Reports

    $inventoryData = RequestHardwareSoftware::select('id', 'created_at')
        ->whereYear('created_at', '=', date('Y',strtotime(Now())))
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m');
    });

    $inventoryCount = [];
    $resultInventory = [];

    foreach ($checking as $key => $value) {
        $inventoryCount[(int)$key] = count($value);
    }

    for ($i = 0; $i <= 11; $i++) {
        if (!empty($inventoryCount[$i])) {
            $resultInventory[] = $inventoryCount[$i];
        } else {
            $resultInventory[] = 0;
        }
    }

    return view('pages.dashboard.index',compact('online_users','countUsers','countPasswordManagers','countRequestTicket','countInventory','resultComplate','resultUncompleted','resultinprogress','resultchecking','resultInventory'));
})->name('home')->middleware('auth');

Route::get('logout',[LoginController::class,'logout'])->middleware('auth');

Route::group(['prefix' => 'bank-accounts','middleware' => ['auth']], function(){
    Route::get('/download/{id}',[BankAccountsController::class,'download'])->name('download_bank_accounts');

    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[BankAccountsController::class,'index'])->name('index_bank_accounts');
        Route::get('/create',[BankAccountsController::class,'create'])->name('create_bank_accounts');
        Route::get('/{id}/edit',[BankAccountsController::class,'edit'])->name('edit_bank_accounts');
        Route::get('/{id}/show',[BankAccountsController::class,'show'])->name('show_bank_accounts');
        Route::put('/{id}/update',[BankAccountsController::class,'update'])->name('update_bank_accounts');
        Route::post('/store',[BankAccountsController::class,'store'])->name('store_bank_accounts');
        Route::post('/destroy/{id}',[BankAccountsController::class,'destroy'])->name('destroy_bank_accounts');
    });
});

Route::group(['prefix' => 'division','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[DivisionController::class, 'index'])->name('index_division');
        Route::get('/create',[DivisionController::class, 'create'])->name('create_division');
        Route::delete('/delete/{id}',[DivisionController::class, 'destroy'])->name('destroy_division');
        Route::post('/store',[DivisionController::class, 'store'])->name('store_division');
    });
});

Route::group(['prefix' => 'general_access','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[GeneralAccessController::class, 'index'])->name('index_general_access');

        // Page work type
        Route::get('/type/index',[GeneralAccessController::class, 'index_type'])->name('index_type_general_access');
        Route::post('/type/store',[GeneralAccessController::class, 'store_type'])->name('store_type_general_access');
    });
});

Route::group(['prefix' => 'work-type','middleware' => ['auth']], function(){
    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::get('/',[WorkTypeController::class, 'index'])->name('index_type');
        Route::delete('/delete/{id}',[WorkTypeController::class, 'destroy'])->name('destroy_type');
    });
});


Route::group(['prefix' => 'request-tickets','middleware' => ['auth']], function(){
    Route::get('/',[RequestTicketController::class,'index'])->name('index_request_ticket');
    Route::get('/create',[RequestTicketController::class,'create'])->name('create_request_ticket');
    Route::post('/store',[RequestTicketController::class,'store'])->name('store_request_ticket');
    Route::get('/show/{id}',[RequestTicketController::class,'show'])->name('show_request_ticket');
    Route::put('/update/{id}',[RequestTicketController::class,'update'])->name('update_request_ticket');
    Route::put('/update-status/{id}',[RequestTicketController::class,'updateStatus'])->name('update_status_request_ticket');
    Route::get('/approve',[RequestTicketController::class,'approve'])->name('approve_request_ticket');
    Route::get('/search-company',[RequestTicketController::class,'searchCompany']);
    Route::get('/search-division/{id}',[RequestTicketController::class,'searchDivision']);
    Route::get('/searching-users',[RequestTicketController::class,'searchUsers']);
    Route::get('/searching/users/assign/to',[RequestTicketController::class,'search_users_assign']);
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
    Route::put('/update',[RequestHardwareSoftwareController::class,'update'])->name('update_request_hardware_software');
    Route::get('/create/{id}/request-ticket',[RequestHardwareSoftwareController::class,'createRequestTicket'])->name('create_ticket_request_hardware_software');
    Route::post('/destroy/{id}',[RequestHardwareSoftwareController::class,'destroy'])->name('destroy_request_hardware_software');

    Route::middleware(['UserLevel:'.env('LEVEL_ADMIN').','.env('LEVEL_EDITOR')])->group(function(){
        Route::post('/delete/{id}/detail',[RequestHardwareSoftwareController::class,'destroyDetail'])->name('delete_detail_request_hardware_software');
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
     Route::get('/',[UsersController::class, 'profile'])->name('profile_users');
     Route::put('/update-photo/{id}',[UsersController::class, 'updatePhoto'])->name('update_photo_users');
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

Route::group(['prefix' => 'news','middleware' => ['auth']], function(){
    Route::get('/',[NewsController::class,'index'])->name('index_news');
    Route::get('/create',[NewsController::class,'create'])->name('create_news');
    Route::post('/store',[NewsController::class,'store'])->name('store_news');
});

Route::get('/logout', function(){
   Auth::logout();
   return Redirect::to('/');
});

Route::get('/pusher', function(){
   return view('pusher');
});

Route::get('test',[HomeController::class,'pusherNotif']);
