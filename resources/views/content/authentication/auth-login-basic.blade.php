@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Login basic -->
    <div class="card mb-0">
      <div class="card-body">
        <img src="{{ asset('public/images/main-logo.png') }}" class="brand-logo">
        <h4 class="card-title mb-1">Welcome to Tracedog! 👋</h4>
        <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>

        <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
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
              autofocus
              value="{{ old('email') }}" />
            <span class="text-danger">{{ $errors->first('email') }}</span>
          </div>

          <div class="mb-1">
            <div class="d-flex justify-content-between">
              <label class="form-label" for="login-password">Password <span class="text-danger">*</span></label>
              <a href="{{ route('auth-forgot-password') }}">
                <small>Forgot Password?</small>
              </a>
            </div>
            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="password"
                name="password"
                tabindex="2"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password"
                value="{{ old('password') }}"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
            <span class="text-danger">{{ $errors->first('password') }}</span>
          </div>
          <div class="mb-1">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
              <label class="form-check-label" for="remember-me"> Remember Me </label>
            </div>
          </div>
          <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
        </form>
        <p class="text-center mt-1 mb-0">
          <span>Register as a customer?</span>
          <a href="{{ route('user-register') }}">
            <span>Sign Up</span>
          </a>
        </p>
      </div>
    </div>
    <!-- /Login basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('public/js/scripts/pages/auth-login.js') }}"></script>
@endsection
