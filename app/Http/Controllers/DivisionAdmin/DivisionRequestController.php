<?php

namespace App\Http\Controllers\DivisionAdmin;

use App\Http\Controllers\Controller;
use App\Models\DivisionRequest;
use App\Models\InventoryItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DivisionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DivisionRequest::select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('division_admin.division_requests.index', compact('data'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();
        return view('division_admin.division_requests.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'inventory_item_id' =>'required',
            'requester_name' =>'required',
            'quantity' =>'required|numeric|min:1',
        ]);

        // Ambil divisi dari user login
        $validatedData['division_id'] = Auth::user()->division_id;
        
        // Buat status pending
        $validatedData['status'] = 'pending';
        
        // Simpan data ke database
        DivisionRequest::create($validatedData);

        return redirect()->route('division_admin.divisionrequests.index')
            ->with('success', 'Permintaan barang berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(DivisionRequest $divisionRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionRequest $divisionRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionRequest $divisionRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionRequest $divisionRequest)
    {
        //
    }
}
