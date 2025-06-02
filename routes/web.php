<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SuiviController;

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
    Route::get('/clients' ,[ClientController::class, 'index'])->name('client.index');
    Route::view('/entretiens', 'page.entretiens');
    Route::view('/reclamations', 'page.reclamations');
    Route::view('/statistiques', 'page.statistiques');
    Route::view('/exporter', 'page.exporter');
});

});
// routes/web.php


// Authentication Routes
require __DIR__.'/auth.php';
