<?php

namespace App\Http\Controllers\DivisionAdmin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\ItemCondition;
use App\Models\ItemType;
use App\Models\ItemUnit;
use Illuminate\Http\Request;
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

        return view('division_admin.inventory_items.index', compact('data', 'conditions', 'types', 'units'));
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
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        // Validasi input
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        //
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
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        $query->orderByRaw('CASE WHEN stock = 0 THEN 0 ELSE 1 END')
            ->orderBy('condition_id', 'desc')
            ->orderBy('name');

        return $query->paginate(10)->appends($request->all());
    }



    
}
