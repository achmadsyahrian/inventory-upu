<?php

namespace App\Http\Controllers\DivisionAdmin;

use App\Http\Controllers\Controller;
use App\Models\DivisionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $divisionAuth = Auth::user()->division_id;
        
        // Permintaan Barang
        $itemRequestTotal = DivisionRequest::where('division_id', $divisionAuth)->count();
        $itemRequestPending = DivisionRequest::where('division_id', $divisionAuth)->where('status', 'pending')->count();
        $itemRequestComplete = DivisionRequest::where('division_id', $divisionAuth)->where('status', 'approved')->count();
        $itemRequestReject = DivisionRequest::where('division_id', $divisionAuth)->where('status', 'rejected')->count();
        
        
        return view('division_admin.dashboard', compact(
            'itemRequestTotal', 'itemRequestPending', 'itemRequestComplete', 'itemRequestReject',
        ));
    }
}
