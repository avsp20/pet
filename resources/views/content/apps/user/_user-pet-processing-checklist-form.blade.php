@extends('layouts/contentLayoutMaster')

@section('title', 'Pet Processing')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel='stylesheet' href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
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
    <!-- profile -->
    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Processing Checklist</h4>
      </div>
      <div class="card-body py-2 my-25">
        <!-- form -->
        <form class="validate-form" enctype="multipart/form-data" method="POST" action="{{ route('update-pet-processing',[$pet_processing->id]) }}">
          @csrf
          <div class="row">
            @if(count($processing_checklist) > 0)
            @php $i = 0; @endphp
              @foreach(array_chunk($processing_checklist,4) as $process_checklist)
                <div class="mb-1 col-md-4">
                  @foreach($process_checklist as $key => $checklist)
                    <div class="form-check form-check-primary my-50">
                      <input type="checkbox" class="form-check-input" name="processing_checklist[]" id="additional_items_{{ $i }}" value="{{ $i }}" @if($pet_processing != null)
                  @php
                    $process_list = explode(", ",$pet_processing->processing_checklist);
                  @endphp
                  @if(in_array($i, $process_list))
                    {{ "checked" }}
                  @endif
                @endif>
                      <label class="form-check-label" for="additional_items_{{ $i }}">{{ $checklist }}</label>
                    </div>
                    @php $i++; @endphp
                  @endforeach
                </div>
              @endforeach
            @endif
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary mt-1 me-1">Save changes</button>
            <a href="{{ route('pet-processing') }}" class="btn btn-danger mt-1">Cancel</a>
          </div>
        </form>
        <!--/ form -->
      </div>
    </div>
    <!--/ profile -->
  </div>
</div>
@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset('public/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('public/js/scripts/pages/page-account-settings-account.js') }}"></script>
@endsection
