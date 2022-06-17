@extends('layouts/contentLayoutMaster')

@section('title', 'Business List')

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
  <!-- <button type="button" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i>&nbsp;&nbsp;Add Business</button> -->
  <a href="{{ route('businesses.create') }}" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i> Add Business</a>
  <!-- list and filter start -->
  <div class="card">
    <div class="card-header border-bottom p-1">
      <div class="head-label">
        <h6 class="mb-0">BUSINESS LIST</h6>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table" id="business_users_table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th style="width: 15%;">Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Updated By</th>
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
  <script src="{{ asset('public/js/scripts/extensions/business-user.js') }}"></script>
  <script type="text/javascript">
    var base_url = '{{ url("/") }}';
  </script>
@endsection
