<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Building::query();

        // Filter berdasarkan pencarian nama
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);
        return view('administrator.buildings.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|unique:buildings',
        ]);

        // Simpan data ke database
        Building::create($validatedData);

        return redirect()->route('administrator.buildings.index')->with('success', 'Lokasi baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building)
    {
        return view('administrator.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Building $building)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' =>'required|unique:divisions,name,'. $building->id,
        ]);

        // Simpan data ke database
        $building->update($validatedData);

        return redirect()->route('administrator.buildings.index')->with('success', 'Data lokasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('administrator.buildings.index')->with('success', 'Data lokasi berhasil dihapus');
    }
}
