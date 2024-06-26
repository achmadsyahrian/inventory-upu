<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/', function () {
        if (Auth::user()->role_id == 1) {
          return app(\App\Http\Controllers\Administrator\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 2) {
          return app(\App\Http\Controllers\InventoryAdmin\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 3) {
          return app(\App\Http\Controllers\DivisionAdmin\DashboardController::class)->index();
        }
        else if (Auth::user()->role_id == 4) {
          return app(\App\Http\Controllers\ViceRector\DashboardController::class)->index();
        }
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::prefix('administrator')->middleware(['role:1'])->name('administrator.')->group(function () {
        Route::resource('/users', \App\Http\Controllers\Administrator\UserController::class)->names('users');
        Route::resource('/divisions', \App\Http\Controllers\Administrator\DivisionController::class)->names('divisions');
        Route::resource('/buildings', \App\Http\Controllers\Administrator\BuildingController::class)->names('buildings');
    }); 

    Route::prefix('inventory-admin')->middleware(['role:2'])->name('inventory_admin.')->group(function () {
        Route::resource('/users', \App\Http\Controllers\InventoryAdmin\UserController::class)->names('users');
        Route::resource('/divisions', \App\Http\Controllers\InventoryAdmin\DivisionController::class)->names('divisions');
    }); 

    Route::prefix('division-admin')->middleware(['role:3'])->group(function () {
        
    }); 

    Route::prefix('vice-rector2')->middleware(['role:4'])->group(function () {
        
    }); 
    
});

