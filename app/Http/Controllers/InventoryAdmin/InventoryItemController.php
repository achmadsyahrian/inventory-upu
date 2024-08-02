<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\DivisionItem;
use App\Models\InventoryItem;
use App\Models\ItemCondition;
use App\Models\ItemType;
use App\Models\ItemUnit;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->searchData($request);
        $conditions = ItemCondition::select('id', 'name')->get();
        $types = ItemType::select('id', 'name')->get();
        $units = ItemUnit::select('id', 'name', 'symbol')->get();

        return view('inventory_admin.inventory_items.index', compact('data', 'conditions', 'types', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $conditions = ItemCondition::select('id', 'name')->get();
        $types = ItemType::select('id', 'name')->get();
        $units = ItemUnit::select('id', 'name', 'symbol')->get();
        $capacities = ['0.5', '0.75', '1', '1.5', '2', '2.5', '3'];

        return view('inventory_admin.inventory_items.create', compact('conditions', 'types', 'units', 'capacities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Validasi input
        $validatedData = $request->validate([
            'code' =>'nullable|unique:inventory_items',
            'name' =>'required|unique:inventory_items',
            'brand' =>'nullable',
            'spesification' =>'nullable',
            'description' => 'nullable',
            'warranty' => 'nullable',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'condition_id' =>'required|exists:item_conditions,id',
            'type_id' =>'required|exists:item_types,id',
            'unit_id' =>'required|exists:item_units,id',
            'capacity_pk' => 'nullable|in:0.5,0.75,1,1.5,2,2.5,3',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos/inventory_item');
            $validatedData['photo'] = basename($photoPath);
        } else {
            $validatedData['photo'] = null;
        }
        
        // Simpan data ke database
        InventoryItem::create($validatedData);

        return redirect()->route('inventory_admin.inventoryitems.index')->with('success', 'Barang baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        $conditions = ItemCondition::select('id', 'name')->get();
        $types = ItemType::select('id', 'name')->get();
        $units = ItemUnit::select('id', 'name', 'symbol')->get();
        $capacities = ['0.5', '0.75', '1', '1.5', '2', '2.5', '3'];

        return view('inventory_admin.inventory_items.edit', compact('conditions', 'types', 'units', 'inventoryItem', 'capacities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        // Validasi input
        $validatedData = $request->validate([
            'code' =>'nullable|unique:inventory_items,code,'. $inventoryItem->id,
            'name' =>'required|unique:inventory_items,name,'. $inventoryItem->id,
            'brand' =>'nullable',
            'spesification' =>'nullable',
            'description' => 'nullable',
            'warranty' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'condition_id' =>'required|exists:item_conditions,id',
            'stock' => 'required|integer|min:0',
            'type_id' =>'required|exists:item_types,id',
            'unit_id' =>'required|exists:item_units,id',
            'capacity_pk' => 'nullable|in:0.5,0.75,1,1.5,2,2.5,3',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            if ($inventoryItem->photo) {
                Storage::delete('public/photos/inventory_item/'. $inventoryItem->photo);
            }
            $photoPath = $request->file('photo')->store('public/photos/inventory_item');
            $validatedData['photo'] = basename($photoPath);
        }

        // Simpan data ke database
        $inventoryItem->update($validatedData);

        return redirect()->route('inventory_admin.inventoryitems.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        if ($inventoryItem->photo) {
            Storage::delete('public/photos/inventory_item/'. $inventoryItem->photo);
        }
        $inventoryItem->delete();
        return redirect()->route('inventory_admin.inventoryitems.index')->with('success', 'Data Barang berhasil dihapus');
    }

    private function searchData(Request $request)
    {
        $query = InventoryItem::with('condition', 'type', 'unit');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }
        if ($request->filled('condition_id')) {
            $query->where('condition_id', $request->condition_id);
        }
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }
        if ($request->filled('stock')) {
            $query->where('stock', '<=', $request->stock);
        }

        $query->orderByRaw('CASE WHEN stock = 0 THEN 0 ELSE 1 END')
            ->orderBy('condition_id', 'desc')
            ->orderBy('name');

        return $query->paginate(10)->appends($request->all());
    }


    public function print()
    {
        $inventoryItems = InventoryItem::orderBy('name', 'asc')->get();
        $divisionItems = DivisionItem::with(['inventoryItem', 'division'])->get();

        // Gabungkan data dari InventoryItem dan DivisionItem
        $combinedData = new Collection();

        foreach ($inventoryItems as $item) {
            $combinedData->push((object) [
                'date' => $item->created_at,
                'name' => $item->name,
                'brand' => $item->brand,
                'spesification' => $item->spesification,
                'stock' => $item->stock,
                'code' => $item->code,
                'price' => $item->itemEntries->sum('price'),
                'supplier_name' => $item->itemEntries->pluck('supplier')->unique()->implode(', ') ?: '-',
                'capacity_pk' => $item->capacity_pk,
                'condition_id' => $item->condition_id,
                'location' => '-',
                'description' => $item->description,
            ]);
        }

        foreach ($divisionItems as $item) {
            $inventoryItem = $item->inventoryItem;
            $combinedData->push((object) [
                'date' => $item->created_at,
                'name' => $inventoryItem->name,
                'brand' => $inventoryItem->brand,
                'spesification' => $inventoryItem->spesification,
                'stock' => $item->quantity,
                'code' => $inventoryItem->code,
                'price' => $inventoryItem->itemEntries->sum('price'),
                'supplier_name' => $inventoryItem->itemEntries->pluck('supplier')->unique()->implode(', ') ?: '-',
                'capacity_pk' => $inventoryItem->capacity_pk,
                'condition_id' => $item->condition_id,
                'location' => $item->division->name,
                'description' => $item->description,
            ]);
        }

        // Urutkan data gabungan berdasarkan nama barang
        $combinedData = $combinedData->sortBy('name');

        // Ambil data untuk halaman pertama (15 item)
        $firstPageData = $combinedData->splice(0, 15);

        // Ambil data untuk halaman berikutnya (20 item per halaman)
        $remainingData = $combinedData->chunk(20);

        // Gabungkan kembali halaman pertama dengan halaman-halaman berikutnya
        $chunkedData = collect([$firstPageData])->merge($remainingData);

        $time = Carbon::now();

        $html = view('inventory_admin.inventory_items.print', [
            'chunkedData' => $chunkedData,
            'time' => $time,
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
