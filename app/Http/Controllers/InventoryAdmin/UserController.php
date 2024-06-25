<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role', 'division')
                        ->whereNotIn('id', [1,2])
                        ->get();
        return view('inventory_admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::select('id', 'name')->get();
        $roles = Role::select('id', 'name')->get();
        return view('inventory_admin.users.create', compact('roles', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:2048', // 2MB
            'name' => 'required',
            'username' => 'required|min:5|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'unique:users,phone'],
            'division_id' => 'required|exists:divisions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedData['photo'] = basename($photoPath);
        } else {
            $validatedData['photo'] = null;
        }

        // Menambahkan password default
        $validatedData['password'] = bcrypt('potensiutama');
        
        // Simpan data ke database
        $user = User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan');
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
