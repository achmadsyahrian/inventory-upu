<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inventory_admin.dashboard');
});
