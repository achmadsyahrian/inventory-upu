{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <form action="{{ route('inventory_admin.itementries.index') }}" method="get">
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
                  <label>Tanggal Masuk </label>
                  <input type="date" class="form-control" name="entry_date" value="{{ request('entry_date') }}">
               </div>
               <div class="form-group">
                  <label>Supplier</label>
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Masukkan Supplier" value="{{ request("supplier") }}" name="supplier" autocomplete="off">
                  </div>
               </div>
               <div class="form-group">
                  <label>Jumlah</label>
                  <div class="input-group">
                     <input type="number" min="1" class="form-control" name="quantity" value="{{ request('quantity') }}" placeholder="Masukkan Jumlah" autocomplete="off">
                  </div>
               </div>
               <div class="form-group">
                  <label>Harga</label>
                  <div class="input-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                Rp.
                            </div>
                        </div>
                        <input type="numeric" class="form-control" id="price-input" name="price" value="{{ request('price') }}" placeholder="100000" autocomplete="off">
                    </div>
                  </div>
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

