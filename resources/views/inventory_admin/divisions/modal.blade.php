{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('divisions.index') }}" method="get">
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
                  <label>Kepala Bagian</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Masukkan Nama Kabag" value="{{ request("division_head") }}" name="division_head" autocomplete="off">
                  </div>
               </div>
               <div class="form-group">
                  <label>Luas (m&sup2;)</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Masukkan Luas" value="{{ request("dimensions") }}" name="dimensions" autocomplete="off">
                  </div>
                  <div class="form-text text-muted">Contoh : 20,24</div>
               </div>
               <div class="form-group">
                  <label>Lokasi</label>
                  <select class="form-control selectric" name="building_id">
                     <option selected disabled>Pilih Lokasi</option>
                     @foreach ($buildings as $item)
                        <option value="{{ $item->id }}" {{ request('building_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Kondisi</label>
                  <select class="form-control selectric" name="condition_id">
                     <option selected disabled>Pilih Kondisi</option>
                     @foreach ($conditions as $item)
                        <option value="{{ $item->id }}" {{ request('condition_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
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

