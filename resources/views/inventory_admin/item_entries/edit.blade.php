@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.inventoryitems.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit Barang</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.inventoryitems.index') }}">Data Inventaris</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit Barang</h2>
      <p class="section-lead">
         Silakan perbarui informasi barang <span class="text-primary">{{ $inventoryItem->name }}</span> di bawah ini sesuai dengan perubahan yang diinginkan
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('inventory_admin.inventoryitems.update', $inventoryItem) }}" enctype="multipart/form-data" method="post" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit Barang</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-2 col-12 mr-3">
                           <label class="">Foto</label>
                           <div class="image-preview-container">
                              @if ($inventoryItem->photo) 
                                 <img id="preview-photo" class="img-fluid" style="width:100%; height: 200px; object-fit:cover;" src="{{ asset('storage/photos/inventory_item/' . $inventoryItem->photo) }}" alt="Preview Image">
                              @else
                                 <img id="preview-photo" class="img-fluid" style="width:100%; height: 200px; object-fit:cover;" src="{{ asset('assets/img/me/empty-photo.png') }}" alt="Preview Image">
                              @endif
                           </div>
                           <div class="custom-file mt-4">
                               <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="profile-logo" onchange="previewImage(event)">
                               <label class="custom-file-label">Pilih Gambar</label>
                           </div>
                           @error('photo')
                              <div class="form-text text-danger">{{ $message }}</div>
                           @enderror
                           <div class="form-text text-muted">Batas maksimal ukuran gambar adalah 2MB</div>
                       </div>
                        <div class="col-md-9 col-12">
                           <div class="row">
                              <div class="form-group col-md-6 col-12">
                                 <label>Nama <x-label-required></x-label-required></label>
                                 <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $inventoryItem->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                                 <x-invalid-feedback field='name'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Merek</label>
                                 <input type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand', $inventoryItem->brand) }}" placeholder="Masukkan Merek" autocomplete="off">
                                 <x-invalid-feedback field='brand'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-3 col-12">
                                 <label>Tipe <x-label-required></x-label-required></label>
                                 <select class="form-control selectric" name="type_id">
                                    <option selected disabled>Pilih Tipe</option>
                                    @foreach ($types as $item)
                                    <option value="{{ $item->id }}" {{ old('type_id') == $item->id || (isset($inventoryItem) && $inventoryItem->type_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                 </select>
                                 @error('type_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-5 col-12">
                                 <label>Satuan <x-label-required></x-label-required></label>
                                 <select class="form-control select2" name="unit_id">
                                    <option selected disabled>Pilih Satuan</option>
                                    @foreach ($units as $item)
                                    <option value="{{ $item->id }}" {{ old('unit_id') == $item->id || (isset($inventoryItem) && $inventoryItem->unit_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}{{ $item->symbol ? ' (' . $item->symbol . ')' : '' }}</option>
                                    @endforeach
                                 </select>
                                 @error('unit_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-4 col-12">
                                 <label>Kondisi <x-label-required></x-label-required></label>
                                 <select class="form-control selectric" name="condition_id">
                                    <option selected disabled>Pilih Kondisi</option>
                                    @foreach ($conditions as $item)
                                    <option value="{{ $item->id }}" {{ old('condition_id') == $item->id || (isset($inventoryItem) && $inventoryItem->condition_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                 </select>
                                 @error('condition_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-2 col-12">
                                 <label>Stok <x-label-required></x-label-required></label>
                                 <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $inventoryItem->stock) }}" placeholder="Masukkan Jumlah" autocomplete="off">
                                 <x-invalid-feedback field='stock'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-10 col-12">
                                 <label>Keterangan</label>
                                 <input type="text" min="0" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description', $inventoryItem->description) }}" placeholder="Masukkan Keterangan" autocomplete="off">
                                 <x-invalid-feedback field='description'></x-invalid-feedback>
                              </div>
                           </div>
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

