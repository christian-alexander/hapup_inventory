@extends('layout.main_layout')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Produk</h1>
  </div>

  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="table-responsive p-3">
        <table class="table align-items-center table-striped mt-3 mb-3" id="product-table">
          <thead class="thead-light">
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {{-- <tr>
              <td>Espresso</td>
              <td>Espresso</td>
              <td>Espresso</td>
              <td>Espresso</td>
              <td>Espresso</td>
            </tr> --}}
            {{-- serverside --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Initialize DataTable
    var table = $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('product/get_serverside_datatable') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'category_name', name: 'category_name'},
            {data: 'price', name: 'price'},
            {data: 'stock', name: 'stock'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
  </script>

@endsection