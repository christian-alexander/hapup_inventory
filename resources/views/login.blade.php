@extends('layout.main_layout')

@section('content')
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-3 col-md-6">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user" action="javascript:;" id="login-form" onsubmit="login()">
                    <div class="form-group">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary btn-block">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function login(){
      var inputData = new FormData($("#login-form")[0]);
      $.ajax({
        url         : "{{ url('/login') }}",
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

            // redirect
            setTimeout(() => {
              location = "{{ url('/') }}";
            }, 2000);
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
@endsection