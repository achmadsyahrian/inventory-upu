@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Pemasukan Barang</h1>
      <div class="section-header-button">
         <a href="{{ route('inventory_admin.itementries.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Pemasukan Barang</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Barang Masuk</h2>
      <p class="section-lead">
         Sistem ini memudahkan Anda dalam mengelola penambahan stok dan memastikan data barang yang masuk selalu up-to-date.
      </p>

      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Barang Masuk</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('inventory_admin.itementries.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>

                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Tanggal Masuk</th>
                           <th>Nama Barang</th>
                           <th>Tipe</th>
                           <th>Jumlah Masuk</th>
                           <th>Supplier</th>
                           <th>Harga</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                        <tr>
                           <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                           <td>
                              {{ \Carbon\Carbon::parse($item->entry_date)->isoFormat('DD MMMM YYYY') }}
                           </td>
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
                              {{ $item->quantity }} {{ $item->inventoryItem->unit->symbol ?? $item->inventoryItem->unit->name }}
                           </td>
                           <td>
                              {{ $item->supplier ?? '--'}}
                           </td>
                           <td>
                              <div class="badge badge-success">Rp. {{ number_format($item->price, 0, ',', '.') }}</div>
                           </td>
                           <td>
                              {{-- <a href="{{ route('inventory_admin.itementries.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a> --}}
                              <form class="d-inline" action="{{ route('inventory_admin.itementries.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                 @method('delete')
                                 @csrf
                                 <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus barang ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
                              </form>
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

@include('inventory_admin.item_entries.modal')
@endsection
