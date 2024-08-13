@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Data Inventaris</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Stok Barang</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Stok Barang</h2>
      <p class="section-lead">
         Anda bisa mencari tau barang apa saja yg ada pada inventory untuk kemudian melakukan permintaan ke divisi anda.
      </p>

      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Stok Barang</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('division_admin.inventoryitems.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>

                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Tipe</th>
                           <th>Stok</th>
                           <th>Satuan</th>
                        </tr>
                        @forelse ($data as $item)
                        <tr>
                           <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                           <td>
                              <div class="d-flex align-items-center">
                                 <div>
                                    <div>{{ $item->name }}</div>
                                    <div class="text-muted">
                                       Merek : <span class="text-muted">{{ $item->brand ?? '--' }}</span>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td>
                              <div class="badge badge-{{ $item->type_id == 1 ? 'primary' : 'info' }}" data-toggle="tooltip" title="{{ $item->type_id == 1 ? 'Habis Pakai' : 'Asset' }}">
                                 <i class="fas fa-{{ $item->type_id == 1 ? 'recycle' : 'box-open' }}"></i> {{ $item->type->name }}
                              </div>                             
                           </td>
                           <td>
                              <div class="badge badge-{{ $item->stock > 0 ? 'success' : 'danger' }}">
                                 <i class="fas fa-{{ $item->stock > 0 ? 'cube' : 'exclamation-circle' }}"></i> 
                                 {{ $item->stock > 0 ? $item->stock : 'Stok Habis' }}
                             </div>                             
                           </td>
                           <td>
                              {{ $item->unit ? $item->unit->name . ($item->unit->symbol ? ' (' . $item->unit->symbol . ')' : '') : '--' }}
                           </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="100" class="text-center">Data tidak tersedia <i class="far fa-sad-tear"></i></td>
                        </tr>
                        @endforelse
                     </table>
                  </div>
               <x-pagination :data="$data"></x-pagination>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

@include('division_admin.inventory_items.modal')
@endsection
