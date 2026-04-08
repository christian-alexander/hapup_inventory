<div class="modal fade" id="add-product-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:;" id="add-product-form" onsubmit="addProduct()">
           <div class="form-group">
              Nama*
              <input type="text" class="form-control" name="name" placeholder="Nama Produk" required>
            </div>
           <div class="form-group">
              Kategori*
              <select class="form-control mb-3" name="product_category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach ($product_category as $pc)
                  <option value="{{ $pc->id }}">{{ $pc->name }}</option>
                @endforeach
              </select>
            </div>
           <div class="form-group">
              Harga*
              <div class="position-relative">
                <input type="number" class="form-control" name="price" placeholder="0" value="0" onkeyup="addItemPricePreview($(this))" onchange="addItemPricePreview($(this))" required>
                <span class="position-absolute font-xs" style="right:30px; top:20%; color:rgba(0,0,0,0.4);" id="add-product-price-preview">
                  {{-- js --}}
                </span>
              </div>
            </div>
           <div class="form-group">
              Stok*
              <input type="number" class="form-control" name="stock" placeholder="0" value="1" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
        <button type="submit" class="btn btn-success" form="add-product-form"><i class="fa fa-plus"></i> Tambah</button>
      </div>
    </div>
  </div>
</div>

<script>
  function addItemPricePreview(priceInput){
    priceInput.val(parseInt(priceInput.val()));
    $('#add-product-price-preview').html("(Rp " + rupiah(priceInput.val()) + ")");
  }

  function addProduct(){
    var inputData = new FormData($("#add-product-form")[0]);
    $.ajax({
      url         : "{{ url('/product') }}",
      data		    : inputData,
      headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      processData : false,
      contentType : false,
      type        : 'POST',
      beforeSend: function(){
        show_loading();
      },
      success : function(res) {
        if(res.success == true) {
          toastr_msg('success', res.msg);
          $('#add-product-modal').modal('hide');
          table.draw();
        } else {
          var flag = 0;
          if(typeof res.msg === "object"){
            for (var key in res.msg) {
              if (flag == 0) {
                var obj = res.msg[key];
                toastr_msg('warning', obj.toString());
              }
              flag++;
            };
          }else{
            toastr_msg('warning', res.msg.toString());
          }

        }
        hide_loading();
      },
      error: function(jqXHR) {
        console.log(jqXHR);
      }
    });
  }
</script>