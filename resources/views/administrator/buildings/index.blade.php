@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Lokasi Bangunan</h1>
      <div class="section-header-button">
         <a href="{{ route('administrator.buildings.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Lokasi Bangunan</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Lokasi Bangunan</h2>
      <p class="section-lead">
         Pengelolaan informasi lokasi bangunan untuk <a href="{{ route('administrator.divisions.index') }}" class="text-primary">divisi</a> memudahkan perubahan dan penghapusan data secara tepat dan efektif.
      </p>
   
      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Divisi</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <form action="{{ route('administrator.buildings.index') }}">
                        <div class="input-group">
                          <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Masukkan Nama">
                          <div class="input-group-append">                                            
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                  </div>
                  <div class="clearfix mb-3"></div>
   
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                             <td>{{ $item->name ?? '--' }}</td>
                              <td>
                                 <a href="{{ route('administrator.buildings.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                 <form class="d-inline" action="{{ route('administrator.buildings.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus lokasi ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
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

{{-- @include('administrator.buildings.modal') --}}
@endsection