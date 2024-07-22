@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Satuan Barang</h1>
      <div class="section-header-button">
         <a href="{{ route('inventory_admin.itemunits.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Satuan Barang</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Data Satuan</h2>
      <p class="section-lead">
         Halaman ini menampilkan daftar satuan barang yang digunakan dalam sistem. Anda dapat melihat, menambah, mengedit, atau menghapus satuan barang sesuai kebutuhan.
      </p>

   
      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Divisi</h4>
               </div>
               <div class="card-body">
                  {{-- <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('inventory_admin.itemunits.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div> --}}
                  <div class="clearfix mb-3"></div>
   
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Simbol</th>
                           <th></th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                             <td>{{ $item->name ?? '--' }}</td>
                              <td>
                                 {{ $item->symbol ?? '--' }}
                              </td>
                              <td>
                                 <a href="{{ route('inventory_admin.itemunits.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                 <form class="d-inline" action="{{ route('inventory_admin.itemunits.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus divisi ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
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

{{-- @include('inventory_admin.itemunits.modal') --}}
@endsection