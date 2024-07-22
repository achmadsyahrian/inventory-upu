<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\ItemUnit;
use Illuminate\Http\Request;

class ItemUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ItemUnit::paginate(10);
        return view('inventory_admin.item_units.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory_admin.item_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' =>'required|unique:item_units',
            'symbol' => 'nullable'
        ]);

        // Simpan data
        ItemUnit::create($validatedData);

        // Redirect ke halaman index
        return redirect()->route('inventory_admin.itemunits.index')->with('success', 'Data Satuan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemUnit $itemUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemUnit $itemUnit)
    {
        return view('inventory_admin.item_units.edit', compact('itemUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemUnit $itemUnit)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' =>'required|unique:item_units,name,'. $itemUnit->id,
            'symbol' => 'nullable'
        ]);

        // Update data
        $itemUnit->update($validatedData);

        // Redirect ke halaman index
        return redirect()->route('inventory_admin.itemunits.index')->with('success', 'Data Satuan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemUnit $itemUnit)
    {
        // Hapus data
        $itemUnit->delete();

        // Redirect ke halaman index
        return redirect()->route('inventory_admin.itemunits.index')->with('success', 'Data Satuan berhasil dihapus');
    }
}
