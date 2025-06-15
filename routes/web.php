<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuiviController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\ExportController;
use App\Livewire\FacturesTable;

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

// Home
Route::get('/', function () {
    return view('auth.login');
});


// Assistant Director Static Pages
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});



// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/suivis', [SuiviController::class, 'store'])->name('suivis.store');
    Route::get('/clients/post-sale-stats', [DashboardController::class, 'postSaleStats']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('')->group(function () {
    Route::get('/suivis', [SuiviController::class, 'index'])->name('page.suivis');
    Route::view('/notifications', 'page.notifications');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/factures' ,[InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/clients' ,[ClientController::class, 'index'])->name('client.index');
    Route::post('invoice/store-all', [InvoiceController::class, 'storeAll'])->name('invoice.storeAll');
    Route::view('/reclamations', 'page.reclamations');
    Route::get('/statistiques', [StatistiquesController::class, 'index'])->name('statistics.index');

    // Route::view('/exporter', 'page.exporter');
    Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/exporter', [ExportController::class, 'showExportPage'])->name('export.page');
Route::post('/invoices/delete', [FacturesTable::class, 'deleteInvoice'])->name('invoices.delete');

// Route to handle the export form submission
Route::post('/exporter/run', [ExportController::class, 'handleExport'])->name('export.handle');
});

});
Route::put('/invoices/{id}/update', [InvoiceController::class, 'updateInvoice'])
    ->name('invoices.update')
    ->middleware(['auth']);
// Alternative route if you prefer POST method
Route::post('/invoices/{id}/update', [InvoiceController::class, 'updateInvoice'])
    ->name('invoices.update.post')
    ->middleware(['auth']);

// If you want to use PATCH method (RESTful)
Route::patch('/invoices/{id}', [InvoiceController::class, 'updateInvoice'])
    ->name('invoices.patch')
    ->middleware(['auth']);
// routes/web.php


// Authentication Routes
require __DIR__.'/auth.php';
