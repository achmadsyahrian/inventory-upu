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
        // Mendapatkan division_id dari pengguna yang sedang login
        $divisionId = Auth::user()->division_id;

        // Mengambil data dengan grouping berdasarkan tanggal created_at
        $query = DivisionRequest::select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
            ->where('division_id', $divisionId)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc');

        // Jika ada pencarian berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Pagination dengan 10 data per halaman
        $data = $query->paginate(10);

        return view('division_admin.division_requests.index', compact('data'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();

        // Mendapatkan division_id dari user yang sedang login
        $divisionId = Auth::user()->division_id;

        // Mengambil data DivisionRequest hanya untuk division_id yang sedang login dan hari ini
        $data = DivisionRequest::with(['inventoryItem', 'division'])
                    ->where('division_id', $divisionId)
                    ->whereDate('created_at', Carbon::today())
                    ->get();

        return view('division_admin.division_requests.create', compact('inventoryItems', 'data'));
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

        return redirect()->route('division_admin.divisionrequests.create')
            ->with('success', 'Permintaan barang berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show($date)
    {
        $divisionId = Auth::user()->division_id;

        $data = DivisionRequest::with(['inventoryItem', 'division'])
                    ->where('division_id', $divisionId)
                    ->whereDate('created_at', $date)
                    ->paginate(10);

        return view('division_admin.division_requests.show', compact('data', 'date'));
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
    public function destroy(DivisionRequest $itemRequest)
    {
        $itemRequest->delete();

        return redirect()->route('division_admin.divisionrequests.create')
            ->with('success', 'Permintaan barang berhasil dihapus');
    }

}
