@extends('layouts/contentLayoutMaster')

@section('title', 'View User')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel='stylesheet' href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
  <style type="text/css">
    .form-label{
      font-weight: 700;
    }
  </style>
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
<!-- Basic Tables start -->
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">User Details</h4>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Title</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Image</td>
              <td>
                @if($user->profile_image != null)
                <img
                  src="{{asset('public/images/user_profiles/'.$user->profile_image)}}"
                  id="account-upload-img"
                  class="uploadedAvatar rounded me-50"
                  alt="profile image"
                  height="100"
                  width="100"
                />
              @else
                <img
                  src="{{asset('public/images/no-user.png')}}"
                  id="account-upload-img"
                  class="uploadedAvatar rounded me-50"
                  alt="profile image"
                  height="100"
                  width="100"
                />
              @endif
              </td>
            </tr>
            <tr>
              <td>First Name</td>
              <td>{{ ($user->name != null) ? $user->name : "N/A" }}</td>
            </tr>
            <tr>
              <td>Last Name</td>
              <td>{{ ($user->lname != null) ? $user->lname : "N/A" }}</td>
            </tr>
            <tr>
              <td>Email</td>
              <td>{{ ($user->email != null) ? $user->email : "N/A" }}</td>
            </tr>
            <tr>
              <td>Phone</td>
              <td>{{ ($user->phone != null) ? $user->phone : "N/A" }}</td>
            </tr>
            <tr>
              <td>Alternate Phone</td>
              <td>{{ ($user->alternate_phone != null) ? $user->alternate_phone : "N/A" }}</td>
            </tr>
            <tr>
              <td>Address</td>
              <td>{{ ($user->address != null) ? $user->address : "N/A" }}</td>
            </tr>
            <tr>
              <td>City</td>
              <td>{{ ($user->city != null) ? $city : "N/A" }}</td>
            </tr>
            <tr>
              <td>State</td>
              <td>{{ ($user->state != null) ? $state : "N/A" }}</td>
            </tr>
            <tr>
              <td>Zipcode</td>
              <td>{{ ($user->zipcode != null) ? $user->zipcode : "N/A" }}</td>
            </tr>
            <tr>
              <td>Status</td>
              <td>
                @if($user->status == 1)
                  <span class="badge bg-success">Active</span>
                @elseif($user->status == 0)
                  <span class="badge bg-danger">Inactive</span>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-12 mb-1 text-end">
        <a href="{{ route('users.index') }}" class="btn btn-danger mt-1 me-1">Cancel</a>
      </div>
    </div>
  </div>
</div>
<!-- Basic Tables end -->
@endsection
