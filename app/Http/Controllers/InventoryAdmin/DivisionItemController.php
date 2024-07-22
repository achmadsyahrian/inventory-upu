<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionItem;
use App\Models\InventoryItem;
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
        $divisionItem->save();

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

        // Update stok pada inventory item berdasarkan selisih
        if ($quantityDifference > 0) {
            // Jika quantity baru lebih besar, kurangi stok pada inventory item
            $inventoryItem->stock -= $quantityDifference;
        } else {
            // Jika quantity baru lebih kecil, tambah stok pada inventory item
            $inventoryItem->stock += abs($quantityDifference);
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
}
