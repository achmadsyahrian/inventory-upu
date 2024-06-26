<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Division;
use App\Models\DivisionCondition;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->searchDivisions($request);
        $conditions = DivisionCondition::select('id', 'name')->get();
        $buildings = Building::select('id', 'name')->get();
        return view('inventory_admin.divisions.index', compact('data', 'conditions', 'buildings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $conditions = DivisionCondition::select('id', 'name')->get();
        $buildings = Building::select('id', 'name')->get();
        return view('inventory_admin.divisions.create', compact('conditions', 'buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|unique:divisions',
            'division_head' => 'nullable|min:5',
            'dimensions' => ['nullable', 'regex:/^[\d,]+$/', 'max:255'],
            'building_id' => 'required|exists:buildings,id',
            'condition_id' => 'required|exists:division_conditions,id',
            'description' => 'nullable',
        ]);

        // Simpan data ke database
        Division::create($validatedData);

        return redirect()->route('inventory_admin.divisions.index')->with('success', 'Divisi baru berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Division $division)
    {
        $conditions = DivisionCondition::select('id', 'name')->get();
        $buildings = Building::select('id', 'name')->get();
        return view('inventory_admin.divisions.edit', compact('division', 'buildings', 'conditions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' =>'required|unique:divisions,name,'. $division->id,
            'division_head' => 'nullable|min:5',
            'dimensions' => ['nullable','regex:/^[\d,]+$/', 'max:255'],
            'building_id' =>'required|exists:buildings,id',
            'condition_id' =>'required|exists:division_conditions,id',
            'description' => 'nullable',
        ]);

        // Simpan data ke database
        $division->update($validatedData);

        return redirect()->route('inventory_admin.divisions.index')->with('success', 'Data divisi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('inventory_admin.divisions.index')->with('success', 'Data divisi berhasil dihapus');
    }

    private function searchDivisions(Request $request)
    {
        $query = Division::with('condition', 'building');

        if ($request->filled('name')) { $query->where('name', 'like', '%' . $request->name . '%'); }
        if ($request->filled('division_head')) { $query->where('division_head', 'like', '%' . $request->division_head . '%'); }
        if ($request->filled('dimensions')) { $query->where('dimensions', 'like', '%' . $request->dimensions . '%'); }
        if ($request->filled('building_id')) { $query->where('building_id', $request->building_id); }
        if ($request->filled('condition_id')) { $query->where('condition_id', $request->condition_id); }

        return $query->orderBy('name')->paginate(10)->appends($request->all());
    }
}
