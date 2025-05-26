<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
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

// Admin Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisAdmin', 'Admin.suivis');
    Route::view('/notificationsAdmin', 'Admin.notifications');
    Route::view('/prospectsAdmin', 'Admin.prospects');
    Route::view('/clientsAdmin', 'Admin.clients');
    Route::view('/entretiensAdmin', 'Admin.entretiens');
    Route::view('/reclamationsAdmin', 'Admin.reclamations');
    Route::view('/statistiquesAdmin', 'Admin.statistiques');
    Route::view('/exporterAdmin', 'Admin.exporter');
});

// Assistant Director Static Pages
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
});
Route::prefix('')->group(function () {
    Route::view('/suivisDirector', 'page.suivis');
    Route::view('/notificationsDirector', 'page.notifications');
    Route::view('/prospectsDirector', 'page.prospects');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::view('/clientsDirector', 'page.clients');
    Route::view('/entretiensDirector', 'page.entretiens');
    Route::view('/reclamationsDirector', 'page.reclamations');
    Route::view('/statistiquesDirector', 'page.statistiques');
    Route::view('/exporterDirector', 'page.exporter');
});
Route::middleware(['auth', 'verified'])->group(function () {
// Safi Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisSafi', 'page.suivis');
    Route::view('/notificationsSafi', 'page.notifications');
    Route::view('/prospectsSafi', 'page.prospects');
    Route::view('/clientsSafi', 'page.clients');
    Route::view('/entretiensSafi', 'page.entretiens');
    Route::view('/reclamationsSafi', 'page.reclamations');
    Route::view('/statistiquesSafi', 'page.statistiques');
    Route::view('/exporterSafi', 'page.exporter');
});
});
// Essaouira Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisEssaouira', 'page.suivis');
    Route::view('/notificationsEssaouira', 'page.notifications');
    Route::view('/prospectsEssaouira', 'page.prospects');
    Route::view('/clientsEssaouira', 'page.clients');
    Route::view('/entretiensEssaouira', 'page.entretiens');
    Route::view('/reclamationsEssaouira', 'page.reclamations');
    Route::view('/statistiquesEssaouira', 'page.statistiques');
    Route::view('/exporterEssaouira', 'page.exporter');
});

// Sidi Bennour Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisSidiBennour', 'page.suivis');
    Route::view('/notificationsSidiBennour', 'page.notifications');
    Route::view('/prospectsSidiBennour', 'page.prospects');
    Route::view('/clientsSidiBennour', 'page.clients');
    Route::view('/entretiensSidiBennour', 'page.entretiens');
    Route::view('/reclamationsSidiBennour', 'page.reclamations');
    Route::view('/statistiquesSidiBennour', 'page.statistiques');
    Route::view('/exporterSidiBennour', 'page.exporter');
});

// Admin Dashboard
Route::get('/dashboardAdmin', function () {
    return view('Admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboards for managers
    Route::view('/managerSafi', 'page.dashboard')->name('page.dashboard');
    Route::view('/managerEssaouira', 'page.dashboard')->name('managerEssaouira.dashboard');
    Route::view('/managerSidiBennour', 'page.dashboard')->name('managerSidiBennour.dashboard');
    Route::view('/manager', 'page.dashboard')->name('manager.dashboard');
});

// Authentication Routes
require __DIR__.'/auth.php';
