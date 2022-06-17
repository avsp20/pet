@extends('layouts/fullLayoutMaster')

@section('title', 'Forgot Password')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Forgot Password basic -->
    <div class="card mb-0">
      <div class="card-body">
        <img src="{{ asset('public/images/main-logo.png') }}" class="brand-logo">
        <h4 class="card-title mb-1">Forgot Password? 🔒</h4>
        <p class="card-text mb-2">Enter your email and we'll send you instructions to reset your password</p>

        <form class="auth-forgot-password-form mt-2" action="{{ route('auth-reset-password-email') }}" method="POST">
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
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control"
              id="email"
              name="email"
              placeholder="john@example.com"
              aria-describedby="email"
              tabindex="1"
              value="{{ old('email') }}"
              autofocus
            />
            <span class="text-danger">{{ $errors->first('email') }}</span>
          </div>
          <button class="btn btn-primary w-100" tabindex="2">Send reset link</button>
        </form>

        <p class="text-center mt-2 mb-0">
          <a href="{{ route('auth-login') }}"> <i data-feather="chevron-left"></i> Back to login </a>
        </p>
      </div>
    </div>
    <!-- /Forgot Password basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('public/js/scripts/pages/auth-forgot-password.js') }}"></script>
@endsection
