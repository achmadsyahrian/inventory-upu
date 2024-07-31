{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('inventory_admin.divisionitems.index') }}" method="get">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Pencarian Lanjutan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Barang</label>
                  <select class="form-control selectric" name="inventory_item_id">
                     <option selected disabled>Pilih Barang</option>
                     @foreach ($inventoryItems as $item)
                        <option value="{{ $item->id }}" {{ request('inventory_item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Lokasi</label>
                  <select class="form-control selectric" name="division_id">
                     <option selected disabled>Pilih Lokasi</option>
                     @foreach ($divisions as $item)
                        <option value="{{ $item->id }}" {{ request('division_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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

