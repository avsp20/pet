@extends('layouts/contentLayoutMaster')

@section('title', 'Pet Processing')

@section('content')
@if (session('success'))
  <div class="alert alert-success mt-1 alert-validation-msg" role="alert">
    <div class="alert-body d-flex align-items-center">
      <span>{{ session('success') }}</span>
    </div>
  </div>
@endif
@if (session('error'))
  <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
    <div class="alert-body d-flex align-items-center">
      <span>{{ session('error') }}</span>
    </div>
  </div>
@endif
<!-- users list start -->
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-header border-bottom p-1">
      <div class="head-label">
        <h6 class="mb-0">PETS LIST</h6>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table" id="customers_table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Pet Name</th>
            <th>Date Of Cremation</th>
            <th>Pet Type</th>
            <th>Pet Status</th>
            <th>Created Date</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->
@endsection

@section('page-script')
  <script type="text/javascript">
    var base_url = '{{ url("/") }}';
    $(function () {
      var customers_table = $('#customers_table').DataTable({
        destroy: true,  
        processing: true,
        serverSide: true,
        ajax: window.location.href,
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'pet_name', name: 'pet_name' },
          {data: 'date_cremated', name: 'date_cremated' },
          {data: 'pet_type', name: 'pet_type' },
          {data: 'pet_status', name: 'pet_status' },
          {data: 'created_at', name: 'created_at' },
          {data: 'action', name: 'action' },
        ]
      });
    });
  </script>
@endsection
