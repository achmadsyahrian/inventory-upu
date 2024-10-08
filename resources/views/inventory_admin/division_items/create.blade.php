@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('inventory_admin.divisionitems.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah Barang Divisi</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('inventory_admin.divisionitems.index') }}">Barang Divisi</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Barang</h2>
      <p class="section-lead">
         Pilih data barang yg ingin dimasukkan dalam divisi yg ditentukan
      </p>


      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('inventory_admin.divisionitems.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Barang Divisi</h4>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="form-group col-md-2 col-12 mr-3">
                           <label class="">Foto</label>
                           <div class="image-preview-container">
                               <img id="preview-photo" class="img-fluid" style="width:100%; height: 200px; object-fit:cover;" src="{{ asset('assets/img/me/empty-photo2.jpg') }}" alt="Preview Image">
                           </div>
                       </div>
                        <div class="col-md-9 col-12">
                           <h2 class="section-title">Data Barang</h2>
                           <div class="row">
                              <div class="form-group col-md-6 col-12">
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
                                  <label>Merek</label>
                                  <input type="text" id="item-brand" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-3 col-12">
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
                              <div class="form-group col-md-2 col-12">
                                  <label>Stok</label>
                                  <input type="number" min="0" id="item-stock" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-4 col-12">
                                 <label>Garansi</label>
                                 <input type="text" id="item-warranty" class="form-control" autocomplete="off" disabled placeholder="--">
                             </div>
                              <div class="form-group col-md-6 col-12">
                                  <label>Keterangan</label>
                                  <input type="text" id="item-description" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                          </div>               
                        </div>
                        <div class="col-md-2 col-12 mr-3">
                        </div>
                        <div class="col-md-9 col-12">
                           <h2 class="section-title">Informasi Divisi</h2>
                           <hr>
                           <div class="row">
                              <div class="form-group col-md-7 col-12">
                                 <label>Divisi <x-label-required></x-label-required></label>
                                 <select class="form-control select2" name="division_id">
                                     <option selected disabled>Pilih Divisi</option>
                                     @foreach ($divisions as $item)
                                     <option value="{{ $item->id }}" {{ old('division_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                     @endforeach
                                 </select>
                                 @error('division_id')
                                 <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="form-group col-md-5 col-12">
                                 <label>Jumlah Barang <x-label-required></x-label-required></label>
                                 <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" placeholder="Masukkan Jumlah" autocomplete="off">
                                 <x-invalid-feedback field='quantity'></x-invalid-feedback>
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
                                     <input type="numeric" class="form-control @error('price') is-invalid @enderror" id="price-input" name="price" value="{{ old('price') }}" placeholder="100000" autocomplete="off">
                                 </div>
                                 @error('price')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                 @enderror
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

