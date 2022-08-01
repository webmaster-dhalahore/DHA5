<?php
$title = $member ? "Member : {$member->membername} ($member->memberid)" : 'DHA Member';
$page_title = $member ? $member->membername . " ($member->memberid)" : 'Member Profile Report';
$box_color = $member && $member->status != 'CANCEL' ? 'primary' : 'danger';
$phone_residences = $member ?  explode(',', $member->phoneresidence) : [];
$mobile_numbers = $member ?  explode(',', $member->mobileno2) : [];
if ($member) {
  array_unshift($mobile_numbers, $member->mobileno);
}
?>

@extends('layouts.admin', ['title'=> $title, 'page_title' => $page_title])

@section('buttons')

@if($member)
@include('members.includes.printButton')
@include('members.includes.editButton', ['memberid' => $member->memberid])
@include('members.includes.infoButton', ['memberid' => $member->memberid])
@endif
@include('members.includes.memberhome')
@include('members.includes.homeButton')
@stop

@section('content')
<div class="content">
  <div class="container-fluid">

    <form action="{{ route('member.reports.member-profilePost') }}" method="post">
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
                      <input value="{{ old('memberid', $memberid) }}" class="uppercase form-control form-control-sm {{ $errors->has('memberid') ? 'is-invalid' : ''}}" id="memberid" name="memberid" placeholder="Member ID" required />
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
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-{{$box_color}} card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <!-- <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->
              @if($member && $member->picture)
              <img class="img" src="{{ asset('storage/images/memberpics/' . $member->picture) }}" height="200" alt="Photograph" />
              @elseif($member && $member->memberpic)
              <img class="img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($member->memberpic)) }}" height="200" alt="Photograph" />
              @else
              <img class="img" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="200" alt="Photograph" />
              @endif
            </div>

            <h3 class="profile-username text-center">{{$member ? $member->memberid : '' }}</h3>

            <p class="text-muted text-center">{{$member ? $member->membername : '' }}</p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Mobile</b> <a class="float-right">{{ count($mobile_numbers) ? $mobile_numbers[0] : '' }}</a>
              </li>
              <li class="list-group-item">
                <b>Ph Off:</b> <a class="float-right">{{$member ? $member->phoneoffice : '' }}</a>
              </li>
              <li class="list-group-item">
                <b>Ph Res:</b> <a class="float-right">{{ count($phone_residences) ? $phone_residences[0] : '' }}</a>
              </li>
            </ul>

            <a href="#" class="btn btn-{{$box_color}} btn-block d-print-none"><b>Transactions</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-{{$box_color}}">
          <div class="card-header">
            <h3 class="card-title">About Member</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Mailing Address</strong>
            <p class="text-muted">{{ $member ? strtoupper($member->mailingaddress) : '' }}</p>
            <hr>

            <strong><i class="fas fa-map-marker-alt mr-1"></i> Working Address</strong>
            <p class="text-muted">{{ $member ? strtoupper($member->workingaddress) : '' }}</p>
            <hr>

            <strong><i class="fas fa-phone mr-1"></i> Phone </strong>
            <div class="row">
              <div class="col-sm-5 mb-0">
                <p class="text-muted text-bold mb-0">Mobile No:</p>
              </div>
              <div class="col-sm-7 mb-0">
                <p class="text-muted mb-0" align="right">
                  @foreach($mobile_numbers as $mobile)
                  {{trim($mobile)}}
                  @if(!$loop->last)
                  <br />
                  @endif
                  @endforeach

                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5 mb-0">
                <p class="text-muted text-bold mb-0">Ph Office:</p>
              </div>
              <div class="col-sm-7 mb-0">
                <p class="text-muted mb-0" align="right">{{ $member ? $member->phoneoffice : '' }}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5 mb-0">
                <p class="text-muted text-bold mb-0">Ph Residence:</p>
              </div>
              <div class="col-sm-7 mb-0">
                <p class="text-muted mb-0" align="right">
                  @foreach($phone_residences as $ph_res)
                  {{trim($ph_res)}}
                  @if(!$loop->last)
                  <br />
                  @endif
                  @endforeach
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-5 mb-0">
                <p class="text-muted text-bold mb-0">Fax:</p>
              </div>
              <div class="col-sm-7 mb-0">
                <p class="text-muted mb-0" align="right">{{ $member ? $member->fax : '' }}</p>
              </div>
            </div>
            <hr>
            <strong><i class="fas fa-at mr-1"></i> Email</strong>
            <p class="text-muted">{{ $member ? $member->email : '' }}</p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="member_info_tab">
                <table class="table table-sm">
                  <tbody>
                    <tr>
                      <th class="border-top-0">Member ID</th>
                      <td class="border-top-0">{{ $member ? $member->memberid : '' }}</td>
                      @if(auth()->user()->club_id == $member->club_id)
                      <th class="border-top-0">Club</th>
                      <td class="border-top-0">{{$member && $member->club ? $member->club->name : ''}}</td>
                      @else
                      <th class="border-top-0 bg-gradient-orange">Club</th>
                      <td class="border-top-0 bg-gradient-orange">{{$member && $member->club ? $member->club->name : ''}}</td>
                      @endif
                    </tr>
                    <tr>
                      <th>Member Name</th>
                      <td colspan="3">{{$member ? $member->membername : '' }}</td>
                    </tr>
                    <tr>
                      <th>Category</th>
                      <td colspan="3">{{ $member && $member->category ? $member->category->des : '' }}</td>
                    </tr>
                    <tr>
                      <th>Type</th>
                      <td colspan="3">{{ $member && $member->type ? $member->type->des : '' }}</td>
                    </tr>
                    <tr>
                      <th>Father Name</th>
                      <td colspan="3">{{ $member ? $member->memberfname : '' }}</td>
                    </tr>
                    <tr>
                      <th>CNIC</th>
                      <td>{{$member ? $member->cnic : ''}}</td>
                      <th>Married</th>
                      <td>{{ $member ? $member->married ? 'YES' : 'NO' : '' }}</td>
                    </tr>
                    <tr>
                      <th>Date of Birth</th>
                      <td class="text-uppercase">{{ $member && $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-M-Y') : ''}}</td>
                      <th>Membership Date</th>
                      <td class="text-uppercase">{{ $member && $member->membershipdate ? \Carbon\Carbon::parse($member->membershipdate)->format('d-M-Y') : '' }}</td>
                    </tr>
                    <tr>
                      <th>Card Issue Date</th>
                      <td class="text-uppercase">{{ $member && $member->cardissuedate ? \Carbon\Carbon::parse($member->cardissuedate)->format('d-M-Y') : '' }}</td>
                      <th>Card Expiry Date</th>
                      <td class="text-uppercase">{{ $member && $member->cardexpirydate ? \Carbon\Carbon::parse($member->cardexpirydate)->format('d-M-Y') : '' }}</td>
                    </tr>
                    <tr>
                      <th>Occupation</th>
                      <td colspan="3">{{ $member && $member->occupation ? $member->occupation->des : '' }}</td>
                    </tr>
                    <tr>
                      <th>Department</th>
                      <td colspan="3">{{ $member ? $member->department : '' }}</td>
                    </tr>
                    <tr>
                      <th>Organisation</th>
                      <td colspan="3">{{ $member ? $member->organisation : ''}}</td>
                    </tr>

                    <tr>
                      <th>Status</th>
                      <td>{{ $member ? $member->status : '' }}</td>
                      <th>Block Status</th>
                      <td>{{ $member ? $member->blockstatus : ''}}</td>
                    </tr>
                    <tr>
                      <th>Remarks</th>
                      <td colspan="3">{{ $member ? $member->remarks : '' }}</td>
                    </tr>
                    <tr>
                      <th>Other Info</th>
                      <td>{{ $member ? $member->otherinfo : '' }}</td>
                      <th>DHA Discount</th>
                      <td>{{ $member ? $member->discperc : '' }}</td>
                    </tr>
                  </tbody>
                </table>

                <div class="row">
                  <div class="col-sm-12 mt-3">
                    <h3>Member Family</h3>
                  </div>
                </div>
                <div class="row">
                  @if($member)
                  @forelse($member->family as $family)
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header border-bottom-0"></div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-8">
                            <div class="row">
                              <div class="col-sm-5 text-bold">Member ID</div>
                              <div class="col-sm-7">{{$family->memberid}}</div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Name</div>
                              <div class="col-sm-7">{{$family->membername}}</div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Relation</div>
                              <div class="col-sm-7">{{$family->relation}}</div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Credit Allowed</div>
                              @if($family->creditallow)
                              <div class="col-sm-7 text-success"> <img src="{{ asset('dist/img/icon-yes.svg') }}" class="d-print-none" /> Yes</div>
                              @else
                              <div class="col-sm-7 text-danger"> <img src="{{ asset('dist/img/icon-no.svg') }}" class="d-print-none" /> No</div>
                              @endif
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Date of birth</div>
                              <div class="col-sm-7 text-uppercase">{{ $family->dob ? \Carbon\Carbon::parse($family->dob)->format('d-M-Y') : '' }}</div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Card Issue Date</div>
                              <div class="col-sm-7 text-uppercase">{{ $family->cardissuedate ? \Carbon\Carbon::parse($family->cardissuedate)->format('d-M-Y') : '-' }}</div>
                            </div>
                            <div class="row">
                              <div class="col-sm-5 text-bold">Card Expiry Date</div>
                              <div class="col-sm-7 text-uppercase">{{ $family->cardexpirydate ? \Carbon\Carbon::parse($family->cardexpirydate)->format('d-M-Y') : '-' }}</div>
                            </div>
                          </div>
                          <div class="col-4 text-right">
                            @if($family->picture)
                            <img class="img-fluid" id="member_sign_img" src="{{ asset('storage/images/memberpics/' . $family->picture) }}" width="125" alt="Photograph" style="cursor: pointer;" />
                            @elseif($family->fmemberpic)
                            <img class="img-fluid" id="member_sign_img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($family->fmemberpic)) }}" width="125" alt="Photograph" style="cursor: pointer;" />
                            @else
                            <img class="img-fluid" id="member_sign_img" src="{{ asset('dist/img/profile_pic01.jpg') }}" width="125" alt="Photograph" style="cursor: pointer;" />
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @empty
                  <div class="col-sm-12 text-center">
                    <h4 class="w-1100">No Family</h4>
                  </div>
                  @endforelse
                  @endif
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
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