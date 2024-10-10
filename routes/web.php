<?php

use App\Http\Controllers\FellowController;
use App\Http\Controllers\MineInstanceController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\UserFellowController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){

    Route::get('/fillfellow', [FellowController::class, "names"]);
    // Route::get('/monsters', [MonsterController::class, "monsters"]);

    // Fellow routes
    Route::get('/my-fellows', [UserFellowController::class, "temp"])->name('my-fellows');
    Route::get('/add-fellow', [UserFellowController::class, "index"])->name('add-fellow');
    Route::post('/userfellow/create', [UserFellowController::class, "create"])->name('create-fellow');
    Route::post('/userfellow/edit', [UserFellowController::class, "edit"])->name('edit-fellow');

    Route::get('/mine-clearence', [MineInstanceController::class, "index"])->name('mine-clearence');
    Route::get('/active-mine-clearence', [MineInstanceController::class, "start"])->name('start-mine-clearence');
});

