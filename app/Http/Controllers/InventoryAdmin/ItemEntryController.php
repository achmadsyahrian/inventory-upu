<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\ItemEntry;
use App\Models\StockControl;
use Illuminate\Http\Request;

class ItemEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->searchData($request);
        $inventoryItems = InventoryItem::all();
        
        return view('inventory_admin.item_entries.index', compact('data', 'inventoryItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory_admin.item_entries.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'entry_date' => 'required|date',
            'supplier' => 'nullable',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|min:1',
        ]);

        // Hapus karakter titik dari price
        $validatedData['price'] = str_replace('.', '', $request->price);

        // Simpan data ke database
        $itemEntry = ItemEntry::create($validatedData);

        // Tambahkan stok inventory item
        $inventoryItem = InventoryItem::find($request->inventory_item_id);
        $inventoryItem->stock += $request->quantity;
        $inventoryItem->save();

        // Simpan entri ke stock_controls
        StockControl::create([
            'inventory_item_id' => $request->inventory_item_id,
            'description' => 'Pemasukan barang',
            'date' => \Carbon\Carbon::parse($request->entry_date)->format('Y-m-d'),
            'type' => 'entry',
            'in' => $request->quantity,
            'out' => NULL,
            'stock_after' => $inventoryItem->stock,
        ]);

        return redirect()->route('inventory_admin.itementries.index')->with('success', 'Stok barang berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(ItemEntry $itemEntry)
    {
        return redirect()->route('inventory_admin.itementries.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemEntry $itemEntry)
    {
        // Kembalikan ke index jika ada yg mencoba akses
        return redirect()->route('inventory_admin.itementries.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemEntry $itemEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemEntry $itemEntry)
    {
        // Simpan data sebelum dihapus untuk digunakan nanti
        $inventoryItemId = $itemEntry->inventory_item_id;
        $quantity = $itemEntry->quantity;

        // Hapus data entry
        $itemEntry->delete();

        // Kurangi stok inventory item
        $inventoryItem = InventoryItem::find($inventoryItemId);
        $inventoryItem->stock -= $quantity;
        $inventoryItem->save();

        // Tambahkan entri ke stock_controls
        StockControl::create([
            'inventory_item_id' => $inventoryItemId,
            'description' => 'Pemasukan barang dibatalkan',
            'date' => now()->format('Y-m-d'),
            'type' => 'entry',
            'in' => NULL,
            'out' => $quantity,
            'stock_after' => $inventoryItem->stock,
        ]);

        return redirect()->route('inventory_admin.itementries.index')->with('success', 'Stok barang berhasil dihapus');
    }


    // Ambil Inentory Item Sesuai Pilihan
    public function getInventoryItem($id)
    {
        $item = InventoryItem::with('condition', 'type', 'unit')->find($id);
        
        if ($item) {
            return response()->json([
                'brand' => $item->brand,
                'code' => $item->code,
                'warranty' => $item->warranty,
                'type' => $item->type->name,
                'unit' => $item->unit->name,
                'condition' => $item->condition->name,
                'stock' => $item->stock,
                'photo' => $item->photo,
                'description' => $item->description,
            ]);
        }

        return response()->json(['error' => 'Item not found'], 404);
    }

    private function searchData(Request $request)
    {
        $query = ItemEntry::with('inventoryItem');

        if ($request->filled('inventory_item_id')) {
            $query->where('inventory_item_id', $request->inventory_item_id);
        }
        if ($request->filled('entry_date')) {
            $query->where('entry_date', $request->entry_date);
        }
        if ($request->filled('supplier')) {
            $query->where('supplier', 'like', '%' . $request->supplier . '%');
        }
        if ($request->filled('quantity')) {
            $query->where('quantity', '<=', $request->quantity);
        }
        if ($request->filled('price')) {
            // Hapus karakter titik dari price
            $requestPrice = str_replace('.', '', $request->price);
            $query->where('price', '<=', $requestPrice);
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate(10)->appends($request->all());
    }
    
}
