
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset('/public/vendors/css/charts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('/public/css/base/plugins/charts/chart-apex.css') }}">
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
<!-- Dashboard Analytics Start -->
@if(Auth::user()->user_role->role_id != 3)
  <section id="dashboard-analytics">
    <div class="row match-height">
      <!-- Subscribers Chart Card starts -->
      <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
          <div class="card-header flex-column align-items-start pb-0">
            <div class="avatar bg-light-primary p-50 m-0">
              <div class="avatar-content">
                <i data-feather="users" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="fw-bolder mt-1">92.6k</h2>
            <p class="card-text">Pickups This Week</p>
          </div>
          <div id="gained-chart"></div>
        </div>
      </div>
      <!-- Subscribers Chart Card ends -->

      <!-- Orders Chart Card starts -->
      <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
          <div class="card-header flex-column align-items-start pb-0">
            <div class="avatar bg-light-warning p-50 m-0">
              <div class="avatar-content">
                <i data-feather="package" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="fw-bolder mt-1">38.4K</h2>
            <p class="card-text">Pickups This Month</p>
          </div>
          <div id="order-chart"></div>
        </div>
      </div>
      <!-- Orders Chart Card ends -->

      <!-- Orders Chart Card starts -->
      <div class="col-lg-4 col-sm-6 col-12">
        <div class="card">
          <div class="card-header flex-column align-items-start pb-0">
            <div class="avatar bg-light-warning p-50 m-0">
              <div class="avatar-content">
                <i data-feather="package" class="font-medium-5"></i>
              </div>
            </div>
            <h2 class="fw-bolder mt-1">38.4K</h2>
            <p class="card-text">Pickups This Month</p>
          </div>
          <div id="pickup-chart"></div>
        </div>
      </div>
      <!-- Orders Chart Card ends -->
    </div>
    <!-- users list start -->
    <section class="app-user-list">
      <div class="card">
        <div class="card-header border-bottom p-1">
          <div class="head-label">
            <h6 class="mb-0">CUSTOMER PET LIST</h6>
          </div>
        </div>
        <div class="card-datatable table-responsive pt-0">
          <table class="user-list-table table" id="customers_table">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Pet Name</th>
                <th>Customer Name</th>
                <th>Date Of Cremation</th>
                <th>Pet Type</th>
                <th>Processing Status</th>
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
  </section>
@endif
<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset('public/vendors/js/charts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('public/vendors/js/extensions/moment.min.js') }}"></script>
@endsection
@section('page-script')
  <script src="{{ asset('/public/js/scripts/pages/dashboard-analytics.js') }}"></script>
  <script type="text/javascript">
    var customers_table = '{{ route("customer-list") }}';
  </script>
@endsection
