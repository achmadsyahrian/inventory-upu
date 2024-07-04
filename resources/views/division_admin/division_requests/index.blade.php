@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Permintaan Barang</h1>
      <div class="section-header-button">
         <a href="{{ route('division_admin.divisionrequests.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Permintaan Barang</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Permintaan Barang</h2>
      <p class="section-lead">
         Anda dapat mengelola semua informasi divisi dengan mudah, termasuk melakukan perubahan dan penghapusan data.
      </p>
   
      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Permintaan</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('division_admin.divisionrequests.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>
   
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Tanggal Permintaan</th>
                           <th>Jumlah</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                              <td>
                                 <div class="d-flex align-items-center">
                                     <div>
                                         <div>{{ \Carbon\Carbon::parse($item->date)->isoFormat('DD MMMM YYYY') }}</div>
                                     </div>
                                 </div>
                             </td>
                             <td>{{ $item->count ?? '--' }}</td>
                              <td>
                                 <a href="{{ route('division_admin.divisionrequests.detail', ['date' => $item->date]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i> Detail Permintaan</a>
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

{{-- @include('division_admin.divisionrequests.modal') --}}
@endsection