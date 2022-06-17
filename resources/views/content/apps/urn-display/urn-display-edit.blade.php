@extends('layouts/contentLayoutMaster')

@section('title', 'Edit URN')

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
        <h4 class="card-title">URNs Display Details</h4>
      </div>
      <div class="card-body py-2 my-25">
        <!-- form -->
        <form class="validate-form" enctype="multipart/form-data" method="POST" action="{{ route('urn-display.update', [$urn_display->id]) }}">
          @csrf
          @method('PUT')
          <!-- header section -->
          <div class="d-flex mb-2">
            @if($urn_display->image != null)
              <img
                src="{{asset('public/images/urns/'.$urn_display->image)}}"
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
            <!-- upload and reset button -->
            <div class="d-flex align-items-end mt-75 ms-1">
              <div>
                <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                <input type="file" id="account-upload" name="image" hidden accept="image/*" />
                <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
              </div>
            </div>
            <!--/ upload and reset button -->
          </div>
          <!--/ header section -->

          <div class="row">
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control"
                id="title"
                name="title"
                placeholder="John"
                value="{{ old('title', $urn_display->title) }}"
                data-msg="Please enter title"
              />
              <span class="text-danger">{{ $errors->first('title') }}</span>
            </div>
            <div class="col-12 col-sm-6 mb-1">
              <label class="form-label" for="">Status</label>
              <select class="form-control" name="status">
                <option value="">Select Status</option>
                <option value="1" {{ (old('status',$urn_display->status) == 1) ? "selected" : "" }}>Active</option>
                <option value="0" {{ (old('status',$urn_display->status) == 0) ? "selected" : "" }}>Inactive</option>
              </select>
            </div>
            <div class="col-12 col-sm-12 mb-1">
              <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
              <textarea class="form-control" rows="5" name="content" id="content">{!! $urn_display->content !!}</textarea>
              <span class="text-danger">{{ $errors->first('content') }}</span>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary mt-1 me-1">Edit</button>
              <a href="{{ route('urn-display.index') }}" class="btn btn-danger mt-1 me-1">Cancel</a>
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

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('public/js/scripts/ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('public/js/scripts/pages/urns-display.js') }}"></script>
  <script type="text/javascript">
    CKEDITOR.replace('content');
  </script>
@endsection
