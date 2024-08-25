<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AddDataController;
use App\Http\Controllers\Auth\LoginedController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

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
Route::get('/addData/{title}', [LoginedController::class, 'index'])
                ->name('main.index');
                
Route::get('/', function () {
    return view('auth/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/addData/{title}', [LoginedController::class, 'index'])
                ->name('main.index');
                
    Route::patch('/addDataUpdate/{title}', [AddDataController::class, 'update'])
                ->name('addData.update');
});

require __DIR__.'/auth.php';
