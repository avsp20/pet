
@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Customer')

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
{{--@if(Auth::user()->user_role->role_id == 1)
  <a href="{{ route('generate-certificate',[$user->id]) }}" class="btn btn-primary mb-1">Print Certificate</a>
@endif--}}
<div class="row">
  <div class="col-12">
    <!-- profile -->
    <div class="card">
      <div class="card-header border-bottom">
        <h4 class="card-title">Customer Details</h4>
      </div>
      <div class="card-body py-2 my-25">
        <!-- form -->
        <form method="POST" action="{{ route('customers.update',[$user->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="mb-1 col-md-6">
              <label class="form-label" for="fname">Owners First Name <span class="text-danger">*</span></label>
              <input type="text" id="fname" name="fname" class="form-control" placeholder="john" value="{{ old('fname',$user->name) }}" />
              <span class="text-danger">{{ $errors->first('fname') }}</span>
            </div>
            <div class="mb-1 col-md-6">
              <label class="form-label" for="phone">Phone <span class="text-danger">*</span></label>
              <input
                type="phone"
                id="phone"
                name="phone"
                class="form-control"
                placeholder="1234567890"
                aria-label="john.doe"
                value="{{ old('phone',$user->phone) }}"
              />
              <span class="text-danger">{{ $errors->first('phone') }}</span>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="lname">Owners Last Name <span class="text-danger">*</span></label>
              <input
                type="text"
                name="lname"
                id="lname"
                class="form-control"
                placeholder="doe"
                value="{{ old('lname',$user->lname) }}"
              />
              <span class="text-danger">{{ $errors->first('lname') }}</span>
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
              <input
                type="text"
                name="email"
                id="email"
                class="form-control"
                placeholder="johndoe@gmail.com"
                value="{{ old('email',$user->email) }}"
              />
              <span class="text-danger">{{ $errors->first('email') }}</span>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="alternate_phone">Alternate Phone</label>
              <input
                type="text"
                name="alternate_phone"
                id="alternate_phone"
                class="form-control"
                placeholder="1234567890"
                value="{{ old('alternate_phone',$user->alternate_phone) }}"
              />
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="address">Street</label>
              <input
                type="text"
                name="address"
                id="address"
                class="form-control"
                placeholder="California, New York"
                value="{{ old('address',$user->address) }}"
              />
            </div>
          </div>
          <div class="row">
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="city">City</label>
              <select class="form-control" name="city">
                <option value="">Select City</option>
                @if(count($cities) > 0)
                  @foreach($cities as $key => $city)
                    <option value="{{ $key }}" @if(old('city',$user->city) == $key) {{ "selected" }} @endif>{{ $city }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="state">State</label>
              <select class="form-control" name="state">
                <option value="">Select State</option>
                @if(count($states) > 0)
                  @foreach($states as $key => $state)
                    <option value="{{ $key }}" @if(old('state',$user->state) == $key) {{ "selected" }} @endif>{{ $state }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="zipcode">Zipcode</label>
              <input
                type="text"
                name="zipcode"
                id="zipcode"
                class="form-control"
                placeholder="485962"
                value="{{ old('zipcode',$user->zipcode) }}"
              />
            </div>
            <div class="mb-1 form-password-toggle col-md-6">
              <label class="form-label" for="state">Profile Picture</label>
              <div class="d-flex">
                <a href="#" class="me-25">
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
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary mt-1 me-1">Update</button>
              @if(Auth::user()->user_role->role_id != 3)
                <a href="{{ route('customers.index') }}" class="btn btn-danger mt-1">Cancel</a>
              @endif
            </div>
          </div>
        </form>
        <!--/ form -->
      </div>
    </div>
    <!--/ profile -->
  </div>
</div>
@if(Auth::user()->user_role->role_id != 3)
  @php
    $url = "customers-pet-create";
  @endphp
@else
  @php
    $url = "user-pet-create";
  @endphp
@endif
<a href="{{ route($url,[$user->id]) }}" class="btn btn-primary waves-effect waves-float waves-light mb-1"><i data-feather='plus-circle'></i> Add Pet</a>
<!-- users list start -->
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-header border-bottom p-1">
      <div class="head-label">
        <h6 class="mb-0">PETS LIST</h6>
      </div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <table class="user-list-table table" id="customers_pets_table">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Pet Name</th>
            <th>Pet Type</th>
            <th>Breed/Color</th>
            <th>Created Date</th>
            @if(Auth::user()->user_role->role_id != 3)
              <th>Created By</th>
              <th>Updated By</th>
            @endif
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- list and filter end -->
</section>
<!-- users list ends -->
@endsection
@section('page-script')
<script src="{{ asset('public/js/custom.js') }}"></script>
<script type="text/javascript">
  var base_url = '{{ url("/") }}';
  $(function () {
    var customers_pets_table = $('#customers_pets_table').DataTable({
      destroy: true,  
      processing: true,
      serverSide: true,
      ajax: '{{ route("customers-pets",[$user->id]) }}',
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'pet_name', name: 'pet_name' },
        {data: 'pet_type', name: 'pet_type' },
        {data: 'breed_and_color', name: 'breed_and_color' },
        {data: 'created_at', name: 'created_at' },
        <?php if(Auth::user()->user_role->role_id != 3){ echo "{data: 'created_by', name: 'created_by' },"; }?>
        <?php if(Auth::user()->user_role->role_id != 3){ echo "{data: 'updated_by', name: 'updated_by' },"; } ?>
        {data: 'action', name: 'action' },
      ]
    });
  });
</script>
@endsection