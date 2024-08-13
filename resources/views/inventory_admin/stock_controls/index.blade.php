@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Stock Control</h1>
      <div class="section-header-button">
         {{-- <a href="{{ route('inventory_admin.itemunits.create') }}" class="btn btn-primary">Tambah</a> --}}
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Stock Control</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Stock Control</h2>
      <p class="section-lead">
         Halaman ini menampilkan laporan daftar control barang dalam sistem.
      </p>

   
      <div class="row mt-4">
         <div class="col-5">
            <div class="card">
               <div class="card-body">
                  <form action="{{ route('inventory_admin.stockcontrols.print') }}" method="post">
                     @csrf
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Dari </label>
                           <input type="date" name="from_date" class="form-control" placeholder="Dari Tanggal">
                           @error('from_date')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Hingga</label>
                           <input type="date" name="to_date" class="form-control" placeholder="Hingga Tanggal">
                           @error('to_date')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-12 col-12">
                           <label>Barang <x-label-required></x-label-required></label>
                           <select class="form-control select2" name="inventory_item_id" id="inventory-item-select">
                               <option selected disabled>Pilih Barang</option>
                               @foreach ($inventoryItems as $item)
                               <option value="{{ $item->id }}" {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                               @endforeach
                           </select>
                           @error('inventory_item_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <button type="submit" class="btn btn-primary">Lihat Control</button>
                        </div>
                     </div>
                  </form>
                  <div class="clearfix mb-3"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- @include('inventory_admin.itemunits.modal') --}}
@endsection