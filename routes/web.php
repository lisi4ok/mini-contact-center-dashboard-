<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\InteractionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

//Route::get('/', HomeController::class)->name('home');
Route::get('/', function () {
    return redirect('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    //Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('dashboard', function () {
        return redirect('contacts');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::resource('interactions', InteractionController::class);
});

require __DIR__.'/settings.php';
