@extends('layouts/contentLayoutMaster')

@section('title', 'Security')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
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
<div class="row">
  <div class="col-12">
    <ul class="nav nav-pills mb-2">
      <!-- Account -->
      <li class="nav-item">
        <a class="nav-link" href="{{asset('admin/profile')}}">
          <i data-feather="user" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Account</span>
        </a>
      </li>
      <!-- security -->
      <li class="nav-item">
        <a class="nav-link active" href="{{asset('admin/change-password')}}">
          <i data-feather="lock" class="font-medium-3 me-50"></i>
          <span class="fw-bold">Security</span>
        </a>
      </li>
    </ul>

    <!-- security -->

    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Change Password</h4>
      </div>
      <div class="card-body pt-1">
        <!-- form -->
        <form class="validate-form" action="{{ route('change-password-update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="account-old-password">Current password <span class="text-danger">*</span></label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  id="account-old-password"
                  name="current_password"
                  placeholder="Enter current password"
                  data-msg="Please current password"
                />
                <div class="input-group-text cursor-pointer">
                  <i data-feather="eye"></i>
                </div>
              </div>
              <span class="text-danger">{{ $errors->first('current_password') }}</span>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="account-new-password">New Password <span class="text-danger">*</span></label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  id="account-new-password"
                  name="new_password"
                  class="form-control"
                  placeholder="Enter new password"
                />
                <div class="input-group-text cursor-pointer">
                  <i data-feather="eye"></i>
                </div>
              </div>
              <span class="text-danger">{{ $errors->first('new_password') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="account-retype-new-password">Retype New Password <span class="text-danger">*</span></label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  id="account-retype-new-password"
                  name="confirm_new_password"
                  placeholder="Confirm your new password"
                />
                <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
              </div>
              <span class="text-danger">{{ $errors->first('confirm_new_password') }}</span>
            </div>
            <div class="col-12">
              <p class="fw-bolder">Password requirements:</p>
              <ul class="ps-1 ms-25">
                <li class="mb-50">Minimum 8 characters long - the more, the better</li>
              </ul>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1 mt-1">Save changes</button>
            </div>
          </div>
        </form>
        <!--/ form -->
      </div>
    </div>
    <!--/ security -->
  </div>
</div>

@include('content/_partials/_modals/modal-two-factor-auth')
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/pages/modal-two-factor-auth.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/page-account-settings-security.js')) }}"></script>
@endsection
