@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Forgot Password')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="#">
    </a>
    <!-- /Brand logo-->

    <!-- Left Text-->
    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
      <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
        @if($configData['theme'] === 'dark')
        <img class="img-fluid" src="{{asset('public/images/pages/forgot-password-v2-dark.svg')}}" alt="Forgot password V2" />
        @else
        <img class="img-fluid" src="{{asset('public/images/banner-img.jpg')}}" style="opacity: 0.55" alt="Login V2" />
        @endif
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Forgot password-->
    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <h3 class="card-title fw-bold mb-1">
          <img src="{{ asset('public/images/main-logo.png') }}" class="">
          Forgot Password? 🔒
        </h3>
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
            <label class="form-label" for="forgot-password-email">Email</label>
            <input class="form-control" id="forgot-password-email" type="text" name="email" placeholder="john@example.com" aria-describedby="forgot-password-email" autofocus="" tabindex="1" />
            <span class="text-danger">{{ $errors->first('email') }}</span>
          </div>
          <button class="btn btn-primary w-100" tabindex="2" type="submit">Send reset link</button>
        </form>
        <p class="text-center mt-2">
          <a href="{{ route('auth-login') }}">
            <i data-feather="chevron-left"></i> Back to login
          </a>
        </p>
      </div>
    </div>
    <!-- /Forgot password-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
<script src="{{asset('public/js/scripts/pages/auth-forgot-password.js') }}"></script>
@endsection
