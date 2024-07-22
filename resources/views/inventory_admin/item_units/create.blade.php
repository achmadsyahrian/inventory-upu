@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.divisions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah Satuan</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.divisions.index') }}">Satuan Barang</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Satuan</h2>
      <p class="section-lead">
         Tambahkan informasi untuk satuan barang dengan mengisi data berikut.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('inventory_admin.itemunits.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Satuan</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Nama <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                           <div class="form-text text-muted">Contoh : Pieces</div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Simbol</label>
                           <input type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}" placeholder="Masukkan Simbol" autocomplete="off">
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

