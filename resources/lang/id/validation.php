<?php

return [
    'required' => 'Kolom :attribute harus diisi.',
    'attributes' => [
        'name' => 'nama',
        'phone' => 'nomor handphone',
        'photo' => 'foto',
        'role_id' => 'level',
        'division_id' => 'divisi',
        'building_id' => 'lokasi',
        'condition_id' => 'kondisi',
        'division_head' => 'kepala bagian',
        'dimensions' => 'luas',
        'description' => 'keterangan',
        'type_id' => 'tipe',
        'unit_id' => 'satuan',
        'stock' => 'stok',
        'merek' => 'brand',
        'inventory_item_id' => 'barang',
        'quantity' => 'jumlah',
        'price' => 'harga',
    ],
    'regex' => 'Kolom :attribute harus memenuhi format yang benar.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
        'integer' => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
    ],
    'same' => 'Kolom :attribute harus sama dengan :other.',
    'max' => [
        'file' => 'Ukuran file :attribute tidak boleh melebihi :max kilobyte.', 
        'string' => 'Panjang karakter :attribute tidak boleh melebihi :max karakter.', 
    ],
    'unique' => 'Data :attribute sudah terdaftar dalam sistem.',
    'image' => 'Kolom :attribute harus berupa file gambar.',
    'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
    'integer' => 'Kolom :attribute hanya boleh berisi angka.',
    'uploaded' => 'Ukuran file yang diunggah pada kolom :attribute terlalu besar. Maksimum 2MB.',
    'custom' => [
        'photo' => [
            'mimes' => 'Kolom :attribute harus berupa file dengan tipe: jpeg, png, jpg.',
        ],
    ],
];
