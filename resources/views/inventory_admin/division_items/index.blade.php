@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Data Barang</h1>
      <div class="section-header-button">
         <a href="{{ route('inventory_admin.divisionitems.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Barang Divisi</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Barang Divisi</h2>
      <p class="section-lead">
         Akses informasi barang divisi secara lengkap.
         Lihat stok barang yang tersedia di gudang dengan mengunjungi <a href="{{ route('inventory_admin.inventoryitems.index') }}">halaman ini</a>.
      </p>      

      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Barang</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-warning ml-3" data-toggle="modal" data-target="#printModal"><i class="fas fa-print"></i> Print</button>
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('inventory_admin.divisionitems.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>

                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Posisi</th>
                           <th>Nama</th>
                           <th>Tipe</th>
                           <th>Jumlah</th>
                           <th>Satuan</th>
                           <th>Kondisi</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                        <tr>
                           <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                           <td>{{ $item->division->name }}</td>
                           <td>
                              <div class="d-flex align-items-center">
                                 <div>
                                    <div>{{ $item->inventoryItem->name }}</div>
                                    <div class="text-muted">
                                       Merek : <span class="text-muted">{{ $item->inventoryItem->brand ?? '--' }}</span>
                                    </div>
                                 </div>
                              </div>
                           </td>
                           <td>
                              <div class="badge badge-{{ $item->inventoryItem->type_id == 1 ? 'primary' : 'info' }}" data-toggle="tooltip" title="{{ $item->inventoryItem->type_id == 1 ? 'Habis Pakai' : 'Asset' }}">
                                 <i class="fas fa-{{ $item->inventoryItem->type_id == 1 ? 'recycle' : 'box-open' }}"></i> 
                             </div>                             
                           </td>
                           <td>
                              <div class="badge badge-success"><i class="fas fa-cube"></i> {{ $item->quantity }}</div>                        
                           </td>
                           <td>
                              {{ $item->inventoryItem->unit ? $item->inventoryItem->unit->name . ($item->inventoryItem->unit->symbol ? ' (' . $item->inventoryItem->unit->symbol . ')' : '') : '--' }}
                           </td>
                           <td>
                              {{-- @php
                                 $condition = strtolower($item->condition->name);
                                 $badgeClass = '';

                                 switch ($condition) {
                                    case 'baik':
                                          $badgeClass = 'badge-success';
                                          $icon = '<i class="fas fa-smile-beam"></i>';
                                          break;
                                    case 'buruk':
                                          $badgeClass = 'badge-warning';
                                          $icon = '<i class="fas fa-frown-open"></i>';
                                          break;
                                    case 'rusak':
                                          $badgeClass = 'badge-danger';
                                          $icon = '<i class="fas fa-angry"></i>';
                                          break;
                                    default:
                                          $badgeClass = 'badge-secondary';
                                          $icon = '<i class="fas fa-question-circle"></i>';
                                          break;
                                 }
                              @endphp
                              <div class="badge {{ $badgeClass }}">{!! $icon !!} {{ $item->condition->name }}</div> --}}
                           </td>
                           <td>
                              {{-- <a href="{{ route('inventory_admin.inventoryitems.edit', [$item->inventoryItem]) }}" class="btn btn-info btn-action mr-1" data-toggle="tooltip" title="Lihat Barang"><i class="fas fa-eye"></i></a> --}}
                              <a href="{{ route('inventory_admin.divisionitems.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
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

@include('inventory_admin.division_items.modal')
@include('inventory_admin.division_items.modal-print')
@endsection
