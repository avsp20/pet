
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Pet')

@section('page-style')
<link rel="stylesheet" href="{{ asset('public/css/base/pages/app-ecommerce.css') }}">
<style type="text/css">
  .form-control{
    position: relative;
    z-index: 1;
  }
  div.flatpickr-basic.flatpickr-input {
    text-align: right;
    margin-top: -30px;
    margin-right: 7px;
    position: absolute;
    right: 0;
    z-index: 0;
  }
  .card.ecommerce-card{
    cursor: pointer;
  }
  .ecommerce-application .grid-view.wishlist-items .ecommerce-card .item-img {padding-top: 0;}
  .wishlist-items .labl > input{
    visibility: hidden;
    position: absolute;
  }
  .wishlist-items .labl > input + div{
    cursor:pointer;
    border:1px solid transparent;
  }
  .wishlist-items .labl > input:checked + div{
    border: 1px solid #7367f085;
    box-shadow: 0 1px 10px 0 rgb(115 103 240);
  }
  .urn-title{
    font-weight: 600;
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
<!-- Modern Horizontal Wizard -->
@if(Auth::user()->user_role->role_id == 1)
  <a href="{{ route('generate-certificate',[request()->route('id')]) }}" class="btn btn-primary mb-1">Print Certificate</a>
@endif
<section class="modern-horizontal-wizard">
  <div class="bs-stepper horizontal-wizard-example">
    <div class="bs-stepper-header">
      <div class="step" data-target="#account-details-modern" role="tab" id="account-details-modern-trigger">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="user-plus" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Pet Details</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#personal-info-modern" role="tab" id="personal-info-modern-trigger">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="user" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Memorial Options</span>
          </span>
        </button>
      </div>
      <div class="line">
        <i data-feather="chevron-right" class="font-medium-2"></i>
      </div>
      <div class="step" data-target="#address-step-modern" role="tab" id="address-step-modern-trigger">
        <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            <i data-feather="refresh-cw" class="font-medium-3"></i>
          </span>
          <span class="bs-stepper-label">
            <span class="bs-stepper-title">Pet Processing</span>
          </span>
        </button>
      </div>
    </div>
    <form method="POST" action="{{ route('update-customer-pet',[$pet_info->id]) }}" enctype="multipart/form-data">
      @csrf
      <div class="bs-stepper-content">
        <div id="account-details-modern" class="content" role="tabpanel" aria-labelledby="account-details-modern-trigger">
          <div class="content-header">
            <h5 class="mb-0">Pet Information</h5>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              @if(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4)
                <label class="form-label" for="phone">Processing Status</label>
                <select class="form-control" name="pet_status">
                  <option value="">Select Processing Status</option>
                  @if(count($processing_status) > 0)
                    @foreach($processing_status as $key => $status)
                      <option value="{{ $key }}" @if($pet_info != null) @if(old('pet_status',$pet_info->pet_status) == $key) {{ "selected" }} @endif @endif>{{ $status }}</option>
                    @endforeach
                  @endif
                </select>
              @endif
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="phone">Payment Status <span class="text-danger">*</span></label>
              <select class="form-control" name="payment_status">
                <option value="">Select Payment Status</option>
                @if(count($payment_status) > 0)
                  @foreach($payment_status as $key => $status)
                    <option value="{{ $key }}" @if($pet_info != null) @if(old('payment_status',$pet_info->payment_status) == $key) {{ "selected" }} @endif @endif>{{ $status }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="mb-1 col-md-3">
              <label class="form-label" for="invoice_no">Invoice # </label>
              <input type="text" id="invoice_no" name="invoice_no" class="form-control" placeholder="AMB452EM" value="{{ old('invoice_no',(isset($pet_info) ? $pet_info->invoice_no : "")) }}" />
              <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="location">Location</label>
              <select class="form-control" name="location">
                <option value="0">No Location Specified</option>
                @if(count($locations) > 0)
                  @foreach($locations as $key => $location)
                    <option value="{{ $location->id }}" @if($pet_info != null) @if(old('location',$pet_info->location) == $location->id) {{ "selected" }} @endif @endif>{{ $location->business_name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="tag">Tag#</label>
              <input
                type="tag"
                id="tag"
                name="tag"
                class="form-control"
                placeholder="1234567890"
                aria-label="john.doe"
                value="{{ old('tag',isset($pet_info) ? $pet_info->tag : "") }}"
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="pet_type">Pet Type <span class="text-danger">*</span></label>
              <select class="form-control" name="pet_type">
                <option value="">Select Pet Type</option>
                @if(count($pet_types) > 0)
                  @foreach($pet_types as $key => $type)
                    <option value="{{ $key }}" @if($pet_info != null) @if(old('pet_type',$pet_info->pet_type) == $key) {{ "selected" }} @endif @endif>{{ $type }}</option>
                  @endforeach
                @endif
              </select>
              <span class="text-danger">{{ $errors->first('pet_type') }}</span>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="gender">Pet Gender <span class="text-danger">*</span></label>
              <select class="form-control" name="gender">
                @if(count($gender) > 0)
                  @foreach($gender as $key => $gen)
                    <option value="{{ $key }}" @if($pet_info != null) @if(old('gender',$pet_info->gender) == $key) {{ "selected" }} @endif @endif>{{ $gen }}</option>
                  @endforeach
                @endif
              </select>
              <span class="text-danger">{{ $errors->first('gender') }}</span>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="pet_name">Pet Name <span class="text-danger">*</span></label>
              <input type="text" id="pet_name" name="pet_name" class="form-control" placeholder="Daizy" value="{{ old('pet_name',isset($pet_info) ? $pet_info->pet_name : "") }}" />
              <span class="text-danger">{{ $errors->first('pet_name') }}</span>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="age">Age <span class="text-danger">*</span></label>
              <input
                type="age"
                id="age"
                name="age"
                class="form-control"
                placeholder="10"
                aria-label="john.doe"
                value="{{ old('age',isset($pet_info) ? $pet_info->age : "") }}"
              />
              <span class="text-danger">{{ $errors->first('age') }}</span>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="weight">Weight <span class="text-danger">*</span></label>
              <input
                type="weight"
                id="weight"
                name="weight"
                class="form-control"
                placeholder="Weight"
                aria-label="john.doe"
                value="{{ old('weight',isset($pet_info) ? $pet_info->weight : "") }}"
              />
              <span class="text-danger">{{ $errors->first('weight') }}</span>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="date_of_birth">Date of Death <span class="text-danger">*</span></label>
              <input type="text" id="date_of_birth" name="date_of_birth" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ old('date_of_birth',isset($pet_info) ? $pet_info->date_of_birth : "") }}" />
              <div class="flatpickr-basic">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
              <div class="error" id="date_of_birth-error"></div>
            </div>
            <span class="text-danger">{{ $errors->first('date_of_birth') }}</span>
          </div>
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="breed_and_color">Pet Breed/Color <span class="text-danger">*</span></label>
              <input type="text" id="breed_and_color" name="breed_and_color" class="form-control" placeholder="Enter Breed and Color" value="{{ old('breed_and_color',isset($pet_info) ? $pet_info->breed_and_color : "") }}" />
              <span class="text-danger">{{ $errors->first('breed_and_color') }}</span>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="date_received">Date Received</label>
                <input type="text" id="date_received" name="date_received" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ old('date_received',isset($pet_info) ? $pet_info->date_received : "") }}" />
              <div class="flatpickr-basic">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="date_cremated">Date Cremated</label>
              <input type="text" id="date_cremated" name="date_cremated" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ old('date_cremated',isset($pet_info) ? $pet_info->date_cremated : "") }}" />
              <div class="flatpickr-basic">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
            </div>
            <div class="mb-1 col-md-2">
              <label class="form-label" for="date_delivered">Date Delivered</label>
              <input type="text" id="date_delivered" name="date_delivered" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" value="{{ old('date_delivered',isset($pet_info) ? $pet_info->date_delivered : "") }}" />
              <div class="flatpickr-basic">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col-md-12">
              <label class="form-label" for="additional_pet_info">Additional Pet Description</label>
              <input type="text" id="additional_pet_info" name="additional_pet_info" class="form-control" placeholder="Lebra Black" value="{{ old('additional_pet_info',isset($pet_info) ? $pet_info->additional_pet_info : "") }}" />
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
              <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button type="button" class="btn btn-primary btn-next">
              <span class="align-middle d-sm-inline-block d-none">Next</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
        <div id="personal-info-modern" class="content" role="tabpanel" aria-labelledby="personal-info-modern-trigger">
          <div class="content-header">
            <h5 class="mb-0"></h5>
          </div>
          <div class="row">
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="cremation_type">Cremation Type</label>
              <select class="form-control" name="cremation_type">
                <option value="">Select Cremation Type</option>
                @if(count($cremation_type) > 0)
                  @foreach($cremation_type as $key => $type)
                    <option value="{{ $key }}" @if($pet_info != null) @if(old('cremation_type',$pet_info->cremation_type) == $key) {{ "selected" }} @endif @endif>{{ $type }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="frame_color">Complimentary Frame</label>
              <select class="form-control" name="frame_color">
                <option value="">Select Frame</option>
                @if(count($frame_color_type) > 0)
                  @foreach($frame_color_type as $key => $color_type)
                    <option value="{{ $key }}" @if($pet_info != null) @if(old('frame_color',$pet_info->frame_color) == $key) {{ "selected" }} @endif @endif>{{ $color_type }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="row">
            <label class="form-label">Urn Choice Details</label>
            @if(count($urn_details) > 0)
              @php $i = 0; @endphp
              @foreach(array_chunk($urn_details,3) as $urn_detail)
                <div class="mb-1 col-md-2">
                  @foreach($urn_detail as $key => $detail)
                    <div class="form-check form-check-primary my-50">
                      <input type="checkbox" class="form-check-input" name="urn_details[]" id="urn_details_{{ $i }}" value="{{ $i }}" @if($pet_info != null)
                  @php
                    $urn_details = explode(", ",$pet_info->urn_details);
                  @endphp
                  @if(in_array($i, $urn_details))
                    {{ "checked" }}
                  @endif
                @endif>
                      <label class="form-check-label" for="urn_details_{{ $i }}">{{ $detail }}</label>
                    </div>
                    @php $i++; @endphp
                  @endforeach
                </div>
              @endforeach
            @endif
          </div>
          <div class="row">
            <label class="form-label">Additional Items</label>
            <section id="wishlist" class="grid-view wishlist-items">
              @if(count($urn_display) > 0)
              @php $i = 0; @endphp
                @foreach($urn_display as $urn)
                <label class="labl" for="additional_items_{{ $i }}">
                <input type="checkbox" name="additional_items[]" id="additional_items_{{ $i }}" value="{{ $i }}" @if($pet_info != null)
                  @php
                    $additional_items = explode(", ",$pet_info->additional_items);
                  @endphp
                  @if(in_array($i, $additional_items))
                    {{ "fhgkjh" }}
                    {{ "checked" }}
                  @endif
                @endif/>
                    <div class="card ecommerce-card">
                      <div class="item-img text-center">
                          @if($urn->image != null)
                            <img src="{{ asset('public/images/urns/'.$urn->image) }}" class="img-fluid" alt="img-placeholder">
                          @else
                            <img src="{{ asset('public/images/no-image-available.png') }}" class="img-fluid" alt="img-placeholder">
                          @endif
                      </div>
                      <div class="card-body">
                        <div class="item-name">
                          <span class="urn-title">{{ $urn->title }}</span>
                        </div>
                        <p class="card-text item-description">
                          {!! $urn->content !!}
                        </p>
                      </div>
                    </div>
                 </label>
                  @php $i++; @endphp
                @endforeach
              @endif
            </section>
            {{--@if(count($pet_additional_items) > 0)
            @php $i = 0; @endphp
              @foreach(array_chunk($pet_additional_items,8) as $additional_item)
                <div class="mb-1 col-md-4">
                  @foreach($additional_item as $key => $item)
                    <div class="form-check form-check-primary my-50">
                      <input type="checkbox" class="form-check-input" name="additional_items[]" id="additional_items_{{ $i }}" value="{{ $i }}" @if($pet_info != null)
                  @php
                    $additional_items = explode(", ",$pet_info->additional_items);
                  @endphp
                  @if(in_array($i, $additional_items))
                    {{ "checked" }}
                  @endif
                @endif>
                      <label class="form-check-label" for="additional_items_{{ $i }}">{{ $item }}</label>
                    </div>
                    @php $i++; @endphp
                  @endforeach
                </div>
              @endforeach
            @endif--}}
          </div>
          <div class="row">
            <div class="mb-1 col-md-12">
              <label class="form-label" for="special_info">Special Instructions</label>
              <textarea rows="3" id="special_info" name="special_info" class="form-control" placeholder="Enter any special instructions">{{ old('special_info',isset($pet_info) ? $pet_info->special_info : "") }}</textarea>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary btn-prev">
              <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button type="button" class="btn btn-primary btn-next">
              <span class="align-middle d-sm-inline-block d-none">Next</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
        <div id="address-step-modern" class="content" role="tabpanel" aria-labelledby="address-step-modern-trigger">
          <div class="content-header">
            <h5 class="mb-0">Processing Checklist</h5>
          </div>
          <div class="row">
            @if(count($processing_checklist) > 0)
              @php $process_arr = array(); $i = 0; @endphp
                <div class="mb-1 col-md-4">
                  @foreach($processing_checklist as $key => $checklist)
                    @if(!empty($pet_info->processing_checklist))
                      @php
                        $process_list = json_decode($pet_info->processing_checklist);
                      @endphp
                    @endif
                    <div class="form-check form-check-primary my-50">
                      <input type="checkbox" class="form-check-input" name="processing_checklist[]" id="processing_checklist_{{ $i }}" value="{{ $i }}" @if(!empty($pet_info->processing_checklist))
                        @if(count($process_list) > 0)
                          @foreach($process_list as $process)
                            @if($i == $process->id)
                              {{ "checked" }}
                            @endif
                          @endforeach
                        @endif
                      @endif>
                      <label class="form-check-label" for="processing_checklist_{{ $i }}">{{ $checklist }}</label>
                    </div>
                    @php $i++; @endphp
                  @endforeach
                </div>
            @endif
            {{--@if(count($processing_checklist) > 0)
              @php $i = 0; @endphp
              @foreach(array_chunk($processing_checklist,4) as $process_checklist)
                <div class="mb-1 col-md-4">
                  @foreach($process_checklist as $key => $checklist)
                    <div class="form-check form-check-primary my-50">
                      <input type="checkbox" class="form-check-input" name="processing_checklist[]" id="processing_checklist_{{ $i }}" value="{{ $i }}" @if($pet_info != null)
                  @php
                    $processing_checklist = explode(", ",$pet_info->processing_checklist);
                  @endphp
                  @if(in_array($i, $processing_checklist))
                    {{ "checked" }}
                  @endif
                @endif>
                      <label class="form-check-label" for="processing_checklist_{{ $i }}">{{ $checklist }}</label>
                    </div>
                    @php $i++; @endphp
                  @endforeach
                </div>
              @endforeach
            @endif--}}
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary btn-prev">
              <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button type="submit" class="btn btn-primary btn-next">
              <span class="align-middle d-sm-inline-block d-none">Submit</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- /Modern Horizontal Wizard -->
@endsection
@section('page-script')
<script src="{{ asset('public/js/custom.js') }}"></script>
@endsection