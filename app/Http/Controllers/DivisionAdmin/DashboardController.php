<?php

namespace App\Http\Controllers\DivisionAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('division_admin.dashboard');
    }
}
