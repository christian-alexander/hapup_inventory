<div class="modal fade" id="edit-product-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:;" id="edit-product-form" onsubmit="editProduct()">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="id" id="edit-id" value="0">
          <div class="form-group">
            Nama*
            <input type="text" class="form-control" name="name" id="edit-name" placeholder="Nama Produk" required>
          </div>
          <div class="form-group">
            Kategori*
            <select class="form-control mb-3" name="product_category_id" id="edit-product-category-id" required>
              <option value="">Pilih Kategori</option>
              @foreach ($product_category as $pc)
                <option value="{{ $pc->id }}">{{ $pc->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            Harga*
            <div class="position-relative">
              <input type="number" class="form-control" name="price" id="edit-price" placeholder="0" value="0" onkeyup="editItemPricePreview($(this))" onchange="editItemPricePreview($(this))" required>
              <span class="position-absolute font-xs" style="right:30px; top:20%; color:rgba(0,0,0,0.4);" id="edit-product-price-preview">
                {{-- js --}}
              </span>
            </div>
          </div>
          <div class="form-group">
            Stok*
            <input type="number" class="form-control" name="stock" id="edit-stock" placeholder="0" value="1" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
        <button type="submit" class="btn btn-primary" form="edit-product-form"><i class="fa fa-edit"></i> Ubah</button>
      </div>
    </div>
  </div>
</div>

<script>
  function editItemPricePreview(priceInput){
    priceInput.val(parseInt(priceInput.val()));
    $('#edit-product-price-preview').html("(Rp " + rupiah(priceInput.val()) + ")");
  }

  function showEditProductModal(productId){
    $.ajax({
      url         : "{{ url('/product') }}/" + productId,
      type        : 'GET',
      beforeSend: function(){
        show_loading();
      },
      success : function(res) {
        if(res.success == true) {
          // fill data 
          $('#edit-id').val(res.data.id);
          $('#edit-name').val(res.data.name);
          $('#edit-product-category-id').val(res.data.product_category_id);
          $('#edit-price').val(res.data.price);
          $('#edit-stock').val(res.data.stock);

          // show modal
          $('#edit-product-modal').modal('show');
        } else {
          table.draw();
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

  function editProduct(){
    var inputData = new FormData($("#edit-product-form")[0]);
    $.ajax({
      url         : "{{ url('/product') }}/" + $('#edit-id').val(),
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
          $('#edit-product-modal').modal('hide');
          table.draw();
        } else {
          table.draw();
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