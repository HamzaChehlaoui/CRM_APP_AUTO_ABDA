<?php

use App\Http\Controllers\ProfileController;
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

//static pages admin

Route::get('/', function () {
    return view('welcome');
});
Route::get('/suivisAdmin', function(){
        return view('Admin.suivis');
});

Route::get('/notificationsAdmin', function(){
        return view('Admin.notifications');
});
Route::get('/prospectsAdmin', function(){
        return view('Admin.prospects');
});
Route::get('/clientsAdmin', function(){
        return view('Admin.clients');
});
Route::get('/entretiensAdmin', function(){
        return view('Admin.entretiens');
});
Route::get('/reclamationsAdmin', function(){
        return view('Admin.reclamations');
});
Route::get('/statistiquesAdmin', function(){
        return view('Admin.statistiques');
});
Route::get('/exporterAdmin', function(){
        return view('Admin.exporter');
});

//static page AssistantDirector
Route::get('/suivisDirector', function(){
        return view('AssistantDirector.suivis');
});

Route::get('/notificationsDirector', function(){
        return view('AssistantDirector.notifications');
});
Route::get('/prospectsDirector', function(){
        return view('AssistantDirector.prospects');
});
Route::get('/clientsDirector', function(){
        return view('AssistantDirector.clients');
});
Route::get('/entretiensDirector', function(){
        return view('AssistantDirector.entretiens');
});
Route::get('/reclamationsDirector', function(){
        return view('AssistantDirector.reclamations');
});
Route::get('/statistiquesDirector', function(){
        return view('AssistantDirector.statistiques');
});
Route::get('/exporterDirector', function(){
        return view('AssistantDirector.exporter');
});


Route::get('/dashboardAdmin', function () {
    return view('Admin.dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/managerSafi',function (){
        return view('SafiManager.dashboard');
    })->name('managerSafi.dashboard');

    Route::get('/managerEssaouira',function (){
        return view('EssaouiraManager.dashboard');
    })->name('managerEssaouira.dashboard');

    Route::get('/managerSidiBennour',function (){
        return view('SidiBennourManager.dashboard');
    })->name('managerSidiBennour.dashboard');

    Route::get('/manager',function (){
        return view('AssistantDirector.dashboard');
    })->name('manager.dashboard');
});

require __DIR__.'/auth.php';
