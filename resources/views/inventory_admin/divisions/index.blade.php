@extends('app')
@section('content')

<div class="section">
   <x-sweetalert></x-sweetalert>

   <div class="section-header">
      <h1>Divisi</h1>
      <div class="section-header-button">
         <a href="{{ route('divisions.create') }}" class="btn btn-primary">Tambah</a>
      </div>
      <div class="section-header-breadcrumb">
         <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
         <div class="breadcrumb-item">Divisi</div>
      </div>
   </div>
   
   <div class="section-body">
      <h2 class="section-title">Divisi</h2>
      <p class="section-lead">
         Anda dapat mengelola semua informasi divisi dengan mudah, termasuk melakukan perubahan dan penghapusan data.
      </p>
   
      <div class="row mt-4">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4>Data Divisi</h4>
               </div>
               <div class="card-body">
                  <div class="float-right">
                     <div class="input-group">
                        <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">Pencarian Lanjutan</button>
                        <form action="{{ route('divisions.index') }}" method="GET" style="display:inline;">
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
                           <th>Kabag</th>
                           <th>Luas (m&sup2;)</th>
                           <th>Kondisi</th>
                           <th>Aksi</th>
                        </tr>
                        @forelse ($data as $item)
                           <tr>
                              <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                              <td>
                                 <div class="d-flex align-items-center">
                                     <div>
                                         <div>{{ $item->name }}</div>
                                         <div>
                                             {{-- <a href="#">{{ $item->building->name ?? '--' }}</a> --}}
                                             <span class="text-primary">{{ $item->building->name ?? '--' }}</span>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                             <td>{{ $item->division_head ?? '--' }}</td>
                              <td>
                                 {{ $item->dimensions ? $item->dimensions . ' m²' : '--' }}

                              </td>
                              <td>
                                 @php
                                    $condition = strtolower($item->condition->name);
                                    $badgeClass = '';
   
                                    switch ($condition) {
                                       case 'baik':
                                             $badgeClass = 'badge-success';
                                             $icon = '<i class="fas fa-smile-beam"></i>';
                                             break;
                                       case 'perlu perbaikan':
                                             $badgeClass = 'badge-warning';
                                             $icon = '<i class="fas fa-frown-open"></i>';
                                             break;
                                       case 'buruk':
                                             $badgeClass = 'badge-danger';
                                             $icon = '<i class="fas fa-angry"></i>';
                                             break;
                                       default:
                                             $badgeClass = 'badge-secondary';
                                             $icon = '<i class="fas fa-question-circle"></i>';
                                             break;
                                    }
                                 @endphp
   
                                 <div class="badge {{ $badgeClass }}">{!! $icon !!} {{ $item->condition->name }}</div>
                              </td>
                              <td>
                                 <a href="{{ route('divisions.edit', [$item]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                 <form class="d-inline" action="{{ route('divisions.destroy', $item) }}" method="post" id="delete-data-{{ $item->id }}">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-action" onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus user ini?', 'delete-data-{{ $item->id }}')" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></button>
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

@include('inventory_admin.divisions.modal')
@endsection