<?php
$page_title = $member ? $member->membername . ' (' . $member->memberid . ')' : 'Edit Member';
$profileTab = app('request')->input('tab') == 'contact' || app('request')->input('tab') == 'family' ? false : true;
$contactTab = app('request')->input('tab') == 'contact' ? true : false;
$familyTab = app('request')->input('tab') == 'family' ? true : false;
$cardbg = 'card-primary';

if ($member) {
  if ($member->blockstatus == 'BLOCK' || $member->blockstatus == 'CANCEL') {
    $cardbg = 'card-danger';
  } else if ($member->blockstatus == 'OUTSTATION') {
    $cardbg = 'card-warning';
  }
  if (auth()->user()->club_id != $member->club_id) {
    $cardbg = 'card-orange';
  }
}
?>
@extends('layouts.admin', ['title'=> 'Edit Member : ' . $page_title, 'page_title' => $page_title, 'icon' => '<i class="fas fa-user-edit text-primary mr-1"></i>'])

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
  @if($member)
  <form class="needs-validation" action="{{ route('member.update', ['membersr' => $member->membersr]) }}" method="POST" enctype="multipart/form-data" id="form">
    @csrf
    @method('PATCH')
    @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="card {{$cardbg}} card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
              <ul class="nav nav-tabs" id="member-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link {{ $profileTab ? 'active' : '' }}" id="member-tabs-profile-tab" data-toggle="pill" href="#member-tabs-profile" role="tab" aria-controls="member-tabs-profile" aria-selected="{{$profileTab ? 'true' : 'false'}}">Member Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ $contactTab ? 'active' : '' }}" id="member-tabs-contact-tab" data-toggle="pill" href="#member-tabs-contact" role="tab" aria-controls="member-tabs-contact" aria-selected="{{$contactTab ? 'true' : 'false'}}">Contact Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ $familyTab ? 'active' : '' }}" id="member-tabs-family-tab" data-toggle="pill" href="#member-tabs-family" role="tab" aria-controls="member-tabs-family" aria-selected="{{$familyTab ? 'true' : 'false'}}">Family</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="member-tabs-content">
                <div class="tab-pane fade {{ $profileTab ? 'show active' : '' }}" id="member-tabs-profile" role="tabpanel" aria-labelledby="member-tabs-profile-tab">
                  <div class="card-body py-0">
                    <div class="row">
                      <div class="col-sm-6 mb-0">
                        <div class="form-group row mb-0 required">
                          <label for="memberid" class="col-sm-3 col-form-label">Member ID / SR</label>
                          <div class="col-sm-3 pr-0">
                            <input type="hidden" name="membersr" id="membersr" value="{{ $member ? $member->membersr : '' }}" />
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('memberid') ? 'is-invalid' : '' }}" value="{{ old('memberid', $member ? $member->memberid : $memberid) }}" autocomplete="off" maxlength="20" id="memberid" name="memberid" placeholder="Member ID" aria-describedby="memberid_feedback" required />
                            @error('memberid')
                            <div class="invalid-feedback">
                              {{$errors->first('memberid')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-2 pr-0">
                            <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="gotopage()"><i class="fas fa-search"></i> Search</button>
                          </div>
                          <div class="col-sm-4">
                            <input class="text-uppercase form-control form-control-sm" id="member_sr" name="member_sr" placeholder="Member Serial" readonly tabindex="-1" value="{{ $member ? $member->membersr : '' }}" />
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="club_id" class="col-sm-3 col-form-label">Club</label>
                          <div class="col-sm-5 pr-0">
                            <input type="hidden" id="club_id" name="club_id" value="{{ $member ? $member->club_id : 0 }}" />
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('club_id') ? 'is-invalid' : '' }}" id="club_name" value="{{ $member && $member->club ? $member->club->name : auth()->user()->club->name }}" />
                            @error('club_id')
                            <div class="invalid-feedback">
                              {{$errors->first('club_id')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-4">
                            <input class="text-uppercase form-control form-control-sm" id="club_code" value="{{$member ? $member->enb : ''}}" readonly tabindex="-1" />
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="categoryid" class="col-sm-3 col-form-label">Category</label>
                          <div class="col-sm-9">
                            <select class="text-uppercase form-control form-control-sm {{ $errors->has('categoryid') ? 'is-invalid' : ''}}" id="categoryid" name="categoryid" required>
                              <option value="">-----------</option>
                              @foreach($categories as $category)
                              <option value="{{$category->code}}" {{ ($member &&  $member->categoryid == $category->code) ||  old('categoryid') == $category->code ? "selected" : "" }}>{{$category->des}}</option>
                              @endforeach
                            </select>
                            @error('categoryid')
                            <div class="invalid-feedback">
                              {{$errors->first('categoryid')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="typeid" class="col-sm-3 col-form-label">Member Type</label>
                          <div class="col-sm-2 pr-0">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('typeid') ? 'is-invalid' : ''}}" id="typeid" name="typeid" value="{{ old('typeid', $member ? $member->typeid : '') }}" placeholder="Member Type" required data-parsley-pattern="[0-9]+$" data-parsley-trigger="keyup" data-parsley-required-message="Required!" />
                            @error('typeid')
                            <div class="invalid-feedback">
                              {{$errors->first('typeid')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-6 pr-0">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('typeid') ? 'is-invalid' : ''}}" id="member_type_desc" name="member_type_desc" readonly tabindex="-1" />
                          </div>
                          <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="openMemberTypeLOV()"><i class="fas fa-ellipsis-h"></i></button>
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="membername" class="col-sm-3 col-form-label">Member Name</label>
                          <div class="col-sm-9">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('membername') ? 'is-invalid' : ''}}" value="{{ old('membername', $member ? $member->membername : '') }}" maxlength="99" id="membername" name="membername" placeholder="Member Name" required />
                            @error('membername')
                            <div class="invalid-feedback">
                              {{$errors->first('membername')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="memberfname" class="col-sm-5 col-form-label">Husband / Father's Name</label>
                          <div class="col-sm-7">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('memberfname') ? 'is-invalid' : ''}}" id="memberfname" maxlength="100" name="memberfname" value="{{ old('memberfname', $member ? $member->memberfname : '') }}" placeholder="Husband / Father's Name" />
                            @error('memberfname')
                            <div class="invalid-feedback">
                              {{$errors->first('memberfname')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="cnic" class="col-sm-3 col-form-label">CNIC</label>
                          <div class="col-sm-9">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('cnic') ? 'is-invalid' : ''}}" id="cnic" maxlength="20" name="cnic" value="{{ old('cnic', $member ? $member->cnic : '') }}" placeholder="00000-0000000-0" data-inputmask="'mask': ['99999-9999999-9', '999999-999999-9']" data-mask required />
                            @error('cnic')
                            <div class="invalid-feedback">
                              {{$errors->first('cnic')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="pano" class="col-sm-3 col-form-label">PA No. </label>
                          <div class="col-sm-9">
                            <input value="{{ old('pano', $member ? $member->pano : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('pano') ? 'is-invalid' : ''}}" id="pano" maxlength="8" name="pano" placeholder="PA Number" />
                            @error('pano')
                            <div class="invalid-feedback">
                              {{$errors->first('pano')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 mb-0">
                        <div class="row align-items-center">
                          <div class="col-sm-6">
                            <div class="my-2 text-center">
                              @if($member && $member->picture)
                              <img class="img" id="member_pic_img" src="{{ asset('storage/images/memberpics/' . $member->picture) }}" height="230" alt="Photograph" style="cursor: pointer;" />
                              @elseif($member && $member->memberpic)
                              <img class="img" id="member_pic_img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($member->memberpic)) }}" height="230" alt="Photograph" style="cursor: pointer;" />
                              @else
                              <img class="img" id="member_pic_img" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="230" alt="Photograph" style="cursor: pointer;" />
                              @endif
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="col text-center justify-content-center align-self-center">
                              @if($member && $member->signature)
                              <img class="img" id="member_sign_img" src="{{ asset('storage/images/memberpics/' . $member->signature) }}" width="230px" alt="Signature" style="cursor: pointer;" />
                              @elseif($member && $member->membersign)
                              <img class="img" id="member_sign_img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($member->membersign)) }}" width="230px" alt="Signature" style="cursor: pointer;" />
                              @else
                              <img class="img" id="member_sign_img" src="{{ asset('dist/img/sign-placeholder.png') }}" width="230px" alt="Signature" style="cursor: pointer;" />
                              @endif

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group row mb-0">
                              <label for="memberpic" class="col-sm-4 col-form-label">Picture</label>
                              <div class="col-sm-8">
                                <input type="file" value="{{ old('memberpic') }}" class="text-uppercase form-control form {{ $errors->has('memberpic') ? 'is-invalid' : ''}}" id="memberpic" name="memberpic" accept="image/*" tabindex="-1" />
                                @error('memberpic')
                                <div class="invalid-feedback">
                                  {{$errors->first('memberpic')}}
                                </div>
                                @enderror
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group row mb-0">
                              <label for="membersign" class="col-sm-4 col-form-label">Signature</label>
                              <div class="col-sm-8">
                                <input type="file" value="{{ old('membersign') }}" class="text-uppercase form-control {{ $errors->has('membersign') ? 'is-invalid' : ''}}" id="membersign" name="membersign" accept="image/*" tabindex="-1" />
                                @error('membersign')
                                <div class="invalid-feedback">
                                  {{$errors->first('membersign')}}
                                </div>
                                @enderror
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="occupationid" class="col-sm-3 col-form-label">Profession</label>
                          <div class="col-sm-2 pr-0">
                            <input value="{{ old('occupationid', $member ? $member->occupationid : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('occupationid') ? 'is-invalid' : ''}}" id="occupationid" name="occupationid" placeholder="Profession" />
                            @error('occupationid')
                            <div class="invalid-feedback">
                              {{$errors->first('occupationid')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-6 pr-0">
                            <input value="{{ old('profession_desc') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('occupationid') ? 'is-invalid' : ''}}" id="profession_desc" name="profession_desc" readonly tabindex="-1" />
                          </div>
                          <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="openProfessionsLOV()"><i class="fas fa-ellipsis-h"></i></button>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="rank" class="col-sm-3 col-form-label">Rank</label>
                          <div class="col-sm-9">
                            <input value="{{ old('rank', $member ? $member->rank : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('rank') ? 'is-invalid' : ''}}" id="rank" maxlength="200" name="rank" placeholder="Rank" />
                            @error('rank')
                            <div class="invalid-feedback">
                              {{$errors->first('rank')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="department" class="col-sm-3 col-form-label">Department</label>
                          <div class="col-sm-9">
                            <input value="{{ old('department', $member ? $member->department : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('department') ? 'is-invalid' : ''}}" id="department" maxlength="200" name="department" placeholder="Department" />
                            @error('department')
                            <div class="invalid-feedback">
                              {{$errors->first('department')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="organisation" class="col-sm-3 col-form-label">Organisation</label>
                          <div class="col-sm-9">
                            <input value="{{ old('organisation', $member ? $member->organisation : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('organisation') ? 'is-invalid' : ''}}" id="organisation" maxlength="100" name="organisation" placeholder="Organisation" />
                            @error('organisation')
                            <div class="invalid-feedback">
                              {{$errors->first('organisation')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                          <div class="col-sm-9">
                            <input type="date" value="{{ old('dob', $member && $member->dob ? \Carbon\Carbon::parse($member->dob)->format('Y-m-d') : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('dob') ? 'is-invalid' : ''}}" id="dob" name="dob" required />
                            @error('dob')
                            <div class="invalid-feedback">
                              {{$errors->first('dob')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="married" class="col-sm-3 col-form-label">Married</label>
                          <div class="form-group col-sm-6">
                            <div class="form-check">
                              <input class="form-check-input" value="Y" type="radio" name="married" id="married_yes" {{ $member && $member->married == 'Y' ? 'checked' : 'checked' }} />
                              <label class="form-check-label" for="married_yes">Yes</label>
                            </div>
                          </div>
                          <div class="form-group col-sm-3">
                            <div class="form-check">
                              <input class="form-check-input" value="N" type="radio" id="married_no" name="married" {{ $member && $member->married == 'N' ? 'checked' : '' }} />
                              <label class="form-check-label" for="married_no">No</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="otherinfo" class="col-sm-3 col-form-label">Other Info</label>
                          <div class="col-sm-4 pr-0">
                            <input value="{{ old('otherinfo', $member ? $member->otherinfo : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('otherinfo') ? 'is-invalid' : ''}}" id="otherinfo" name="otherinfo" maxlength="100" />
                            @error('otherinfo')
                            <div class="invalid-feedback">
                              {{$errors->first('otherinfo')}}
                            </div>
                            @enderror
                          </div>
                          <label for="membertype" class="col-sm-2 col-form-label">Type</label>
                          <div class="col-sm-3">
                            <select class="text-uppercase form-control form-control-sm {{ $errors->has('membertype') ? 'is-invalid' : ''}}" id="membertype" name="membertype">
                              <option value="">-----------</option>
                              @foreach ($other_types as $type)
                              <option value="{{$type['value']}}" {{ $member && $member->membertype == $type['value'] ? 'selected' : '' }}>{{ $type['label'] }}</option>
                              @endforeach
                            </select>
                            @error('membertype')
                            <div class="invalid-feedback">
                              {{$errors->first('membertype')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="member_type_sub1" class="col-sm-3 col-form-label">Member Type Sub</label>
                          <div class="col-sm-5 pr-0">
                            <select class="text-uppercase form-control form-control-sm" id="member_type_sub1" name="member_type_sub1">
                              <option value="">-----------</option>
                              @foreach ($member_type_subs as $mts)
                              <option value="{{$mts['value']}}" {{ $mts['selected'] == true ? 'selected' : '' }}>{{ $mts['label'] }}</option>
                              @endforeach
                            </select>
                            <div class="invalid-feedback">
                              Invalid Member Type Sub.
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <input class="text-uppercase form-control form-control-sm" id="member_type_sub2" name="member_type_sub2" />
                            <div class="invalid-feedback">
                              Invalid Data.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="status" class="col-sm-3 col-form-label">Status</label>
                          <div class="col-sm-3">
                            <select class="text-uppercase form-control form-control-sm {{ $errors->has('status') ? 'is-invalid' : ''}}" id="status" name="status">
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
                          <div class="col-sm-3">
                            <select class="text-uppercase form-control form-control-sm {{ $errors->has('blockstatus') ? 'is-invalid' : ''}}" id="blockstatus" name="blockstatus">
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
                        <div class="form-group row mb-0">
                          <label for="fromdate" class="col-sm-3 col-form-label">From Date</label>
                          <div class="col-sm-3">
                            <input type="date" value="{{ old('fromdate', $member && $member->fromdate ? \Carbon\Carbon::parse($member->fromdate)->format('Y-m-d') : '') }}" id="fromdate" name="fromdate" class="text-uppercase form-control form-control-sm" />
                          </div>
                          <label for="todate" class="col-sm-3 col-form-label">To Date</label>
                          <div class="col-sm-3">
                            <input type="date" value="{{ old('todate', $member && $member->todate ? \Carbon\Carbon::parse($member->todate)->format('Y-m-d') : '') }}" id="todate" name="todate" class="text-uppercase form-control form-control-sm" />
                          </div>
                        </div>
                        <div class="form-group row mb-1">
                          <label for="remarks" class="col-sm-3 col-form-label">Block Remarks</label>
                          <div class="col-sm-9">
                            <textarea name="remarks" id="remarks" rows="3" class="text-uppercase form-control textarea" style="resize: none;" placeholder="Block Remarks">{{ $member ? $member->remarks : '' }}</textarea>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="membershipdate" class="col-sm-3 col-form-label">Membership Date</label>
                          <div class="col-sm-9">
                            <input type="date" value="{{ old('membershipdate', $member && $member->membershipdate ? \Carbon\Carbon::parse($member->membershipdate)->format('Y-m-d') : '') }}" id="membershipdate" name="membershipdate" class="text-uppercase form-control form-control-sm {{ $errors->has('membershipdate') ? 'is-invalid' : ''}}" />
                            @error('membershipdate')
                            <div class="invalid-feedback">
                              {{$errors->first('membershipdate')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="cardissuedate" class="col-sm-3 col-form-label">Card Issue Date</label>
                          <div class="col-sm-3">
                            <input type="date" value="{{ old('cardissuedate', $member && $member->cardissuedate ? \Carbon\Carbon::parse($member->cardissuedate)->format('Y-m-d') : '') }}" id="cardissuedate" name="cardissuedate" class="text-uppercase form-control form-control-sm {{ $errors->has('cardissuedate') ? 'is-invalid' : ''}}" />
                            @error('cardissuedate')
                            <div class="invalid-feedback">
                              {{$errors->first('cardissuedate')}}
                            </div>
                            @enderror
                          </div>
                          <label for="cardexpirydate" class="col-sm-3 col-form-label">Expiry Date</label>
                          <div class="col-sm-3">
                            <input type="date" value="{{ old('cardexpirydate', $member && $member->cardexpirydate ? \Carbon\Carbon::parse($member->cardexpirydate)->format('Y-m-d') : '') }}" id="cardexpirydate" name="cardexpirydate" class="text-uppercase form-control form-control-sm {{ $errors->has('cardexpirydate') ? 'is-invalid' : ''}}" />
                            @error('cardexpirydate')
                            <div class="invalid-feedback">
                              {{$errors->first('cardexpirydate')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="card-footer">
                        Footer here
                      </div> -->
                </div>
                <div class="tab-pane fade {{ $contactTab ? 'show active' : '' }}" id="member-tabs-contact" role="tabpanel" aria-labelledby="member-tabs-contact-tab">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="phoneoffice" class="col-sm-3 col-form-label">Phone (Office)</label>
                          <div class="col-sm-9">
                            <input value="{{ old('phoneoffice', $member ? $member->phoneoffice : '') }}" name="phoneoffice" id="phoneoffice" class="text-uppercase form-control form-control-sm  {{ $errors->has('phoneoffice') ? 'is-invalid' : ''}}" placeholder="Phone (Office)" maxlength="60" />
                            @error('phoneoffice')
                            <div class="invalid-feedback">
                              {{$errors->first('phoneoffice')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-2">
                          <label for="mailingaddress" class="col-sm-3 col-form-label">Mailing Address</label>
                          <div class="col-sm-9">
                            <textarea name="mailingaddress" id="mailingaddress" rows="3" class="text-uppercase form-control {{ $errors->has('mailingaddress') ? 'is-invalid' : ''}}" style="resize: none;" placeholder="Mailing Address" maxlength="500">{{ old('mailingaddress', $member ? $member->mailingaddress : '') }}</textarea>
                            @error('mailingaddress')
                            <div class="invalid-feedback">
                              {{$errors->first('mailingaddress')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="phoneresidence" class="col-sm-3 col-form-label">Phone (Residence)</label>
                          <div class="col-sm-9">
                            <input value="{{ old('phoneresidence', $member ? $member->phoneresidence : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('phoneresidence') ? 'is-invalid' : ''}}" id="phoneresidence" name="phoneresidence" placeholder="Phone (Residence)" maxlength="60" />
                            @error('phoneresidence')
                            <div class="invalid-feedback">
                              {{$errors->first('phoneresidence')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-2">
                          <label for="workingaddress" class="col-sm-3 col-form-label">Working Address</label>
                          <div class="col-sm-9">
                            <textarea name="workingaddress" id="workingaddress" rows="3" class="text-uppercase form-control {{ $errors->has('workingaddress') ? 'is-invalid' : ''}}" style="resize: none;" placeholder="Working Address" maxlength="500">{{ old('workingaddress', $member ? $member->workingaddress : '') }}</textarea>
                            @error('workingaddress')
                            <div class="invalid-feedback">
                              {{$errors->first('workingaddress')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 mb-0">
                        <div class="form-group row mb-0">
                          <label for="mobileno" class="col-sm-3 col-form-label">Mobile No.</label>
                          <div class="col-sm-9">
                            <input value="{{ old('mobileno', $member ? $member->mobileno : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('mobileno') ? 'is-invalid' : ''}}" id="mobileno" name="mobileno" placeholder="Mobile No 1" maxlength="20" />
                            @error('mobileno')
                            <div class="invalid-feedback">
                              {{$errors->first('mobileno')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 mb-0">
                        <div class="form-group row mb-0">
                          <label for="mobileno2" class="col-sm-3 col-form-label">Mobile No.</label>
                          <div class="col-sm-9">
                            <input value="{{ old('mobileno2', $member ? $member->mobileno2 : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('mobileno2') ? 'is-invalid' : ''}}" id="mobileno2" name="mobileno2" placeholder="Mobile No 2" maxlength="100" />
                            @error('mobileno2')
                            <div class="invalid-feedback">
                              {{$errors->first('mobileno2')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 mb-0">
                        <div class="form-group row mb-0">
                          <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                          <div class="col-sm-9">
                            <input value="{{ old('fax', $member ? $member->fax : '') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('fax') ? 'is-invalid' : ''}}" id="fax" name="fax" placeholder="Fax" maxlength="20" />
                            @error('fax')
                            <div class="invalid-feedback">
                              {{$errors->first('fax')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="email" class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input value="{{ old('email', $member ? $member->email : '') }}" type="email" class="text-uppercase form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" placeholder="Email" maxlength="50" />
                            @error('email')
                            <div class="invalid-feedback">
                              {{$errors->first('email')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade {{ $familyTab ? 'show active' : '' }}" id="member-tabs-family" role="tabpanel" aria-labelledby="member-tabs-family-tab">
                  @if($member && $member->blockstatus == 'ACTIVE')
                  <div class="row">
                    <div class="col-sm-12 mb-4">
                      <button type="button" class="btn btn-default btn-sm float-right" onclick="addNewFamilyModal(<?php echo $member ? $member->membersr : '' ?>)" data-target="#modal_family">
                        <i class=" fas fa-plus"></i> Add Family
                      </button>
                    </div>
                  </div>
                  @endif
                  @if($member && $member->family)
                  <div class="row">
                    @forelse($member->family as $family)
                    <div class="col-sm-4">
                      <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                          <strong>{{$family->membername}}</strong>
                        </div>
                        <div class="card-body pt-0">
                          <div class="row">
                            <div class="col-7">
                              <h2 class="lead"><b>MemberID: <SPan class="text-primary">{{$family->memberid}}</SPan></b> </h2>
                              <p class="text-muted text-sm mb-0"><b>Credit Allowed </b> <span class="btn {{ $family->creditallow ? 'bg-teal' : 'btn-secondary' }} btn-xs">{{ $family->creditallow ? 'Yes' : 'No' }}</span></p>
                              <p class="text-muted text-sm mb-0"><b>Relation: </b>{{$family->relation}}</p>
                              <p class="text-muted text-sm mb-0"><b>Date of birth </b>{{ \Carbon\Carbon::parse($family->dob)->format('d-M-Y') }} </p>
                            </div>
                            <div class="col-5 text-center">
                              <span onclick="showFamilModal('<?php echo $family->vno ? $family->vno : $family->memberid ?>')">
                                @if($family->picture)
                                <img class="img-circle img-fluid" id="member_sign_img" src="{{ asset('storage/images/memberpics/' . $family->picture) }}" width="125" alt="Photograph" style="cursor: pointer;" />
                                @elseif($family->fmemberpic)
                                <img class="img-circle img-fluid" id="member_sign_img" src="data:image/bmp;base64,{{ chunk_split(base64_encode($family->fmemberpic)) }}" width="125" alt="Photograph" style="cursor: pointer;" />
                                @else
                                <img class="img-circle img-fluid" id="member_sign_img" src="{{ asset('dist/img/profile_pic01.jpg') }}" width="125" alt="Photograph" style="cursor: pointer;" />
                                @endif
                              </span>
                              {{-- <img @if($family->fmemberpic)
                              src="data:image/bmp;base64,{{ chunk_split(base64_encode($family->fmemberpic)) }}"
                              @else
                              src="{{ asset('dist/img/profile_pic01.jpg') }}"
                              @endif
                              width="125" alt="user-avatar" class="img-circle img-fluid"> --}}
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="text-right">
                            <button type="button" class="btn btn-sm bg-teal" onclick="showFamilModal('<?php echo $family->vno ? $family->vno : $family->memberid ?>')">
                              <i class="fas fa-eye"></i> View
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editFamilyModal('<?php echo $family->vno ? $family->vno : $family->memberid ?>')">
                              <i class="fas fa-edit mr-2"></i> Edit
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @empty
                    <div class="col-sm-12 text-center">
                      <h4 class="w-1100">No Family</h4>
                    </div>
                    @endforelse
                  </div>
                  @endif
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-outline-secondary ">Cancel</button>
              @if($member)
              <button type="submit" class="btn btn-primary float-right text-white">
                <i class="fas fa-save mr-2"></i> Save Changes
              </button>
              @endif
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
    @if($member)
  </form>
  @endif

</div>
<!-- /.content -->

@include('members.edit_family_modal')
@include('members.show_family_modal')
@include('lovs.professions')
@include('lovs.membertypes')
@stop

@push('custom-scripts')
<script>
  const create_page_url = "{{ route('member.create') }}";

  // let profile_pic = "{{ asset('dist/img/profile_pic01.jpg') }}";
  // let sign_pic = "{{ asset('dist/img/sign-placeholder.png') }}";

  let family_profile_pic = "{{ asset('dist/img/profile_pic01.jpg') }}";
  let old_family_profile_pic = "{{ asset('dist/img/profile_pic01.jpg') }}";
  let family_sign_pic = "{{ asset('dist/img/sign-placeholder.png') }}";
  let old_family_sign_pic = "{{ asset('dist/img/sign-placeholder.png') }}";
</script>
<script src="{{ asset('dist/js/common/next_field_on_enter.js') }}" defer></script>
<script src="{{ asset('dist/js/members/membercommon.js') }}" defer></script>
<script src="{{ asset('dist/js/members/edit.js') }}" defer></script>
@endpush