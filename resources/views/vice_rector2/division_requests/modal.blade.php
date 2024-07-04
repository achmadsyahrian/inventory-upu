{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('vice_rector2.divisionrequests.index') }}" method="get">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Pencarian Lanjutan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Tanggal Permintaan</label>
                  <input type="date" class="form-control datepicker" name="date" value="{{ request('date') }}">
               </div>
               <div class="form-group">
                  <label>Lokasi</label>
                  <select class="form-control selectric" name="building_id">
                     <option selected disabled>Pilih Lokasi</option>
                     @foreach ($divisions as $item)
                        <option value="{{ $item->id }}" {{ request('building_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
         </div>
      </form>
   </div>
</div>

