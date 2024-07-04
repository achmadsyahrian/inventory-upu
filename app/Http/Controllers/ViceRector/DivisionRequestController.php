<?php

namespace App\Http\Controllers\ViceRector;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionItem;
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
        // Mengambil data dengan grouping berdasarkan division_id dan tanggal created_at
        $query = DivisionRequest::select(DB::raw('division_id, DATE(created_at) as date, COUNT(*) as count'))
            ->groupBy('division_id', DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc');

        // Jika ada pencarian berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Jika ada pencarian berdasarkan division_id
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        // Pagination dengan 10 data per halaman
        $data = $query->paginate(10);
        $divisions = Division::all();
        return view('vice_rector2.division_requests.index', compact('data', 'divisions'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($division, $date)
    {
        $data = DivisionRequest::with(['inventoryItem', 'division'])
                    ->where('division_id', $division)
                    ->whereDate('created_at', $date)
                    ->paginate(10);

        $divisionName = Division::findOrFail($division)->name;
        
        return view('vice_rector2.division_requests.show', compact('data', 'date', 'divisionName'));
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

    // Approve
    public function approve(DivisionRequest $id)
    {
        $itemRequest = $id;

        // Cek ketersediaan stok
        $inventoryItem = InventoryItem::find($itemRequest->inventory_item_id);
        if ($inventoryItem->stock < $itemRequest->quantity) {
            return redirect()->back()->with('error', 'Stok barang tidak cukup');
        }

        // Kurangi stok
        $inventoryItem->stock -= $itemRequest->quantity;
        $inventoryItem->save();

        // Tambahkan entry barang
        $itemEntry = DivisionItem::updateOrCreate(
            [
                'division_id' => $itemRequest->division_id,
                'inventory_item_id' => $itemRequest->inventory_item_id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $itemRequest->quantity),
                'updated_at' => Carbon::now(),
            ]
        );

        // Update status permintaan
        $itemRequest->status = 'approved';
        $itemRequest->save();

        return redirect()->back()->with('success', 'Permintaan barang berhasil disetujui');
    }

    // Reject
    public function reject(DivisionRequest $id)
    {
        $itemRequest = $id;
        $itemRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan barang berhasil ditolak');
    }

}
