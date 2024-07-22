<?php

namespace App\Http\Controllers\ViceRector;

use App\Http\Controllers\Controller;
use App\Models\DivisionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $divisionAuth = Auth::user()->division_id;
        
        // Permintaan Barang
        $itemRequestTotal = DivisionRequest::count();
        $itemRequestPending = DivisionRequest::where('status', 'pending')->count();
        $itemRequestComplete = DivisionRequest::where('status', 'approved')->count();
        $itemRequestReject = DivisionRequest::where('status', 'rejected')->count();
        
        $query = DivisionRequest::select(DB::raw('division_id, DATE(created_at) as date, COUNT(*) as count'))
            ->groupBy('division_id', DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc');


        // Pagination dengan 10 data per halaman
        $data = $query->paginate(10);

        return view('vice_rector2.dashboard', compact(
            'itemRequestTotal', 'itemRequestPending', 'itemRequestComplete', 'itemRequestReject',
            'data'
        ));
    }
}
