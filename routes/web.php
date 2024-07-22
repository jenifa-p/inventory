<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/inventory/index', [InventoryController::class, 'index'])->name('inventoryindex');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventorycreate');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventorystore');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventoryedit');
    Route::put('/inventory/{inventory}/update', [InventoryController::class, 'update'])->name('inventoryupdate');
    Route::delete('/inventory/{inventory}/destroy', [InventoryController::class, 'destroy'])->name('inventorydestroy');
    Route::get('/inventorytrack/index', [InventoryController::class, 'trackingindex'])->name('trackingindex');
    Route::get('inventory/export', [InventoryController::class, 'export'])->name('inventoryexport');
    Route::post('inventory/import', [InventoryController::class, 'import'])->name('inventoryimport');
    Route::get('inventory/search', [InventoryController::class, 'search'])->name('inventorysearch');
});
