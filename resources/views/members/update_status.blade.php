@extends('layouts.admin', ['title'=> 'Member Status ', 'page_title' => 'Member Status'])

@section('buttons')
@if($member)
@include('members.includes.infoButton', ['memberid' => $member->memberid])
@include('members.includes.profileButton', ['memberid' => $member->memberid])
@endif
@include('members.includes.memberhome')
@include('members.includes.homeButton')

@stop

@section('content')
<!-- Main content -->
<div class="content">
  <form class="needs-validation" action="{{ route('member.updateStatus') }}" method="POST" id="form">
    @csrf
    <div class="container-fluid">
      <div class="form-group row mb-0">
        <label for="memberid" class="col-sm-2 offset-md-3 col-form-label pr-0">Member ID</label>
        <div class="col-sm-4">
          <input type="hidden" id="membersr" name="membersr" />
          <input class="text-uppercase form-control form-control-sm {{ $errors->has('memberid') ? 'is-invalid' : '' }}" value="{{ old('memberid', $memberid) }}" autocomplete="off" id="memberid" name="memberid" placeholder="Member ID" aria-describedby="memberid_feedback" required />
          @error('memberid')
          <div class="invalid-feedback">
            {{$errors->first('memberid')}}
          </div>
          @enderror
        </div>
      </div>
      <div class="form-group row mb-0">
        <label for="membername" class="col-sm-2 offset-md-3 col-form-label">Member Name</label>
        <div class="col-sm-4">
          <input class="text-uppercase form-control form-control-sm {{ $errors->has('membername') ? 'is-invalid' : ''}}" value="{{ old('membername', $member ? $member->membername : '') }}" id="membername" name="membername" placeholder="Member Name" />
          @error('membername')
          <div class="invalid-feedback">
            {{$errors->first('membername')}}
          </div>
          @enderror
        </div>
      </div>

      <div class="form-group row mb-0">
        <label for="typeid" class="col-sm-2 offset-md-3 col-form-label">Member Type</label>
        <div class="col-sm-4">
          <div class="form-group row mb-0">
            <div class="col-sm-3 pr-0">
              <input class="text-uppercase form-control form-control-sm {{ $errors->has('typeid') ? 'is-invalid' : ''}}" id="typeid" name="typeid" value="{{ old('typeid', $member ? $member->typeid : '') }}" placeholder="Member Type" />
              @error('typeid')
              <div class="invalid-feedback">
                {{$errors->first('typeid')}}
              </div>
              @enderror
            </div>
            <div class="col-sm-9">
              <input class="text-uppercase form-control form-control-sm {{ $errors->has('typeid') ? 'is-invalid' : ''}}" id="member_type_desc" name="member_type_desc" readonly tabindex="-1" />
            </div>
          </div>
        </div>
      </div>

      <div class="form-group row mb-0">
        <label for="status" class="col-sm-2 offset-md-3 col-form-label">Status</label>
        <div class="col-sm-4">
          <div class="form-group row mb-0">
            <div class="col-sm-4">
              <select class="form-control form-control-sm {{ $errors->has('status') ? 'is-invalid' : ''}}" id="status" name="status">
                <option value="">-----------</option>
                @foreach ($statuses as $status)
                <option value="{{$status['value']}}" {{ $member && $member->status == $status['value'] ? 'selected' : '' }}>{{ $status['label'] }}</option>
                @endforeach
              </select>
              @error('status')
              <div class="invalid-feedback">
                {{$errors->first('status')}}
              </div>
              @enderror
            </div>
            <label for="blockstatus" class="col-sm-3 col-form-label">Block Status</label>
            <div class="col-sm-5">
              <select class="form-control form-control-sm {{ $errors->has('blockstatus') ? 'is-invalid' : ''}}" id="blockstatus" name="blockstatus" data-parsley-trigger="change" required>
                <option value="">-----------</option>
                @foreach ($block_statuses as $bs)
                <option value="{{$bs['value']}}" {{ $member && $member->blockstatus == $bs['value'] ? 'selected' : '' }}>{{ $bs['label'] }}</option>
                @endforeach
              </select>
              @error('blockstatus')
              <div class="invalid-feedback">
                {{$errors->first('blockstatus')}}
              </div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="form-group row mb-0">
        <label for="fromdate" class="col-sm-2 offset-md-3 col-form-label">From Date</label>
        <div class="col-sm-4">
          <div class="form-group row mb-0">
            <div class="col-sm-4">
              <input type="date" value="{{ old('fromdate', $member && $member->fromdate ? \Carbon\Carbon::parse($member->fromdate)->format('Y-m-d') : '') }}" id="fromdate" name="fromdate" class="form-control form-control-sm {{ $errors->has('fromdate') ? 'is-invalid' : ''}}" />
              @error('fromdate')
              <div class="invalid-feedback">
                {{$errors->first('fromdate')}}
              </div>
              @enderror
            </div>
            <label for="todate" class="col-sm-3 col-form-label">To Date</label>
            <div class="col-sm-5">
              <input type="date" value="{{ old('todate', $member && $member->todate ? \Carbon\Carbon::parse($member->todate)->format('Y-m-d') : '') }}" id="todate" name="todate" class="form-control form-control-sm {{ $errors->has('todate') ? 'is-invalid' : ''}}" />
              @error('todate')
              <div class="invalid-feedback">
                {{$errors->first('todate')}}
              </div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="form-group row mb-1">
        <label for="remarks" class="col-sm-2 offset-md-3 col-form-label">Remarks</label>
        <div class="col-sm-4">
          <textarea name="remarks" id="remarks" rows="3" class="text-uppercase form-control textarea" maxlength="500" style="resize: none;" placeholder="Block Remarks">{{ $member ? $member->remarks : '' }}</textarea>
        </div>
      </div>
      <div class="form-group row mb-1">
        <div class="col-sm-2 offset-md-3">
          <button type="button" class="btn btn-outline-secondary btn-block">Cancel</button>
        </div>
        <div class="col-sm-4">
          <button type="submit" class="btn btn-primary btn-block text-white" id="submitBtn">
            <i class="fas fa-save mr-2"></i> Save Changes
          </button>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </form>

</div>
<!-- /.content -->
@stop

@push('custom-scripts')
<script>
  const getMemberRoute = "{{ route('apis.getMember') }}";
</script>
<script src="{{ asset('dist/js/common/next_field_on_enter.js') }}" defer></script>
<script src="{{ asset('dist/js/members/update_status.js') }}" defer></script>

@endpush