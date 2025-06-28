<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\SuiviController;
use App\Http\Controllers\UserController;
use App\Livewire\FacturesTable;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('auth.login');
});

// Assistant Director Static Pages
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Authenticated Routes
Route::middleware('auth' )->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients/post-sale-stats', [DashboardController::class, 'postSaleStats']);

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Invoices
    Route::get('/factures', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::post('invoice/store-all', [InvoiceController::class, 'storeAll'])->name('invoice.storeAll');
    Route::put('/invoices/{id}/update', [InvoiceController::class, 'updateInvoice'])->name('invoices.update');
    Route::post('/invoices/{id}/update', [InvoiceController::class, 'updateInvoice'])->name('invoices.update.post');
    Route::patch('/invoices/{id}', [InvoiceController::class, 'updateInvoice'])->name('invoices.patch');
    Route::post('/invoices/delete', [FacturesTable::class, 'deleteInvoice'])->name('invoices.delete');

    // Existing routes...
Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');   // Suivis
    // Route::get('/suivis', [SuiviController::class, 'index'])->name('page.suivis');
    // Route::post('/suivis', [SuiviController::class, 'store'])->name('suivis.store');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Statistiques
    Route::get('/statistiques', [StatistiquesController::class, 'index'])->name('statistics.index');
    Route::get('/statistiques/clients-with-payments', [StatistiquesController::class, 'clientsWithPaymentsAjax'])->name('statistics.clientsWithPaymentsAjax');

    // Export
    Route::get('/exporter', [ExportController::class, 'showExportPage'])->name('export.page');
    Route::post('/exporter/run', [ExportController::class, 'handleExport'])->name('export.handle');


    // Reclamations
    Route::get('/reclamations', [ReclamationController::class, 'index'])->name('reclamations.index');
    Route::get('/reclamations/create', [ReclamationController::class, 'create'])->name('reclamations.create');
    Route::post('/reclamations', [ReclamationController::class, 'store'])->name('reclamations.store');
    Route::get('/reclamations/{reclamation}', [ReclamationController::class, 'show'])->name('reclamations.show');
    Route::get('/reclamations/{reclamation}/edit', [ReclamationController::class, 'edit'])->name('reclamations.edit');
    Route::put('/reclamations/{id}', [ReclamationController::class, 'update'])->name('reclamations.update');
    Route::delete('/reclamations/{reclamation}', [ReclamationController::class, 'destroy'])->name('reclamations.destroy');
    Route::get('/reclamations/filter/{status}', [ReclamationController::class, 'filterByStatus'])->name('reclamations.filter');

    // Notifications (Dynamic)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
});

// Auth Routes
require __DIR__ . '/auth.php';
