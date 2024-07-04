<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\DivisionItem;
use Illuminate\Http\Request;

class DivisionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = DivisionItem::with('inventoryItem', 'division')->paginate(10);

        return view('inventory_admin.division_items.index', compact('data'));
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
    public function show(DivisionItem $divisionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionItem $divisionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionItem $divisionItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionItem $divisionItem)
    {
        //
    }
}
