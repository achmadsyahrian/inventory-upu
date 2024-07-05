<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\DivisionItem;
use App\Models\DivisionLoan;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class DivisionLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->searchData($request);
        $inventoryItems = InventoryItem::all();
        $divisions = Division::all();
        
        return view('inventory_admin.division_loans.index', compact('data', 'inventoryItems', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = [];
        $divisionOfItems = DivisionItem::with('division')
                            ->select('division_id')
                            ->groupBy('division_id')
                            ->get();

        $divisions = Division::all();

        return view('inventory_admin.division_loans.create', compact('inventoryItems', 'divisionOfItems', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'from_division_id' =>'required',
            'to_division_id' =>'required',
            'inventory_item_id' =>'required',
            'quantity' =>'required|numeric',
            'loan_date' =>'required|date',
            'due_date' =>'required|date',
            'reason' =>'nullable',
        ]);

        // Cek duplikasi
        $fromDivisionId = $validatedData['from_division_id'];
        $toDivisionId = $validatedData['to_division_id'];

        if ($fromDivisionId == $toDivisionId) {
            return redirect()->back()->with('error', 'Divisi yang meminjam dan dipinjam tidak boleh sama');
        }
        
        DivisionLoan::create($validatedData);

        return redirect()->route('inventory_admin.division_loans.index')->with('success', 'Peminjaman barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DivisionLoan $divisionLoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DivisionLoan $divisionLoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DivisionLoan $divisionLoan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DivisionLoan $divisionLoan)
    {
        //
    }

    private function searchData(Request $request)
    {
        $query = DivisionLoan::with('inventoryItem');

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

    public function getDivisionItems($divisionId)
    {
        $inventoryItems = DivisionItem::where('division_id', $divisionId)->with('inventoryItem')->get();
        return response()->json($inventoryItems);
    }

    public function getInventoryItem($itemId, $divisionId)
    {
        $item = InventoryItem::with('condition', 'type', 'unit')->find($itemId);
        $divisionItem = DivisionItem::where('division_id', $divisionId)->where('inventory_item_id', $itemId)->first();
        
        if ($item) {
            return response()->json([
                'brand' => $item->brand,
                'type' => $item->type->name,
                'unit' => $item->unit->name,
                'condition' => $item->condition->name,
                'photo' => $item->photo,
                'description' => $item->description,
                'quantity' => $divisionItem->quantity
            ]);
        }

        return response()->json(['error' => 'Item not found'], 404);
    }
    
}
