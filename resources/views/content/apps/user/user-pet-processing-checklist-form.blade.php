
@extends('layouts/contentLayoutMaster')

@section('title', 'Pet Processing')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/toastr.min.css') }}">
@endsection
@section('page-style')
  <link rel="stylesheet" href="{{ asset('public/css/base/plugins/extensions/ext-component-toastr.css') }}">
  <style type="text/css">
    .list-group li:hover {
      transform: translateY(-4px);
      box-shadow: 0 3px 10px 0 #ebe9f1;
      transition: all 0.2s;
    }
    .list-group, .form-check, .form-check-input{
      cursor: pointer;
    }
    .text-nowrap.text-muted{
      margin-left: 20px;
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
<div class="alert alert-success mt-1 alert-validation-msg success-error" role="alert" style="display: none;">
  <div class="alert-body d-flex align-items-center">
    <span></span>
  </div>
</div>
<!-- Basic ListGroups start -->
<section id="basic-list-group">
  <div class="row match-height">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-body py-2 my-25">
          <!-- header section -->
          <div class="d-flex">
            <a href="#" class="me-25">
              @if($pet_processing->customer != null && $pet_processing->customer->profile_image != null)
                <img
                  src="{{asset('public/images/user_profiles/'.$pet_processing->customer->profile_image)}}"
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
            </a>
            <div class="info-container">
              <ul class="list-unstyled">
                <li class="mb-50">
                  <span class="fw-bolder me-25">{{ ($pet_processing->customer != null) ? $pet_processing->customer->name.' '.$pet_processing->customer->lname : "N/A" }}</span>
                </li>
                <li class="mb-50">
                  <span>{{ ($pet_processing->customer != null) ? $pet_processing->customer->email : "N/A" }}</span>
                </li>
              </ul>
              <div class="d-flex">
                <a href="{{ route('customers.edit',[$pet_processing->customer->id]) }}" class="btn btn-primary me-1 waves-effect waves-float waves-light">
                  Edit
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-12">
              </div>
              <div class="col-xl-7 col-12">
                <dl class="row mb-0">
                  <dt class="col-sm-5 fw-bolder"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>&nbsp;&nbsp;Pet name</dt>
                  <dd class="col-sm-7">{{ isset($pet_processing->pet_name) ? $pet_processing->pet_name : "N/A" }}</dd>
                  <dt class="col-sm-5 fw-bolder"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>&nbsp;&nbsp;Status</dt>
                  @if(count($processing_status) > 0)
                    @foreach($processing_status as $key => $status)
                      @if($key == $pet_processing->pet_status)
                        <dd class="col-sm-7">{{ $status }}</dd>
                      @endif
                    @endforeach
                  @endif
                  <dt class="col-sm-5 fw-bolder"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>&nbsp;&nbsp;Contact</dt>
                  <dd class="col-sm-7">{{ ($pet_processing->customer != null) ? $pet_processing->customer->phone : "N/A" }}</dd>
                </dl>
              </div>
            </div>
            <!--/ upload and reset button -->
          </div>
          <!--/ header section -->
        </div>
      </div>
      {{--@include('content.apps.user.user-pet-processing-checklist-form-content')--}}
      <div class="pet-processing">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Processing Checklist</h4>
          </div>
          <div class="card-body">
            <form class="validate-form" enctype="multipart/form-data" method="POST" action="{{ route('update-pet-processing',[$pet_processing->id]) }}" id="pet_processing_form">
              @csrf
              <div class="row">
                <div class="mb-1 col-md-6">
                  @if(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4)
                    <label class="form-label" for="phone">Processing Status</label>
                    <select class="form-control" name="pet_status" id="pet_status">
                      <option value="">Select Processing Status</option>
                      @if(count($processing_status) > 0)
                        @foreach($processing_status as $key => $status)
                          {{ $key }}
                          <option value="{{ $key }}" {{ (old('pet_status',$pet_processing->pet_status) == $key) ? "selected" : "" }}>{{ $status }}</option>
                        @endforeach
                      @endif
                    </select>
                  @endif
                </div>
              </div>
              @if(count($processing_checklist) > 0)
                <label class="form-label">Processing list</label>
                @php $process_arr = array(); $i = 0; @endphp
                <ul class="list-group">
                  @foreach($processing_checklist as $key => $checklist)
                    <li class="list-group-item d-flex align-items-center">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="processing_checklist[]" id="additional_items_{{ $i }}" data-id="{{ $checklist }}" value="{{ $i }}" 
                          @if(!empty($process_list))
                            @foreach($process_list as $process)
                              @if($i == $process->id)
                                {{ "checked" }}
                              @endif
                            @endforeach
                          @endif>
                        <label class="form-check-label" for="additional_items_{{ $i }}">{{ $checklist }}</label>
                      </div>
                      @if(!empty($process_list))
                        @foreach($process_list as $process)
                          @php
                            $process_arr[] = $process->id;
                          @endphp
                        @endforeach
                        @if(in_array($i, $process_arr))
                          <span class="badge bg-success rounded-pill ms-auto">Completed</span>
                          @foreach($process_list as $process)
                            @if($i == $process->id)
                              <span class="text-nowrap text-muted">{{ isset($process->date) ? \Carbon\Carbon::parse($process->date)->format('F j') : '-' }}</span>
                            @endif
                          @endforeach
                        @else
                          <span class="badge bg-danger rounded-pill ms-auto">Not Completed</span>
                        @endif
                      @else
                        <span class="badge bg-danger rounded-pill ms-auto">Not Completed</span>
                      @endif
                    </li>
                    @php $i++; @endphp
                  @endforeach
                </ul>
                <span class="text-danger">{{ $errors->first('processing_checklist') }}</span>
              @endif
              <div class="col-12 mt-2 text-md-end">
                <button type="button" class="btn btn-primary me-1 waves-effect waves-float waves-light" onclick="savePetProcessing();">Submit</button>
                <a href="{{ route('pet-processing') }}" class="btn btn-danger waves-effect">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Basic ListGroups end -->
@endsection
@section('vendor-script')
  <script src="{{ asset('public/vendors/js/extensions/toastr.min.js') }}"></script>
@endsection
@section('page-script')
<script type="text/javascript">
  var isRtl = $('html').attr('data-textdirection') === 'rtl', progressBar = $('#progress-bar');
  // Success Type
  function savePetProcessing() {
    var processing_status = $("#pet_status").val();
    var checkValues = $("input[name='processing_checklist[]']:checked").map(function(){
      return $(this).val();
    }).get();
    var token = $('input[name="_token"]').val();
    $.ajax({
      url: '{{ url("/") }}' + '/admin/update-pet-processing/' + '{{ $pet_processing->id }}',
      type: "POST",
      data : {
        "processing_status": processing_status,
        "processing_checklist": checkValues
      },
      headers:
      {
        'X-CSRF-Token': token
      },
      success: function(response){
        if(response.status == 1){
          $(".pet-processing").html(response.data);
            toastr['success'](response.success, 'Pet Processing', {
              closeButton: true,
              tapToDismiss: false,
              progressBar: true,
              rtl: isRtl
            });
        }
      },
      error: function(){

      }
    });
  }
  var url = '{{ route("pet-processing") }}';
  $(document).on("click",".form-check-input",function() {
    savePetProcessing();
  })
</script>
@endsection