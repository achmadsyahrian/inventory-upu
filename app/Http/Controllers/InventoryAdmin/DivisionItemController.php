<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionItem;
use App\Models\InventoryItem;
use App\Models\StockControl;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class DivisionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DivisionItem::with('inventoryItem', 'division');

        // Tambahkan filter pencarian berdasarkan inventory_item_id dan division_id
        if ($request->has('inventory_item_id') && $request->inventory_item_id != '') {
            $query->where('inventory_item_id', $request->inventory_item_id);
        }

        if ($request->has('division_id') && $request->division_id != '') {
            $query->where('division_id', $request->division_id);
        }

        // Dapatkan hasil dengan paginasi
        $data = $query->paginate(10);

        // Dapatkan semua divisions dan inventoryItems untuk dropdown
        $divisions = Division::all();
        $inventoryItems = InventoryItem::all();
        
        // Append parameter pencarian ke pagination
        $data->appends($request->all());

        return view('inventory_admin.division_items.index', compact('data', 'divisions', 'inventoryItems'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();
        $divisions = Division::all();
        return view('inventory_admin.division_items.create', compact('inventoryItems', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'inventory_item_id' =>'required',
            'division_id' =>'required',
            'quantity' =>'required|numeric|min:1',
        ]);

        // Ambil data InventoryItem
        $inventoryItem = InventoryItem::find($validatedData['inventory_item_id']);

        // Cek apakah quantity yang diminta lebih besar dari stock yang tersedia
        if ($validatedData['quantity'] > $inventoryItem->stock) {
            return redirect()->back()->with('error', 'Jumlah yang diminta lebih besar dari stock yang tersedia');
        }

        // Kurangkan stock dari inventory item
        $inventoryItem->stock -= $validatedData['quantity'];
        $inventoryItem->save();

        // Jika data telah ada maka cukup tambahkan quantitynya
        $divisionItem = DivisionItem::firstOrNew([
            'inventory_item_id' => $validatedData['inventory_item_id'],
            'division_id' => $validatedData['division_id'],
        ]);

        $divisionItem->quantity += $validatedData['quantity'];
        $divisionItem->condition_id = $inventoryItem->condition_id;
        $divisionItem->save();

        // Ambil nama divisi
        $divisionName = Division::find($validatedData['division_id'])->name;

        // Tambahkan entri ke stock_controls
        StockControl::create([
            'inventory_item_id' => $validatedData['inventory_item_id'],
            'description' => "Barang telah didistribusikan kepada " . $divisionName,
            'date' => now()->format('Y-m-d'),
            'type' => 'distribution',
            'in' => NULL,
            'out' => $validatedData['quantity'],
            'stock_after' => $inventoryItem->stock,
        ]);

        return redirect()->route('inventory_admin.divisionitems.index')->with('success', 'Data Barang berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(DivisionItem $divisionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionItem $divisionItem)
    {
        return view('inventory_admin.division_items.edit', compact('divisionItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionItem $divisionItem)
    {
        // Validasi input
        $validatedData = $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        // Ambil inventory item yang terkait
        $inventoryItem = InventoryItem::find($divisionItem->inventory_item_id);

        // Hitung selisih quantity
        $quantityDifference = $validatedData['quantity'] - $divisionItem->quantity;

        // Cek apakah stok mencukupi jika quantity baru lebih besar
        if ($quantityDifference > 0 && $quantityDifference > $inventoryItem->stock) {
            return redirect()->back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk menambah jumlah sebesar itu.']);
        }

        // Update quantity pada division item
        $divisionItem->quantity = $validatedData['quantity'];
        $divisionItem->save();

        // Ambil nama divisi
        $divisionName = Division::find($divisionItem->division_id)->name;

        // Update stok pada inventory item berdasarkan selisih dan tambahkan log ke stock control
        if ($quantityDifference > 0) {
            // Jika quantity baru lebih besar, kurangi stok pada inventory item
            $inventoryItem->stock -= $quantityDifference;

            // Tambahkan log ke stock control
            StockControl::create([
                'inventory_item_id' => $divisionItem->inventory_item_id,
                'description' => "Barang telah didistribusikan kepada " . $divisionName,
                'date' => now()->format('Y-m-d'),
                'type' => 'distribution',
                'in' => null,
                'out' => $quantityDifference,
                'stock_after' => $inventoryItem->stock,
            ]);
        } else {
            // Jika quantity baru lebih kecil, tambah stok pada inventory item
            $inventoryItem->stock += abs($quantityDifference);

            // Tambahkan log ke stock control
            StockControl::create([
                'inventory_item_id' => $divisionItem->inventory_item_id,
                'description' => "Barang telah dikembalikan ke inventori oleh " . $divisionName,
                'date' => now()->format('Y-m-d'),
                'type' => 'entry',
                'in' => abs($quantityDifference),
                'out' => null,
                'stock_after' => $inventoryItem->stock,
            ]);
        }

        $inventoryItem->save();

        return redirect()->route('inventory_admin.divisionitems.index')->with('success', 'Data Barang berhasil diperbarui');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionItem $divisionItem)
    {
        //
    }

    public function print(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'type_id' => 'required|in:1,2,3'
        ]);
        
        $division = Division::findOrFail($request->division_id);
        $typeId = $request->type_id;

        // Query data berdasarkan type_id
        $data = DivisionItem::where('division_id', $request->division_id)
                            ->with(['inventoryItem' => function($query) use ($typeId) {
                                if (in_array($typeId, [1, 2])) {
                                    $query->where('type_id', $typeId);
                                }
                            }])
                            ->get()
                            ->filter(function($item) use ($typeId) {
                                // Filter out items that do not have an inventory item when type_id is 1 or 2
                                return !in_array($typeId, [1, 2]) || $item->inventoryItem;
                            })
                            ->sortBy('inventoryItem.name');

        // Hitung jumlah total data
        $totalCount = $data->count();

        // Tentukan jumlah item pada halaman pertama
        $firstPageCount = ($totalCount > 15) ? 15 : ($totalCount >= 10 ? 10 : $totalCount);

        // Ambil data untuk halaman pertama
        $firstPageData = $data->splice(0, $firstPageCount);

        // Ambil data untuk halaman-halaman berikutnya (20 item per halaman)
        $remainingData = $data->chunk(20);

        // Gabungkan halaman pertama dengan halaman-halaman berikutnya
        $chunkedData = collect([$firstPageData])->merge($remainingData);

        $time = Carbon::now();

        // Tentukan tampilan yang akan digunakan berdasarkan type_id
        $view = ($typeId == 3) ? 'inventory_admin.division_items.report.print' : 'inventory_admin.division_items.report.print_type';

        // Tentukan string berdasarkan type_id
        $typeName = ($typeId == 1) ? 'HABIS PAKAI' : (($typeId == 2) ? 'ASSET' : '');
        
        $html = view($view, [
            'chunkedData' => $chunkedData,
            'time' => $time,
            'division' => $division,
            'typeName' => $typeName,
            'pageCount' => $chunkedData->count(),
        ])->render();


        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
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
