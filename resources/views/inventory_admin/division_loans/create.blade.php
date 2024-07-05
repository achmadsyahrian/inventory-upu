@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.divisionloans.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah Peminjaman</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.divisionloans.index') }}">Peminjaman Barang</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Peminjaman Barang</h2>
      <p class="section-lead">
         Harap lengkapi informasi untuk menambahkan data peminjaman barang antar divisi.
         Untuk mengecek ketersediaan barang pada divisi kunjungi halaman <a href="{{ route('inventory_admin.divisionitems.index') }}">barang divisi</a>
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
               <form action="{{ route('inventory_admin.divisionloans.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Informasi Peminjaman</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-12 col-12">
                           <div class="row">
                              <div class="form-group col-md-12 col-12">
                                 <label>Divisi Penyedia <x-label-required></x-label-required></label>
                                 <select class="form-control select2" name="from_division_id" id="division-item-select">
                                     <option selected disabled>Pilih Divisi</option>
                                     @foreach ($divisionOfItems as $item)
                                     <option value="{{ $item->division->id }}" {{ old('from_division_id') == $item->division->id ? 'selected' : '' }}>{{ $item->division->name }}</option>
                                     @endforeach
                                 </select>
                                 @error('from_division_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                             </div>
                              <div class="form-group col-md-12 col-12">
                                 <label>Divisi Peminjam <x-label-required></x-label-required></label>
                                 <select class="form-control select2" name="to_division_id">
                                    <option selected disabled>Pilih Divisi</option>
                                    @foreach ($divisions as $item)
                                    <option value="{{ $item->id }}" {{ old('to_division_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                 </select>
                                 @error('to_division_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Barang Pinjaman<x-label-required></x-label-required></label>
                                 <select class="form-control select2" name="inventory_item_id" id="inventory-item-select2">
                                    <option selected disabled>Pilih Barang</option>
                                    @foreach ($inventoryItems as $item)
                                    <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>{{ $item->inventoryItem->name }}</option>
                                    @endforeach
                                 </select>
                                 @error('inventory_item_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Jumlah <x-label-required></x-label-required></label>
                                 <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" placeholder="Masukkan Jumlah" autocomplete="off">
                                 <x-invalid-feedback field='quantity'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Tanggal Pinjam <x-label-required></x-label-required></label>
                                 <input type="date" class="form-control @error('loan_date') is-invalid @enderror" name="loan_date" value="{{ old('loan_date') }}">
                                 <x-invalid-feedback field='loan_date'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Tanggal Batas Pengembalian <x-label-required></x-label-required></label>
                                 <input type="date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}">
                                 <x-invalid-feedback field='due_date'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-12 col-12">
                                 <label>Alasan Peminjaman</label>
                                 <textarea class="form-control @error('reason') is-invalid @enderror" name="reason" id="" value="{{ old('reason') }}" placeholder="Ketikkan Disini"></textarea>
                                 <x-invalid-feedback field='reason'></x-invalid-feedback>
                              </div>
                           </div>
                           <div class="row d-none">
                              <div class="form-group col-md-12 col-12">
                                 <label>Harga <x-label-required></x-label-required></label>
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <div class="input-group-text">
                                             Rp.
                                         </div>
                                     </div>
                                     <input type="numeric" class="form-control " id="price-input" placeholder="100000" autocomplete="off">
                                 </div>
                             </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-right">
                     <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="col-12 col-md-12 col-lg-5">
            <div class="card">
               <form action="{{ route('inventory_admin.divisionloans.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Informasi Barang Pada Divisi</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-12 col-12 mr-3 mt-4">
                           <div class="image-preview-container">
                              <img id="preview-photo" class="img-fluid" style="width:100%; height: 300px; object-fit:cover;" src="{{ asset('assets/img/me/empty-photo2.jpg') }}" alt="Preview Image">
                           </div>
                        </div>
                        <div class="col-md-12 col-12 mt-4">
                           <div class="row">
                              <div class="form-group col-md-6 col-12">
                                 <label>Merek</label>
                                 <input type="text" id="item-brand" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Tipe</label>
                                 <input type="text" id="item-type" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-5 col-12">
                                 <label>Satuan</label>
                                 <input type="text" id="item-unit" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-4 col-12">
                                 <label>Kondisi</label>
                                 <input type="text" id="item-condition" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-3 col-12">
                                 <label>Jumlah</label>
                                 <input type="number" min="0" id="item-quantity" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
   

@endsection

