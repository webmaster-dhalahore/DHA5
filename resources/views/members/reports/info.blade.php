@extends('layouts.admin', ['title'=> 'Member Info Report', 'page_title' => 'Member Info Report'])

@section('buttons')
@if($memberid)
@include('members.includes.printButton')
@include('members.includes.editButton', ['memberid' => $member->memberid])
@include('members.includes.profileButton', ['memberid' => $member->memberid])
@endif
@include('members.includes.memberhome')
@include('members.includes.homeButton')

@stop

@section('content')
<style>
  .border-top {
    border-top: 1px solid black !important;
  }

  .border-right {
    border-right: 1px solid black !important;
  }

  .border-bottom {
    border-bottom: 1px solid black !important;
  }

  .border-left {
    border-left: 1px solid black !important;
  }

  .fontSizeVal {
    font-size: 15px;
  }

  .fontSizelbl {
    font-size: 14px;
    font-weight: bold;
  }

  table.table-bordered>thead>tr>th,
  table.table-bordered>tbody>tr>th,
  table.table-bordered>tbody>tr>td {
    border: 1px solid black;
  }

  .bordercls {
    border: 1px solid black;
  }
</style>
<div class="content">
  <div class="container-fluid">

    <form action="{{ route('member.reports.member-infoPost') }}" method="post">
      @csrf
      <div class="row d-print-none">
        <div class="col-sm-3"></div>
        <div class="col-6 col-sm-6">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 mb-0">
                  <div class="form-group row mb-0 required">
                    <label for="memberid" class="col-sm-5 col-form-label">Member ID</label>
                    <div class="col-sm-7">
                      <input value="{{ old('memberid', $memberid) }}" class="text-uppercase form-control form-control-sm {{ $errors->has('memberid') ? 'is-invalid' : ''}}" id="memberid" name="memberid" placeholder="Member ID" required />
                      @error('memberid')
                      <div class="invalid-feedback" id="ifb_memberid">
                        {{$errors->first('memberid')}}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4 mt-2">
                  <button type="reset" class="btn btn-secondary btn-block"><i class="fas fa-times mr-2"></i> Reset</button>
                </div>
                <div class="col-sm-8 mt-2">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search mr-2"></i>SEARCH</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>

    @if($memberid)
    <div class="row">
      <div class="col-3 col-sm-3">

      </div>
      <div class="col-6 col-sm-6">
        <h2 class="text-center mb-5">Membership Information</h2>
      </div>
      <div class="col-3 col-sm-3">
        <p class="float-right">{{\Carbon\Carbon::now()->format('d-M-Y h:i:s')}}</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12">
        <table class="table table-borderless table-sm">
          <tbody>
            <tr>
              <td class="fontSizelbl" width="120">Member ID</td>
              <td class="border-bottom fontSizeVal" width="300" align="center">{{ $member ? $member->memberid : '' }}</td>
              <td rowspan="6" width="220" class="pl-4 pr-4">
                <div width="220" class="border-top border-right border-bottom border-left h-100 text-center">
                  @if($member && $member->picture)
                  <img class="img" src="{{ asset('storage/images/memberpics/' . $member->picture) }}" height="200" alt="Photograph" />
                  @elseif($member && $member->memberpic)
                  <img class="img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($member->memberpic)) }}" height="200" alt="Photograph" />
                  @else
                  <img class="img" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="180" alt="Photograph" />
                  @endif
                </div>
              </td>
              <td class="fontSizelbl" class="fontSizelbl">Married</td>
              <td class="border-bottom">{{ $member ? $member->married ? 'YES' : 'NO' : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Member Name</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->membername : '' }}</td>
              <td class="fontSizelbl">Phone Office</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->phoneoffice : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Father Name</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->memberfname : '' }}</td>
              <td class="fontSizelbl">Phone Res. </td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->phoneresidence : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Club</td>
              <td class="border-bottom fontSizeVal">{{$member && $member->club ? $member->club->name : ''}}</td>
              <td class="fontSizelbl">Mobile No</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->mobileno : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Member Type</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->type ? $member->type->des : '' }}</td>
              <td class="fontSizelbl">Fax</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->fax :  '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">CNIC</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->cnic : '' }}</td>
              <td class="fontSizelbl">Email</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->email : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Occupation</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->occupation ? $member->occupation->des : '' }}</td>
              <td rowspan="2" class="pl-4 pr-4">
                <div width="220" class="border-top border-right border-bottom border-left h-100 text-center">
                  @if($member && $member->signature)
                  <img class="img" id="member_sign_img" src="{{ asset('storage/images/memberpics/' . $member->signature) }}" width="190" alt="Signature" style="cursor: pointer;" />
                  @elseif($member && $member->membersign)
                  <img class="img" id="member_sign_img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($member->membersign)) }}" width="190" alt="Signature" style="cursor: pointer;" />
                  @endif
                </div>
              </td>
              <td class="fontSizelbl">Other Info</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->otherinfo : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Department</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->department : '' }}</td>
              <td class="fontSizelbl">Staus</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->status : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Organisation</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->organisation : '' }}</td>
              <td></td>
              <td class="fontSizelbl">M'ship Date</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->membershipdate ? \Carbon\Carbon::parse($member->membershipdate)->format('d-M-Y') : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl">Date of Birth</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-M-Y') : ''}}</td>
              <td></td>
              <td class="fontSizelbl">Card Issue Date</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->cardissuedate ? \Carbon\Carbon::parse($member->cardissuedate)->format('d-M-Y') : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl" rowspan="2">Mailing Address</td>
              <td class="border-bottom fontSizeVal" rowspan="2">{{ $member ? $member->mailingaddress : '' }}</td>
              <td></td>
              <td class="fontSizelbl">Card Expiry Date</td>
              <td class="border-bottom fontSizeVal">{{ $member && $member->cardexpirydate ? \Carbon\Carbon::parse($member->cardexpirydate)->format('d-M-Y') : '' }}</td>
            </tr>
            <tr>
              <td></td>
              <td class="fontSizelbl">DHA Discount</td>
              <td class="border-bottom fontSizeVal">{{ $member ? $member->discperc : '' }}</td>
            </tr>
            <tr>
              <td class="fontSizelbl" rowspan="2">Working Address</td>
              <td class="border-bottom fontSizeVal" rowspan="2">{{ $member ? $member->workingaddress : '' }}</td>
              <td class="fontSizelbl pl-5">Remarks</td>
              <td class="border-bottom fontSizeVal" colspan="2">{{ $member ? $member->remarks : '' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-12 mt-5">
        @if($member && count($member->family))
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th class="text-center">Member ID</th>
              <th class="text-center">Name</th>
              <th class="text-center">Date of Birth</th>
              <th class="text-center">Relation</th>
              <th class="text-center">Credit Allowed</th>
              <th class="text-center">Card Issue Date</th>
              <th class="text-center">Card Expiry Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($member->family as $family)
            <tr>
              <td align="center">{{ $family->memberid }}</td>
              <td>{{ $family->membername }}</td>
              <td align="center">{{ $family->dob ? \Carbon\Carbon::parse($family->dob)->format('d-M-Y') : '' }}</td>
              <td align="center">{{ $family->relation }}</td>
              <td align="center">{{ $family->creditallow ? 'YES' : 'NO' }}</td>
              <td align="center">{{ $family->cardissuedate ? \Carbon\Carbon::parse($family->cardissuedate)->format('d-M-Y') : '' }}</td>
              <td align="center">{{ $family->cardexpirydate ? \Carbon\Carbon::parse($family->cardexpirydate)->format('d-M-Y') : '' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <h3>No Family Member</h3>
        @endif

      </div>
    </div>
    @endif
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@stop

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush

@push('custom-scripts')
<script>
  is_required = false
  $(document).on("click", "#btnSearchView", gotoView);
  $(document).on("keydown", "#memberid_search", function(e) {
    const {
      key,
      keyCode
    } = e;
    if (key === "Enter" || keyCode === 13 || key === "F8" || keyCode === 119) {
      gotoView(e);
    }
  });

  function gotoView(e) {
    const memberid = $("#memberid_search").val();
    window.location.href = `${route}?memberid=${memberid}`;
  }
</script>
@endpush