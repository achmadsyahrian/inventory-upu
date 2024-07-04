{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('division_admin.inventoryitems.index') }}" method="get">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Pencarian Lanjutan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Nama</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Masukkan Nama" value="{{ request("name") }}" name="name" autocomplete="off">
                  </div>
               </div>
               <div class="form-group">
                  <label>Merek</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Masukkan Merek" value="{{ request("brand") }}" name="brand" autocomplete="off">
                  </div>
               </div>
               <div class="form-group">
                  <label>Tipe</label>
                  <select class="form-control selectric" name="type_id">
                     <option selected disabled>Pilih Tipe</option>
                     @foreach ($types as $item)
                        <option value="{{ $item->id }}" {{ request('type_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Satuan</label>
                  <select class="form-control selectric" name="unit_id">
                     <option selected disabled>Pilih Satuan</option>
                     @foreach ($units as $item)
                        <option value="{{ $item->id }}" {{ request('unit_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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

