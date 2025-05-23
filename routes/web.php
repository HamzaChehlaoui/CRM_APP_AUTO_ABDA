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
    Route::view('/suivisDirector', 'AssistantDirector.suivis');
    Route::view('/notificationsDirector', 'AssistantDirector.notifications');
    Route::view('/prospectsDirector', 'AssistantDirector.prospects');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::view('/clientsDirector', 'AssistantDirector.clients');
    Route::view('/entretiensDirector', 'AssistantDirector.entretiens');
    Route::view('/reclamationsDirector', 'AssistantDirector.reclamations');
    Route::view('/statistiquesDirector', 'AssistantDirector.statistiques');
    Route::view('/exporterDirector', 'AssistantDirector.exporter');
});

// Safi Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisSafi', 'SafiManager.suivis');
    Route::view('/notificationsSafi', 'SafiManager.notifications');
    Route::view('/prospectsSafi', 'SafiManager.prospects');
    Route::view('/clientsSafi', 'SafiManager.clients');
    Route::view('/entretiensSafi', 'SafiManager.entretiens');
    Route::view('/reclamationsSafi', 'SafiManager.reclamations');
    Route::view('/statistiquesSafi', 'SafiManager.statistiques');
    Route::view('/exporterSafi', 'SafiManager.exporter');
});

// Essaouira Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisEssaouira', 'EssaouiraManager.suivis');
    Route::view('/notificationsEssaouira', 'EssaouiraManager.notifications');
    Route::view('/prospectsEssaouira', 'EssaouiraManager.prospects');
    Route::view('/clientsEssaouira', 'EssaouiraManager.clients');
    Route::view('/entretiensEssaouira', 'EssaouiraManager.entretiens');
    Route::view('/reclamationsEssaouira', 'EssaouiraManager.reclamations');
    Route::view('/statistiquesEssaouira', 'EssaouiraManager.statistiques');
    Route::view('/exporterEssaouira', 'EssaouiraManager.exporter');
});

// Sidi Bennour Manager Static Pages
Route::prefix('')->group(function () {
    Route::view('/suivisSidiBennour', 'SidiBennourManager.suivis');
    Route::view('/notificationsSidiBennour', 'SidiBennourManager.notifications');
    Route::view('/prospectsSidiBennour', 'SidiBennourManager.prospects');
    Route::view('/clientsSidiBennour', 'SidiBennourManager.clients');
    Route::view('/entretiensSidiBennour', 'SidiBennourManager.entretiens');
    Route::view('/reclamationsSidiBennour', 'SidiBennourManager.reclamations');
    Route::view('/statistiquesSidiBennour', 'SidiBennourManager.statistiques');
    Route::view('/exporterSidiBennour', 'SidiBennourManager.exporter');
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
    Route::view('/managerSafi', 'SafiManager.dashboard')->name('managerSafi.dashboard');
    Route::view('/managerEssaouira', 'EssaouiraManager.dashboard')->name('managerEssaouira.dashboard');
    Route::view('/managerSidiBennour', 'SidiBennourManager.dashboard')->name('managerSidiBennour.dashboard');
    Route::view('/manager', 'AssistantDirector.dashboard')->name('manager.dashboard');
});

// Authentication Routes
require __DIR__.'/auth.php';
