@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('division_admin.divisionitems.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Edit Barang Divisi</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('division_admin.divisionitems.index') }}">Barang Divisi</a></div>
         <div class="breadcrumb-item">Edit</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Edit Barang</h2>
      <p class="section-lead">
         Ubah informasi mengenai stok barang divisi anda disini.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('division_admin.divisionitems.update', $divisionItem) }}" method="post" novalidate="">
                  @method('patch')
                  @csrf
                  <div class="card-header">
                     <h4>Edit Barang Divisi</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-3 col-12 mr-3">
                           <label class="">Foto</label>
                           <div class="image-preview-container">
                              @if ($divisionItem->inventoryItem->photo) 
                                 <img id="preview-photo" class="img-fluid" style="width:100%; height: 200px; object-fit:cover;" src="{{ asset('storage/photos/inventory_item/' . $divisionItem->inventoryItem->photo) }}" alt="Preview Image">
                              @else
                                 <img id="preview-photo" class="img-fluid" style="width:100%; height: 200px; object-fit:cover;" src="{{ asset('assets/img/me/empty-photo.png') }}" alt="Preview Image">
                              @endif
                           </div>
                       </div>
                        <div class="col-md-8 col-12">
                           <h2 class="section-title">Data Barang</h2>
                           <div class="row">
                              {{-- Hidden Data --}}
                              <input type="hidden" name="inventory_item_id" value="{{ $divisionItem->inventory_item_id }}">
                              <input type="hidden" name="quantity_old" value="{{ $divisionItem->quantity }}">
                              
                              <div class="form-group col-md-6 col-12">
                                 <label>Barang <x-label-required></x-label-required></label>
                                 <input type="text" class="form-control" name="name" value="{{ old('name', $divisionItem->inventoryItem->name) }}" placeholder="Masukkan Nama" autocomplete="off" disabled>
                                 <x-invalid-feedback field='name'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Merek</label>
                                  <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->brand }}" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Tipe</label>
                                  <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->type->name }}" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Satuan</label>
                                  <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->unit->name }}" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Kondisi</label>
                                  <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->condition->name }}" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Stok</label>
                                  <input type="number" min="0" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->stock }}" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Garansi</label>
                                 <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->warranty }}" disabled placeholder="--">
                             </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Keterangan</label>
                                  <input type="text" class="form-control" autocomplete="off" value="{{ $divisionItem->inventoryItem->description }}" disabled placeholder="--">
                              </div>
                          </div>               
                        </div>
                        <div class="col-md-3 col-12 mr-3">
                        </div>
                        <div class="col-md-8 col-12">
                           <h2 class="section-title">Informasi Divisi</h2>
                           <hr>
                           <div class="row">
                              {{-- <div class="form-group col-md-7 col-12">
                                 <label>Divisi</label>
                                 <input type="text" class="form-control" disabled name="name" value="{{ old('name', $divisionItem->division->name) }}" placeholder="Masukkan Nama" autocomplete="off">
                                 <x-invalid-feedback field='name'></x-invalid-feedback>
                              </div> --}}
                             <div class="form-group col-md-6 col-12">
                                 <label>Jumlah <x-label-required></x-label-required></label>
                                 <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $divisionItem->quantity) }}" placeholder="Masukkan Jumlah" autocomplete="off">
                                 <x-invalid-feedback field='quantity'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                 <label>Kondisi <x-label-required></x-label-required></label>
                                 <select class="form-control selectric" name="condition_id">
                                    <option selected disabled>Pilih Kondisi</option>
                                    @foreach ($conditions as $item)
                                    <option value="{{ $item->id }}" {{ old('condition_id') == $item->id || (isset($divisionItem) && $divisionItem->condition_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                 </select>
                                 @error('condition_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group col-md-12 col-12">
                                 <label>Keterangan</label>
                                 <input type="text" class="form-control" name="description" value="{{ old('description', $divisionItem->description) }}" placeholder="Masukkan Keterangan" autocomplete="off">
                                 <x-invalid-feedback field='description'></x-invalid-feedback>
                              </div>

                              {{-- Gak Dipakai --}}
                              <div class="form-group col-md-3 col-12 d-none">
                                 <label>Harga <x-label-required></x-label-required></label>
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <div class="input-group-text">
                                             Rp.
                                         </div>
                                     </div>
                                     <input type="numeric" class="form-control" id="price-input" placeholder="100000" autocomplete="off">
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
      </div>
   </div>
</div>


@endsection

