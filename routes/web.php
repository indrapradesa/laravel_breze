<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sale\SalesController;
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
});

Route::prefix('sales')->name('sales.')->group(function() {

    Route::middleware(['guest:sales'])->group(function() {
        Route::view('/login', 'sales.login')->name('login');
        Route::post('/check', [SalesController::class, 'check'])->name('check');
    });

    Route::middleware(['auth:sales'])->group(function() {
        Route::view('/home', 'sales.home')->name('home');
        Route::post('/logout',[SalesController::class, 'logout'])->name('logout');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
