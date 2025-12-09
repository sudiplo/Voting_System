<?php

use App\Http\Controllers\AddController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\viewController;
use Illuminate\Support\Facades\Route;
use App\Models\palika;


Route::get('/', [viewController::class,'welcome'])->name('welcome');

// only registered user can route this route's
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //
    Route::get('/about',[viewController::class,'about'])->name('about');
    Route::get('/dashboard', [viewController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::post("/distric",[AddController::class,'distric'])->name('distric');
    Route::post("/palika",[AddController::class,"palika"])->name('palika');
});

require __DIR__.'/auth.php';
