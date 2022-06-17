@extends('layouts/fullLayoutMaster')

@section('title', 'Register User')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
  <style type="text/css">
    div.flatpickr-basic.flatpickr-input {
      text-align: right;
      margin-top: -31px;
      margin-right: 7px;
      position: inherit;
      right: 0;
      z-index: 0;
    }
  </style>
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
    <!-- Brand logo-->
    <a class="brand-logo" href="#">
      <img src="{{ asset('public/images/main-logo.png') }}">
    </a>
    <!-- /Brand logo-->
    <!-- Left Text-->
    <div class="col-lg-3 d-none d-lg-flex align-items-center p-0">
      <div class="w-100 d-lg-flex align-items-center justify-content-center">
        <img
          class="img-fluid w-100"
          src="{{asset('public/images/illustration/create-account.svg')}}"
          alt="multi-steps"
        />
      </div>
    </div>
    <!-- /Left Text-->

    <!-- Register-->
    <div class="col-lg-9 d-flex align-items-center auth-bg px-2 px-sm-3 px-lg-5 pt-3">
      <div class="width-700 mx-auto">
        <div class="bs-stepper register-multi-steps-wizard shadow-none">
          <div class="bs-stepper-header px-0" role="tablist">
            <div class="step" data-target="#account-details" role="tab" id="account-details-trigger">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                  <i data-feather="home" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Account Info</span>
                </span>
              </button>
            </div>
            <div class="line">
              <i data-feather="chevron-right" class="font-medium-2"></i>
            </div>
            <div class="step" data-target="#personal-info" role="tab" id="personal-info-trigger">
              <button type="button" class="step-trigger">
                <span class="bs-stepper-box">
                  <i data-feather="user" class="font-medium-3"></i>
                </span>
                <span class="bs-stepper-label">
                  <span class="bs-stepper-title">Pet Info</span>
                </span>
              </button>
            </div>
          </div>
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
          <form method="POST" action="{{ route('user.store') }}">
          @csrf
            <div class="bs-stepper-content px-0">
              <div id="account-details" class="content" role="tabpanel" aria-labelledby="account-details-trigger">
                <div class="content-header mb-2">
                  <h2 class="fw-bolder mb-75">Account Information</h2>
                  <span>Enter your personal details</span>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="fname">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="fname" id="fname" class="form-control" placeholder="johndoe" value="{{ old('fname') }}" />
                    <span class="text-danger">{{ $errors->first('fname') }}</span>
                  </div>
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="lname">Last Name <span class="text-danger">*</span></label>
                    <input
                      type="lname"
                      name="lname"
                      id="lname"
                      class="form-control"
                      placeholder="john.doe@email.com"
                      aria-label="john.doe"
                      value="{{ old('lname') }}"
                    />
                    <span class="text-danger">{{ $errors->first('lname') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="123456789" value="{{ old('phone') }}" />
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                  </div>
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                    <input
                      type="email"
                      name="email"
                      id="email"
                      class="form-control"
                      placeholder="john.doe@email.com"
                      aria-label="john.doe"
                      value="{{ old('email') }}"
                    />
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="address">Street</label>
                    <input
                      type="text"
                      name="address"
                      id="address"
                      class="form-control"
                      placeholder="1234 Your Street"
                      value="{{ old('address') }}"
                    />
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="city">City</label>
                    <select class="form-control" name="city">
                      <option value="">Select City</option>
                      @if(count($cities) > 0)
                        @foreach($cities as $key => $city)
                          <option value="{{ $key }}" {{ (old('city') == $key) ? "selected" : "" }}>{{ $city }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="state">State</label>
                    <select class="form-control" name="state">
                      <option value="">Select State</option>
                      @if(count($states) > 0)
                        @foreach($states as $key => $state)
                          <option value="{{ $key }}" {{ (old('state') == $key) ? "selected" : "" }}>{{ $state }}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="zipcode">Zipcode</label>
                    <input
                      type="text"
                      name="zipcode"
                      id="zipcode"
                      class="form-control"
                      placeholder="485962"
                      value="{{ old('zipcode') }}"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      />
                      <span class="input-group-text cursor-pointer"><i data-feather="eye-off"></i></span>
                    </div>
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                  </div>
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input
                        type="password"
                        name="confirm_password"
                        id="confirm_password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      />
                      <span class="input-group-text cursor-pointer"><i data-feather="eye-off"></i></span>
                    </div>
                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                  </div>
                </div>
                <div class="row">
                </div>
                <div class="d-flex justify-content-end">
                  <button type="button" class="btn btn-primary btn-next">
                    <span class="align-middle d-sm-inline-block d-none">Next</span>
                    <i data-feather="chevron-right" class="align-middle ms-sm-25 ms-0"></i>
                  </button>
                </div>
              </div>
              <div id="personal-info" class="content" role="tabpanel" aria-labelledby="personal-info-trigger">
                <div class="content-header mb-2">
                  <h2 class="fw-bolder mb-75">Pet Information</h2>
                  <span>Enter your Information</span>
                </div>
                <div class="row">
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="pet_type">Pet Type <span class="text-danger">*</span></label>
                    <select class="form-control" name="pet_type">
                      <option value="">Select Pet Type</option>
                      @if(count($pet_types) > 0)
                        @foreach($pet_types as $key => $type)
                          <option value="{{ $key }}">{{ $type }}</option>
                        @endforeach
                      @endif
                    </select>
                    <span class="text-danger">{{ $errors->first('pet_type') }}</span>
                  </div>
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="gender">Pet Gender <span class="text-danger">*</span></label>
                    <select class="form-control" name="gender">
                      @if(count($gender) > 0)
                        @foreach($gender as $key => $gen)
                          <option value="{{ $key }}" {{ (old('gender') == $key) ? "selected" : "" }}>{{ $gen }}</option>
                        @endforeach
                      @endif
                    </select>
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                  </div>
                  <div class="col-md-6 mb-1">
                    <label class="form-label" for="pet_name">Pet Name <span class="text-danger">*</span></label>
                    <input type="text" id="pet_name" name="pet_name" class="form-control" placeholder="Daizy" value="{{ old('pet_name') }}" />
                    <span class="text-danger">{{ $errors->first('pet_name') }}</span>
                  </div>
                  <div class="col-md-3 mb-1">
                    <label class="form-label" for="age">Age <span class="text-danger">*</span></label>
                    <input
                      type="age"
                      id="age"
                      name="age"
                      class="form-control"
                      placeholder="10"
                      aria-label="john.doe"
                      value="{{ old('age') }}"
                    />
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                  </div>
                  <div class="col-md-3 mb-1">
                    <label class="form-label" for="weight">Weight <span class="text-danger">*</span></label>
                    <input
                      type="weight"
                      id="weight"
                      name="weight"
                      class="form-control"
                      placeholder="Weight"
                      aria-label="john.doe"
                      value="{{ old('weight') }}"
                    />
                    <span class="text-danger">{{ $errors->first('weight') }}</span>
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="date_of_birth">Date of Death <span class="text-danger">*</span></label>
                    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ old('date_of_birth') }}" />
                    <div class="flatpickr-basic">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div class="error" id="date_of_birth-error"></div>
                    <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
                  </div>
                  <div class="mb-1 col-md-6">
                    <label class="form-label" for="breed_and_color">Pet Breed/Color <span class="text-danger">*</span></label>
                    <input type="text" id="breed_and_color" name="breed_and_color" class="form-control" placeholder="Enter Breed and Color" value="{{ old('breed_and_color') }}" />
                    <span class="text-danger">{{ $errors->first('breed_and_color') }}</span>
                  </div>
                  <div class="mb-1 col-md-12">
                    <label class="form-label" for="additional_pet_info">Additional Pet Description</label>
                    <input type="text" id="additional_pet_info" name="additional_pet_info" class="form-control" placeholder="Lebra Black" value="{{ old('additional_pet_info') }}" />
                  </div>
                  <div class="mb-1 col-md-12">
                    <label class="form-label" for="special_info">Special Instructions</label>
                    <textarea rows="3" id="special_info" name="special_info" class="form-control" placeholder="Enter any special instructions">{{ old('special_info') }}</textarea>
                  </div>
                </div>
                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-primary btn-prev">
                    <i data-feather="chevron-left" class="align-middle me-sm-25 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                  </button>
                  <button type="submit" class="btn btn-success btn-next">
                    <span class="align-middle d-sm-inline-block d-none">Submit</span>
                    <i data-feather="check" class="align-middle ms-sm-25 ms-0"></i>
                  </button>
                </div>
                <!-- <div class="d-flex justify-content-between mt-1">
                  <button class="btn btn-primary btn-prev">
                    <i data-feather="chevron-left" class="align-middle me-sm-25 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                  </button>
                  <button class="btn btn-success btn-submit" type="submit">
                    <i data-feather="check" class="align-middle me-sm-25 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Submit</span>
                  </button>
                </div> -->
              </div>
            </div>
          </form>
          <p class="text-center mb-1">
            <span>Already Registered?</span>
            <a href="{{ route('auth-login') }}">
              <span>Sign In</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('public/js/scripts/pages/auth-register.js') }}"></script>
@endsection
