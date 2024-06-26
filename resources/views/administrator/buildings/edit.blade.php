@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('administrator.buildings.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit Lokasi</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('administrator.buildings.index') }}">Lokasi Bangunan</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit Lokasi</h2>
      <p class="section-lead">
         Silakan perbarui informasi lokasi <span class="text-primary">{{ $building->name }}</span> di bawah ini sesuai dengan perubahan yang diinginkan
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('administrator.buildings.update', $building) }}" method="post" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit Lokasi</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-12 col-12">
                           <label>Nama <x-label-required></x-label-required></label>
                           <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $building->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                           <x-invalid-feedback field='name'></x-invalid-feedback>
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

