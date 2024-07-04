@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <div class="section-header-back">
         <a href="{{ route('division_admin.divisionrequests.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>Data Permintaan</h1>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item active"><a href="{{ route('division_admin.divisionrequests.index') }}">Permintaan Barang</a></div>
         <div class="breadcrumb-item">{{ \Carbon\Carbon::parse($date)->isoFormat('DD MMMM YYYY') }}</div>
      </div>
   </div>

   <div class="section-body">
      <h2 class="section-title">Data Permintaan</h2>
      <p class="section-lead">
         Informasi lengkap mengenai permintaan barang ini termasuk daftar barang yang diminta, serta status dan tindak lanjut yang diperlukan.
      </p>

      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Permintaan Tanggal {{ \Carbon\Carbon::parse($date)->isoFormat('DD MMMM YYYY') }}</h4>
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
                           <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
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
               <x-pagination :data="$data"></x-pagination>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection

