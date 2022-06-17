@extends('layouts/contentLayoutMaster')

@section('title', 'URNs')

@section('page-style')
<style type="text/css">
  .urn-img {
    width: 150px;
    height: 150px;
  }
</style>
@endsection

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endsection

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
  <a href="{{ route('urn-display.create') }}" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i> Add URN</a>
  <!-- list and filter start -->
  <div class="card">
    <div class="card-header border-bottom p-1">
      <div class="head-label">
        <h6 class="mb-0">URNs Display LIST</h6>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table" id="urn_display_table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th style="width: 18%;">Image</th>
            <th>Title</th>
            <th>Status</th>
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
  </script>
  <script src="{{ asset('public/js/scripts/pages/urns-display.js') }}"></script>
@endsection
