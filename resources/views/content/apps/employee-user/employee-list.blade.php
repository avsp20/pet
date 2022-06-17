@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

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
  <!-- <button type="button" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i>&nbsp;&nbsp;Add User</button> -->
  <a href="{{ route('users.create') }}" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i> Add User</a>
  <!-- list and filter start -->
  <div class="card">
    <div class="card-header border-bottom p-1">
      <div class="head-label">
        <h6 class="mb-0">USERS LIST</h6>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table" id="users_table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Status</th>
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
  <script src="{{ asset('public/js/scripts/pages/employee-user.js') }}"></script>
  <script type="text/javascript">
    var base_url = '{{ url("/") }}';
  </script>
@endsection
