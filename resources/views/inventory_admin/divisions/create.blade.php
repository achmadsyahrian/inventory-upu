@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('divisions.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah Divisi</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('divisions.index') }}">Divisi</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Divisi</h2>
      <p class="section-lead">
         Tambahkan informasi untuk divisi baru dengan mengisi data berikut.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('divisions.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Divisi</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Nama <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Kepala Bagian</label>
                           <input type="text" class="form-control @error('division_head') is-invalid @enderror" name="division_head" value="{{ old('division_head') }}" placeholder="Masukkan Nama Kabag" autocomplete="off">
                           <x-invalid-feedback field='division_head'></x-invalid-feedback>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-6 col-12">
                           <label>Lokasi <x-label-required></x-label-required></label>
                           <select class="form-control selectric" name="building_id">
                              <option selected disabled>Pilih Lokasi</option>
                              @foreach ($buildings as $item)
                              <option value="{{ $item->id }}" {{ old('building_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('building_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                           <label>Luas</label>
                           <input type="text" class="form-control @error('dimensions') is-invalid @enderror" name="dimensions" value="{{ old('dimensions') }}" placeholder="Masukkan Luas" autocomplete="off">
                           <x-invalid-feedback field='dimensions'></x-invalid-feedback>
                           <div class="form-text text-muted">Contoh : 20,24</div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-4 col-12">
                           <label>Kondisi <x-label-required></x-label-required></label>
                           <select class="form-control selectric" name="condition_id">
                              <option selected disabled>Pilih Kondisi</option>
                              @foreach ($conditions as $item)
                              <option value="{{ $item->id }}" {{ old('condition_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                              @endforeach
                           </select>
                           @error('condition_id')
                           <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="form-group col-md-8 col-12">
                           <label>Keterangan</label>
                           <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" placeholder="Masukkan Keterangan" autocomplete="off">
                           <x-invalid-feedback field='description'></x-invalid-feedback>
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

