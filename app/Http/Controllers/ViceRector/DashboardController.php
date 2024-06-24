<?php

namespace App\Http\Controllers\ViceRector;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('vice_rector2.dashboard');
    }
}
