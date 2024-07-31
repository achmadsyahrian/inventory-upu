<?php

namespace App\Http\Controllers\DivisionAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionItem;
use App\Models\InventoryItem;
use App\Models\ItemCondition;
use Illuminate\Http\Request;

class DivisionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DivisionItem::with('inventoryItem', 'division')->where('division_id', auth()->user()->division_id)->paginate(10);

        // Dapatkan semua divisions dan inventoryItems untuk dropdown
        $divisions = Division::all();
        $inventoryItems = InventoryItem::all();

        return view('division_admin.division_items.index', compact('data', 'divisions', 'inventoryItems'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::all();
        $divisions = Division::all();
        
        return view('division_admin.division_items.create', compact('inventoryItems', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'inventory_item_id' =>'required',
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
            'division_id' => auth()->user()->division_id,
        ]);

        $divisionItem->quantity += $validatedData['quantity'];
        $divisionItem->condition_id = $inventoryItem->condition_id;
        $divisionItem->description = NULL;
        $divisionItem->save();

        return redirect()->route('division_admin.divisionitems.index')->with('success', 'Data Barang berhasil ditambahkan');
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
        $conditions = ItemCondition::all();
        return view('division_admin.division_items.edit', compact('divisionItem', 'conditions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionItem $divisionItem)
    {
        // Validasi input
        $validatedData = $request->validate([
            'quantity' => ['required', 'numeric', 'min:1', function ($attribute, $value, $fail) use ($divisionItem) {
                if ($value > $divisionItem->quantity) {
                    $fail('Jumlah tidak bisa ditambah. Harap melakukan permintaan barang');
                }
            }],
            'description' => 'nullable',
            'condition_id' => 'required'
        ]);

        // Update quantity dan data lainnya
        $divisionItem->quantity = $validatedData['quantity'];
        $divisionItem->description = $validatedData['description'];
        $divisionItem->condition_id = $validatedData['condition_id'];
        $divisionItem->save();

        return redirect()->route('division_admin.divisionitems.index')->with('success', 'Data Barang berhasil diperbarui');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionItem $divisionItem)
    {
        //
    }
}
