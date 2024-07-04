@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('division_admin.divisionrequests.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Tambah Permintaan</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('division_admin.divisionrequests.index') }}">Permintaan Barang</a></div>
         <div class="breadcrumb-item">Tambah</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Tambah Permintaan</h2>
      <p class="section-lead">
         Gunakan formulir ini untuk mengajukan permintaan barang baru. Untuk melihat daftar barang yang tersedia, klik <a href="{{ route('division_admin.inventoryitems.index') }}">di sini</a>.
      </p>

      <div class="row mt-sm-4">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <form action="{{ route('division_admin.divisionrequests.store') }}" method="post" novalidate="">
                  @csrf
                  <div class="card-header">
                     <h4>Tambah Permintaan</h4>
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
                              <div class="form-group col-md-4 col-12 d-none">
                                  <label>Kondisi</label>
                                  <input type="text" id="item-condition" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-4 col-12">
                                  <label>Stok Tersedia</label>
                                  <input type="number" min="0" id="item-stock" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                              <div class="form-group col-md-10 col-12 d-none">
                                  <label>Keterangan</label>
                                  <input type="text" id="item-description" class="form-control" autocomplete="off" disabled placeholder="--">
                              </div>
                          </div>               
                        </div>
                        <div class="col-md-2 col-12 mr-3">
                        </div>
                        <div class="col-md-9 col-12">
                           <h2 class="section-title">Informasi Permintaan</h2>
                           <hr>
                           <div class="row">
                              <div class="form-group col-md-4 col-12">
                                 <label>Nama Pemesan</label>
                                 <input type="text" class="form-control @error('requester_name') is-invalid @enderror" name="requester_name" value="{{ old('requester_name') }}" placeholder="Masukkan Nama Pemesan" autocomplete="off">
                                 <x-invalid-feedback field='requester_name'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-2 col-12">
                                 <label>Jumlah <x-label-required></x-label-required></label>
                                 <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" placeholder="Masukkan Jumlah" autocomplete="off">
                                 <x-invalid-feedback field='quantity'></x-invalid-feedback>
                              </div>
                              <div class="form-group col-md-3 col-12 d-none">
                                 <label>Harga <x-label-required></x-label-required></label>
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <div class="input-group-text">
                                             Rp.
                                         </div>
                                     </div>
                                     <input type="numeric" class="form-control " id="price-input" value="{{ old('price') }}" placeholder="100000" autocomplete="off">
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

      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Permintaan Hari Ini</h4>
               </div>
               <div class="card-body">
                  <div class="clearfix mb-3"></div>

                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Jumlah</th>
                           <th>Satuan</th>
                           <th>Status</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>
                              <div class="d-flex align-items-center">
                                 <div>
                                    <div>{{ $item->inventoryItem->name }}</div>
                                    <div class="text-muted">
                                       Merek : <span class="text-muted">{{ $item->brand ?? '--' }}</span>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td>
                              <div class="badge badge-success"><i class="fas fa-cube"></i>  {{ $item->quantity }}</div>
                           </td>
                           <td>
                              {{ $item->inventoryItem->unit->name }}
                           </td>
                           <td>
                              @if ($item->status == 'pending')
                                 <div class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Persetujuan</div>
                              @endif
                           </td>
                           <td>
                              <form class="d-inline" action="{{ route('division_admin.divisionrequests.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                 @method('delete')
                                 @csrf
                                 <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus permintaan ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
                              </form>
                           </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="100" class="text-center">Belum ada permintaan <i class="far fa-sad-tear"></i></td>
                        </tr>
                        @endforelse
                     </table>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection

