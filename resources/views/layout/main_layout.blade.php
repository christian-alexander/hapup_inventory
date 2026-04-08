<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>HappyInventory - Happy Puppy Inventory</title>
  <link href="{{ url('assets/ruang-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('assets/ruang-admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ url('assets/ruang-admin/css/ruang-admin.min.css') }}" rel="stylesheet">
  <link href="{{ url('/assets/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

</head>

<body class="bg-gradient-login" id="page-top">
  <div id="version-ruangadmin" class="d-none"></div>
  <script src="{{ url('assets/ruang-admin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('assets/ruang-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('assets/ruang-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ url('assets/jquery-loading-overlay-1.5.4/src/loadingoverlay.min.js') }}"></script>
  <script src="{{ url('assets/bootstrap-toastr/toastr.min.js') }}"></script>
  <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap4.min.js"></script>
  <script>
    function show_loading() {
      $.LoadingOverlay("show");
    }

    function hide_loading() {
      $.LoadingOverlay("hide");
    }

    function toastr_msg(type_, msg_, title_) {
      toastr.options = {
          closeButton: true,
          positionClass: 'toast-top-center',
          onclick: null
      };

      toastr[type_](msg_, title_);
    }

    function rupiah(num) {
      return new Intl.NumberFormat('id-ID').format(num);
    }
  </script>

    <div id="wrapper">
    <!-- Sidebar -->
      @include('layout.menu_bar.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
          @include('layout.menu_bar.top_bar')
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          @yield('content')
        </div>
        <!---Container Fluid-->
      </div>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{ url('assets/ruang-admin/js/ruang-admin.min.js') }}"></script>

</body>

</html>