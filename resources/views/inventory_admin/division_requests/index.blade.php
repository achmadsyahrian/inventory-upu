@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Permintaan Barang</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Permintaan Barang</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Permintaan Barang</h2>
      <p class="section-lead">
         Tampilan data lengkap permintaan barang dari seluruh divisi.
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
                        <form action="{{ route('inventory_admin.divisionrequests.index') }}" method="GET" style="display:inline;">
                           <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                        </form>
                     </div>
                  </div>
                  <div class="clearfix mb-3"></div>
   
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <tr>
                           <th>No</th>
                           <th>Unit Divisi</th>
                           <th>Tanggal Permintaan</th>
                           <th>Jumlah</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                              <td>
                                 {{ $item->division->name }}
                              </td>
                              <td>
                                 <div class="d-flex align-items-center">
                                     <div>
                                         <div>{{ \Carbon\Carbon::parse($item->date)->isoFormat('DD MMMM YYYY') }}</div>
                                     </div>
                                 </div>
                             </td>
                             <td>{{ $item->count ?? "--" }}</td>
                              <td>
                                 <a href="{{ route('inventory_admin.divisionrequests.detail', ['date' => $item->date, 'division' => $item->division_id]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Lihat Detail"><i class="fas fa-eye"></i> Detail Permintaan</a>
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

@include('inventory_admin.division_requests.modal')
@endsection