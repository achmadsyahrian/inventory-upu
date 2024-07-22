@extends('app')
@section('content')

    <div class="section">
        <x-sweetalert></x-sweetalert>

        <div class="section-header">
            <h1>Peminjaman Barang</h1>
            <div class="section-header-button">
                <a href="{{ route('inventory_admin.divisionloans.create') }}" class="btn btn-primary">Tambah</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                <div class="breadcrumb-item">Peminjaman Barang</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Peminjaman Barang</h2>
            <p class="section-lead">
                Sistem ini memudahkan anda untuk mengelola data peminjaman barang antar divisi yg ada
            </p>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Peminjaman Barang</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary ml-3" data-toggle="modal"
                                        data-target="#exampleModal">Pencarian Lanjutan</button>
                                    <form action="{{ route('inventory_admin.divisionloans.index') }}" method="GET"
                                        style="display:inline;">
                                        <button type="submit" class="btn btn-secondary ml-3">Reset Pencarian</button>
                                    </form>
                                </div>
                            </div>
                            <div class="clearfix mb-3"></div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Divisi Peminjam</th>
                                        <th>Divisi Pemberi</th>
                                        <th>Barang Dipinjam</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div>
                                                            {{ \Carbon\Carbon::parse($item->loan_date)->isoFormat('DD MMMM YYYY') }}
                                                        </div>
                                                        @if ($item->status == 'borrowed')
                                                            <div class="text-muted">
                                                                Tenggat:
                                                                @if (\Carbon\Carbon::parse($item->due_date)->isToday())
                                                                    <span class="text-danger">Hari Ini</span>
                                                                @else
                                                                    {{ \Carbon\Carbon::parse($item->due_date)->isoFormat('DD MMMM YYYY') }}
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->toDivision->name }}</td>
                                            <td>{{ $item->fromDivision->name }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div>{{ $item->inventoryItem->name }}</div>
                                                        <div class="text-muted">
                                                            Merek : <span
                                                                class="text-muted">{{ $item->inventoryItem->brand ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge badge-success"><i class="fas fa-cube"></i>
                                                    {{ $item->quantity }}</div>
                                            </td>
                                            <td>
                                                @if ($item->status == 'borrowed')
                                                    @if ($item->due_date && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($item->due_date)->addDay()))
                                                        <div class="badge badge-danger"><i
                                                                class="fas fa-exclamation-circle"></i> Barang Terlambat
                                                            Dikembalikan</div>
                                                    @else
                                                        <div class="badge badge-warning"><i class="fas fa-clock"></i> Belum
                                                            Dikembalikan</div>
                                                    @endif
                                                @elseif ($item->status == 'returned')
                                                    <div class="badge badge-success"><i class="fas fa-check-circle"></i>
                                                        Sudah Dikembalikan</div>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- Kembalikan Barang --}}
                                                @if ($item->status == 'borrowed')
                                                    <form class="d-inline"
                                                        action="{{ route('inventory_admin.divisionloans.return', $item) }}"
                                                        method="post" id="return-data-{{ $item->id }}">
                                                        @method('post')
                                                        @csrf
                                                        <button type="button" class="btn btn-success btn-action"
                                                            onclick="showDeleteConfirmation('Ya, Kembalikan', 'Apakah anda yakin ingin mengembalikan barang ini?', 'return-data-{{ $item->id }}')"
                                                            data-toggle="tooltip" title="Kembalikan"><i
                                                                class="fas fa-check-circle"></i></button>
                                                    </form>
                                                @endif

                                                {{-- Lihat Detail --}}
                                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                                    data-target="#collapseExample-{{ $item->id }}"
                                                    aria-expanded="false"
                                                    data-toggle="tooltip" title="Lihat"
                                                    aria-controls="collapseExample-{{ $item->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                {{-- Hapus --}}
                                                @if ($item->status == 'borrowed')
                                                    <form class="d-inline"
                                                        action="{{ route('inventory_admin.divisionloans.destroy', $item) }}"
                                                        method="post" id="delete-data-{{ $item->id }}">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" class="btn btn-danger btn-action"
                                                            onclick="showDeleteConfirmation('Ya, Hapus', 'Apakah anda yakin ingin menghapus barang ini?', 'delete-data-{{ $item->id }}')"
                                                            data-toggle="tooltip" title="Hapus"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="collapseExample-{{ $item->id }}">
                                            <td></td>
                                            @if ($item->status == 'returned')
                                                <td colspan="2">
                                                    Waktu Dikembalikan : {{ \Carbon\Carbon::parse($item->due_date)->isoFormat('DD MMMM YYYY') }}
                                                </td>
                                            @endif
                                            <td colspan="5">
                                                Alasan Peminjaman : {{ $item->reason ?? '--' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Data tidak tersedia <i
                                                    class="far fa-sad-tear"></i></td>
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
