<div class="card">
  <div class="card-header">
    <h4 class="card-title">Processing Checklist</h4>
  </div>
  <div class="card-body">
    <form class="validate-form" enctype="multipart/form-data" method="POST" action="{{ route('update-pet-processing',[$pet_processing->id]) }}" id="pet_processing_form">
    <!-- <form class="validate-form" enctype="multipart/form-data"> -->
      @csrf
      <div class="row">
        <div class="mb-1 col-md-6">
          @if(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4)
            <label class="form-label" for="phone">Processing Status</label>
            <select class="form-control" name="pet_status" id="pet_status">
              <option value="">Select Processing Status</option>
              @if(count($processing_status) > 0)
                @foreach($processing_status as $key => $status)
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
                      @if($i == $process['id'])
                        {{ "checked" }}
                      @endif
                    @endforeach
                  @endif>
                <label class="form-check-label" for="additional_items_{{ $i }}">{{ $checklist }}</label>
              </div>
              @if(!empty($process_list))
                @foreach($process_list as $process)
                  @php
                    $process_arr[] = $process['id'];
                  @endphp
                @endforeach
                @if(in_array($i, $process_arr))
                  <span class="badge bg-success rounded-pill ms-auto">Completed</span>
                  @foreach($process_list as $process)
                    @if($i == $process['id'])
                      <span class="text-nowrap text-muted">{{ isset($process['date']) ? \Carbon\Carbon::parse($process['date'])->format('F j') : '-' }}</span>
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