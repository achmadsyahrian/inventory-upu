@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.itemunits.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit Satuan</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.itemunits.index') }}">Satuan Barang</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit Satuan</h2>
      <p class="section-lead">
         Perbarui data satuan barang
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('inventory_admin.itemunits.update', $itemUnit) }}" method="post" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit Satuan Barang</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Nama <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $itemUnit->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                           <div class="form-text text-muted">Contoh : Pieces</div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Simbol</label>
                           <input type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol', $itemUnit->symbol) }}" placeholder="Masukkan Nama Kabag" autocomplete="off">
                           <x-invalid-feedback field='symbol'></x-invalid-feedback>
                           <div class="form-text text-muted">Contoh : Pcs</div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-right">
                     <button class="btn btn-primary">Simpan</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection

