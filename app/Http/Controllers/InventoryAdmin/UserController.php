<?php

namespace App\Http\Controllers\InventoryAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('role', 'division')
                        ->whereNotIn('role_id', [1])
                        ->whereNotIn('id', [auth()->id()])
                        ->orderBy('name')
                        ->get();
        return view('inventory_admin.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::select('id', 'name')->get();
        $roles = Role::select('id', 'name')->whereNotIn('id', [1])->get();
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
        $divisions = Division::select('id', 'name')->get();
        $roles = Role::select('id', 'name')->whereNotIn('id', [1])->get();
        return view('inventory_admin.users.edit', compact('roles', 'divisions', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'photo' => 'nullable|image|max:2048', // 2MB
            'name' => 'required',
            'username' => ['required', 'min:5', 'unique:users,username,' . $user->id],
            'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'unique:users,phone,' . $user->id],
            'division_id' => 'required|exists:divisions,id',
            'password' => ['nullable', 'min:5'],
            'role_id' => 'required|exists:roles,id',
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/photos/user/' . $user->photo);
            }

            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedData['photo'] = basename($photoPath);
        } else {
            $validatedData['photo'] = $user->photo;
        }

        // Simpan data ke database
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->photo) {
            Storage::delete('public/photos/user/'. $user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil dihapus');
    }
}
