{{-- Modal --}}
<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('inventory_admin.divisionitems.print') }}" method="post">
         @csrf
         @method('post')
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="printModalLabel">Cetak Laporan Divisi</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Divisi <x-label-required></x-label-required></label>
                  <select class="form-control selectric" name="division_id">
                     <option selected disabled>Pilih Divisi</option>
                     @foreach ($divisions as $item)
                        <option value="{{ $item->id }}" {{ request('division_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Jenis Barang <x-label-required></x-label-required></label>
                  <select class="form-control selectric" name="type_id">
                     <option selected disabled>Pilih Jenis</option>
                     <option value="3" {{ request('type_id') == 3 ? 'selected' : '' }}>Semua</option>
                     <option value="2" {{ request('type_id') == 2 ? 'selected' : '' }}>Non-Habis Pakai</option>
                     <option value="1" {{ request('type_id') == 1 ? 'selected' : '' }}>Habis Pakai</option>
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

