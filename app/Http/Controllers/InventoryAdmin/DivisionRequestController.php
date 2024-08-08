<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionRequest;
use App\Models\InventoryItem;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        return view('inventory_admin.division_requests.index', compact('data', 'divisions'));
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

        return view('inventory_admin.division_requests.create', compact('inventoryItems', 'data'));
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
        
        return view('inventory_admin.division_requests.show', compact('data', 'date', 'divisionName'));
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

    public function print(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer',
        ]);
    
        $month = $request->month;
        $year = $request->year;
    
        // Query data berdasarkan bulan dan tahun pada kolom created_at
        $data = DivisionRequest::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->with('inventoryItem.unit')
                                ->get()
                                ->sortBy('inventoryItem.name');
    
        // Kelompokkan data berdasarkan nama barang
        $groupedData = $data->groupBy('inventoryItem.name')->map(function ($items) {
            $firstItem = $items->first();
            return [
                'name' => $firstItem->inventoryItem->name,
                'divisions' => $items->pluck('division.name')->unique()->implode(', '),
                'quantity' => $items->sum('quantity'),
                'unit' => $firstItem->inventoryItem->unit->name ?? '',
                'stock' => $firstItem->inventoryItem->stock,
                'brand' => $firstItem->inventoryItem->brand,
                'spesification' => $firstItem->inventoryItem->spesification,
            ];
        })->values();
    
        // Bagikan data menjadi potongan-potongan dengan ukuran 25
        $chunkedData = $groupedData->chunk(30);
    
        $time = Carbon::now();
    
        $html = view('inventory_admin.division_requests.print', [
            'chunkedData' => $chunkedData,
            'time' => $time,
            'month' => $month,
            'year' => $year,
            'pageCount' => $chunkedData->count(),
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();

        $pageCount = $dompdf->getCanvas()->get_page_count();

        session(['pageCount' => $pageCount]);

        $output = $dompdf->output();

        return response()->stream(
            function () use ($output) {
                print($output);
            },
            200,
            [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => "inline; filename=document.pdf",
            ]
        );
    }

}
