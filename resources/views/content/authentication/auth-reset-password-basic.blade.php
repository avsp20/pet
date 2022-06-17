@extends('layouts/fullLayoutMaster')

@section('title', 'Reset Password')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Reset Password basic -->
    <div class="card mb-0">
      <div class="card-body">
        <img src="{{ asset('public/images/main-logo.png') }}" class="brand-logo">
        <h4 class="card-title mb-1">Reset Password 🔒</h4>
        <p class="card-text mb-2">Your new password must be different from previously used passwords</p>

        <form class="auth-reset-password-form mt-2" method="POST" action="{{ route('auth-reset-password-update') }}">
          @csrf
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
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="password">New Password <span class="text-danger">*</span></label>
            </div>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="password"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password"
                tabindex="1"
                autofocus
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
            <span class="text-danger">{{ $errors->first('password') }}</span>
          </div>
          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="confirm_password"
                name="confirm_password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="confirm_password"
                tabindex="2"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
          </div>
          <button class="btn btn-primary w-100" tabindex="3">Set New Password</button>
        </form>

        <p class="text-center mt-2">
          <a href="{{ route('auth-login') }}"> <i data-feather="chevron-left"></i> Back to login </a>
        </p>
      </div>
    </div>
    <!-- /Reset Password basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('public/js/scripts/pages/auth-reset-password.js') }}"></script>
@endsection
