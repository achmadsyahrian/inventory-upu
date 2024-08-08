{{-- Modal --}}
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('inventory_admin.divisionrequests.print') }}" method="post">
         @csrf
         @method('post')
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="printModalLabel">Cetak Laporan Permintaan Barang</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Bulan <x-label-required></x-label-required></label>
                  <select class="form-control selectric" name="month">
                      <option selected disabled>Pilih Bulan</option>
                      @foreach(range(1, 12) as $month)
                          <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                              {{ \Carbon\Carbon::create()->month($month)->locale('id')->translatedFormat('F') }}
                          </option>
                      @endforeach
                  </select>
              </div>              
              <div class="form-group">
                  <label>Tahun <x-label-required></x-label-required></label>
                  <select class="form-control selectric" name="year">
                      <option selected disabled>Pilih Tahun</option>
                      @foreach(range(now()->year - 10, now()->year) as $year)
                          <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                              {{ $year }}
                          </option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-warning"><i class="fas fa-print"></i> Print</button>
            </div>
         </div>
      </form>
   </div>
</div>

