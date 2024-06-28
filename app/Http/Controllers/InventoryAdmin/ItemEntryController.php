<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\ItemEntry;
use Illuminate\Http\Request;

class ItemEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ItemEntry::with('inventoryItem')->paginate(10);
        return view('inventory_admin.item_entries.index', compact('data'));
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
            'inventory_item_id' =>'required',
            'entry_date' =>'required|date',
            'supplier' =>'nullable',
            'quantity' =>'required|numeric|min:1',
            'price' =>'required|min:1',
        ]);

        // Hapus karakter titik dari price
        $validatedData['price'] = str_replace('.', '', $request->price);

        // Simpan data ke database
        $itemEntry = ItemEntry::create($validatedData);

        // Tambahkan stok inventory item
        $inventoryItem = InventoryItem::find($request->inventory_item_id);
        $inventoryItem->stock += $request->quantity;
        $inventoryItem->save();

        return redirect()->route('inventory_admin.itementries.index')->with('success', 'Stok barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemEntry $itemEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemEntry $itemEntry)
    {
        //
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
        //
    }

    // Ambil Inentory Item Sesuai Pilihan
    public function getInventoryItem($id)
    {
        $item = InventoryItem::with('condition', 'type', 'unit')->find($id);

        if ($item) {
            return response()->json([
                'brand' => $item->brand,
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

}
