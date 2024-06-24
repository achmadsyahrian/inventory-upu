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
    
    Route::prefix('administrator')->middleware(['role:1'])->group(function () {
        
    }); 

    Route::prefix('inventory_admin')->middleware(['role:2'])->group(function () {
        
    }); 

    Route::prefix('division_admin')->middleware(['role:3'])->group(function () {
        
    }); 

    Route::prefix('vice_rector2')->middleware(['role:4'])->group(function () {
        
    }); 
    
});

