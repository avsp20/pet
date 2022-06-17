@extends('layouts/contentLayoutMaster')

@section('title', 'Create User')

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
    <!-- profile -->
    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">User Details</h4>
      </div>
      <div class="card-body py-2 my-25">
        <!-- form -->
        <form class="validate-form" enctype="multipart/form-data" method="POST" action="{{ route('users.store') }}">
          @csrf
          <!-- header section -->
          <div class="d-flex mb-2">
            <a href="#" class="me-25">
              <img
                src="{{asset('public/images/no-user.png')}}"
                id="account-upload-img"
                class="uploadedAvatar rounded me-50"
                alt="profile image"
                height="100"
                width="100"
              />
            </a>
            <!-- upload and reset button -->
            <div class="d-flex align-items-end mt-75 ms-1">
              <div>
                <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                <input type="file" id="account-upload" name="profile_image" hidden accept="image/*" />
                <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
              </div>
            </div>
            <!--/ upload and reset button -->
          </div>
          <!--/ header section -->

          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="first_name">Contact First Name <span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control"
                id="first_name"
                name="name"
                placeholder="John"
                value="{{ old('name') }}"
                data-msg="Please enter first name"
              />
              <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="last_name">Contact Last Name <span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control"
                id="last_name"
                name="lname"
                placeholder="Doe"
                value="{{ old('lname') }}"
                data-msg="Please enter last name"
              />
              <span class="text-danger">{{ $errors->first('lname') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                placeholder="Email"
                data-msg="Please enter email"
                value="{{ old('email') }}"
              />
              <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
              <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Password"
                data-msg="Please enter password"
                value="{{ old('password') }}"
              />
              <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control account-number-mask"
                id="phone"
                name="phone"
                placeholder="Phone Number"
                data-msg="Please enter phone number"
                value="{{ old('phone') }}"
              />
              <span class="text-danger">{{ $errors->first('phone') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="alternate_phone">Alternate Phone Number</label>
              <input
                type="text"
                class="form-control account-number-mask"
                id="alternate_phone"
                name="alternate_phone"
                placeholder="Phone Number"
                value="{{ old('alternate_phone') }}"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="street">Street</label>
              <input type="text" class="form-control" id="street" name="street" value="{{ old('street') }}" placeholder="Your Street" />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="accountCity">City</label>
              <select class="form-control" name="city">
                <option value="">Select City</option>
                @if(count($cities) > 0)
                  @foreach($cities as $key => $city)
                    <option value="{{ $key }}">{{ $city }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="accountState">State</label>
              <select class="form-control" name="state">
                <option value="">Select State</option>
                @if(count($states) > 0)
                  @foreach($states as $key => $state)
                    <option value="{{ $key }}">{{ $state }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="zipcode">Zip Code</label>
              <input
                type="text"
                class="form-control account-zip-code"
                id="zipcode"
                name="zipcode"
                placeholder="Code"
                maxlength="6"
                value="{{ old('zipcode') }}"
              />
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="">Status</label>
              <select class="form-control" name="status">
                <option value="">Select Status</option>
                <option value="1" {{ (old('status') == 1) ? "selected" : "" }}>Active</option>
                <option value="0" {{ (old('status') == 0) ? "selected" : "" }}>Inactive</option>
              </select>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary mt-1 me-1">Create</button>
              <a href="{{ route('users.index') }}" class="btn btn-danger mt-1 me-1">Cancel</a>
            </div>
          </div>
        </form>
        <!--/ form -->
      </div>
    </div>
    <!--/ profile -->
  </div>
</div>
@endsection
