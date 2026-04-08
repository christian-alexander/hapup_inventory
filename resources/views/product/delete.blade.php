<script>
  function deleteProduct(id){
    
    var confirmed = confirm('Apakah Anda yakin akan menghapus produk ini?');
    if(confirmed){

      var inputData = new FormData();
      inputData.append('_method', 'DELETE');
      inputData.append('id', id); 

      $.ajax({
        url         : "{{ url('/product') }}/" + id,
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
  }
</script>