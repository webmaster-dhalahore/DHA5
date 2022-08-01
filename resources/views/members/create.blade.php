@extends('layouts.admin', ['title'=> 'Add new Member', 'page_title' => 'Create new Member', 'icon' => '<i class="fas fa-user-plus text-primary mr-1"></i>'])

<?php
$memberid = '';
if (Session::has('memberid')) {
  $memberid = \Session::get('memberid');
  Session::forget('memberid');
}
?>


@section('buttons')
  @include('members.includes.memberhome')
  @include('members.includes.homeButton')
@stop

@section('content')
<!-- Main content -->
<div class="content">
  <!-- @if ($errors->any())
  @foreach ($errors->all() as $error)
  <div>{{$error}}</div>
  @endforeach
  @endif -->

  <form class="needs-validation" action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data" id="form">
    @csrf
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
              <ul class="nav nav-tabs" id="member-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="member-tabs-profile-tab" data-toggle="pill" href="#member-tabs-profile" role="tab" aria-controls="member-tabs-profile" aria-selected="true">Member Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="member-tabs-contact-tab" data-toggle="pill" href="#member-tabs-contact" role="tab" aria-controls="member-tabs-contact" aria-selected="false">Contact Details</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="member-tabs-family-tab" data-toggle="pill" href="#member-tabs-family" role="tab" aria-controls="member-tabs-family" aria-selected="false">Family</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="member-tabs-content">
                <div class="tab-pane fade show active" id="member-tabs-profile" role="tabpanel" aria-labelledby="member-tabs-profile-tab">
                  <div class="card-body py-0">
                    <div class="row">
                      <div class="col-sm-6 mb-0">
                        <div class="form-group row mb-0 required">
                          <label for="memberid" class="col-sm-3 col-form-label">Member ID / SR</label>
                          <div class="col-sm-3 pr-0">
                            <input class="text-uppercase form-control form-control-sm uppercase {{ $errors->has('memberid') ? 'is-invalid' : '' }}" value="{{ old('memberid', $memberid) }}" autocomplete="off" maxlength="20" id="memberid" name="memberid" placeholder="Member ID" aria-describedby="memberid_feedback" required data-parsley-trigger="keyup" data-parsley-required-message="Member ID required."/>
                            @error('memberid')
                            <div class="invalid-feedback">
                              {{$errors->first('memberid')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-2 pr-0">
                            <button type="button" class="btn btn-sm btn-secondary btn-block focuable" onclick="gotopage()"><i class="fas fa-search"></i> Search</button>
                          </div>
                          <!-- <div class="col-sm-1 pr-0">
                            <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="openMembersLOV()"><i class="fas fa-ellipsis-h"></i></button>
                          </div> -->
                          <div class="col-sm-4">
                            <input class="text-uppercase form-control form-control-sm" id="member_sr" name="member_sr" placeholder="Member Serial" readonly tabindex="-1" />
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="club_id" class="col-sm-3 col-form-label">Club</label>
                          <div class="col-sm-5 pr-0">
                            <input type="hidden" id="club_id" name="club_id" value="{{ auth()->user()->club->id }}" />
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('club_id') ? 'is-invalid' : '' }}" id="club_name" value="{{ auth()->user()->club->name }}" />
                            @error('club_id')
                            <div class="invalid-feedback">
                              {{$errors->first('club_id')}}
                            </div>
                            @enderror
                          </div>
                          <div class="col-sm-4">
                            <input class="text-uppercase form-control form-control-sm" id="club_code" value="{{ auth()->user()->club->code }}" readonly tabindex="-1" />
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="categoryid" class="col-sm-3 col-form-label">Category</label>
                          <div class="col-sm-9">
                            <select class="text-uppercase form-control form-control-sm {{ $errors->has('categoryid') ? 'is-invalid' : ''}}" id="categoryid" name="categoryid" required>
                              <option value="">-----------</option>
                              @foreach($categories as $category)
                              <option value="{{$category->code}}" {{ old('categoryid') == $category->code ? "selected" : "" }}>{{$category->des}}</option>
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
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('typeid') ? 'is-invalid' : ''}}" id="typeid" name="typeid" value="{{ old('typeid') }}" placeholder="Member Type" required data-parsley-pattern="[0-9]+$" data-parsley-trigger="keyup" data-parsley-required-message="Required!" />
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
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('membername') ? 'is-invalid' : ''}}" value="{{ old('membername') }}" maxlength="99" id="membername" name="membername" placeholder="Member Name" required />
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
                            <input class="text-uppercase form-control form-control-sm" id="memberfname" maxlength="99" name="memberfname" value="{{ old('memberfname') }}" placeholder="Husband / Father's Name" />
                          </div>
                        </div>
                        <div class="form-group row mb-0 required">
                          <label for="cnic" class="col-sm-3 col-form-label">CNIC</label>
                          <div class="col-sm-9">
                            <input class="text-uppercase form-control form-control-sm {{ $errors->has('cnic') ? 'is-invalid' : ''}}" id="cnic" maxlength="17" name="cnic" value="{{ old('cnic') }}" placeholder="00000-0000000-0" data-inputmask="'mask': ['99999-9999999-9', '999999-999999-9']" data-mask required />
                            @error('cnic')
                            <div class="invalid-feedback">
                              {{$errors->first('cnic')}}
                            </div>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="pano" class="col-sm-3 col-form-label">PA No.</label>
                          <div class="col-sm-9">
                            <input value="{{ old('pano') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('pano') ? 'is-invalid' : ''}}" id="pano" maxlength="8" name="pano" placeholder="PA Number" />
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
                              <img class="img" id="member_pic_img" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="230" alt="Photograph" style="cursor: pointer;" />
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="col text-center justify-content-center align-self-center">
                              <img class="img" id="member_sign_img" src="{{ asset('dist/img/sign-placeholder.png') }}" alt="Signature" width="230px" style="cursor: pointer;" />
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
                            <input value="{{ old('occupationid') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('occupationid') ? 'is-invalid' : ''}}" id="occupationid" name="occupationid" placeholder="Profession" />
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
                            <input value="{{ old('rank') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('rank') ? 'is-invalid' : ''}}" id="rank" maxlength="200" name="rank" placeholder="Rank" />
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
                            <input value="{{ old('department') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('department') ? 'is-invalid' : ''}}" id="department" maxlength="200" name="department" placeholder="Department" />
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
                            <input value="{{ old('organisation') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('organisation') ? 'is-invalid' : ''}}" id="organisation" maxlength="100" name="organisation" placeholder="Organisation" />
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
                            <input type="date" class="text-uppercase form-control form-control-sm date-input {{ $errors->has('dob') ? 'is-invalid' : ''}}" value="{{ old('dob') }}" id="dob" name="dob" required data-date="" data-date-format="DD-MMM-YYYY" />
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
                              <input class="form-check-input" value="Y" type="radio" name="married" id="married_yes" checked />
                              <label class="form-check-label" for="married_yes">Yes</label>
                            </div>
                          </div>
                          <div class="form-group col-sm-3">
                            <div class="form-check">
                              <input class="form-check-input" value="N" type="radio" id="married_no" name="married" />
                              <label class="form-check-label" for="married_no">No</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="otherinfo" class="col-sm-3 col-form-label">Other Info</label>
                          <div class="col-sm-4 pr-0">
                            <input value="{{ old('otherinfo') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('otherinfo') ? 'is-invalid' : ''}}" id="otherinfo" name="otherinfo" maxlength="100" />
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
                              <option value="{{$type['value']}}" {{ $type['selected'] == true ? 'selected' : '' }}>{{ $type['label'] }}</option>
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
                              @foreach ($statuses as $st)
                              <option value="{{$st['value']}}" {{ $st['selected'] == true ? 'selected' : '' }}>{{ $st['label'] }}</option>
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
                              <option value="{{$bs['value']}}" {{ $bs['selected'] == true ? 'selected' : '' }}>{{ $bs['label'] }}</option>
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
                          <label for="from_date" class="col-sm-3 col-form-label">From Date</label>
                          <div class="col-sm-3">
                            <input type="date" class="text-uppercase form-control form-control-sm" id="from_date" name="from_date" />
                          </div>
                          <label for="to_date" class="col-sm-3 col-form-label">To Date</label>
                          <div class="col-sm-3">
                            <input type="date" class="text-uppercase form-control form-control-sm" id="to_date" name="to_date" />
                          </div>
                        </div>
                        <div class="form-group row mb-1">
                          <label for="remarks" class="col-sm-3 col-form-label">Block Remarks</label>
                          <div class="col-sm-9">
                            <textarea name="remarks" id="remarks" rows="3" class="text-uppercase form-control textarea" style="resize: none;" placeholder="Block Remarks">{{ old('remarks') }}</textarea>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                          <label for="membershipdate" class="col-sm-3 col-form-label">Membership Date</label>
                          <div class="col-sm-9">
                            <input value="{{ old('membershipdate') }}" type="date" class="text-uppercase form-control form-control-sm {{ $errors->has('membershipdate') ? 'is-invalid' : ''}}" id="membershipdate" name="membershipdate" />
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
                            <input value="{{ old('cardissuedate') }}" type="date" class="text-uppercase form-control form-control-sm {{ $errors->has('cardissuedate') ? 'is-invalid' : ''}}" id="cardissuedate" name="cardissuedate" />
                            @error('cardissuedate')
                            <div class="invalid-feedback">
                              {{$errors->first('cardissuedate')}}
                            </div>
                            @enderror
                          </div>
                          <label for="cardexpirydate" class="col-sm-3 col-form-label">Expiry Date</label>
                          <div class="col-sm-3">
                            <input value="{{ old('cardexpirydate') }}" type="date" class="text-uppercase form-control form-control-sm {{ $errors->has('cardexpirydate') ? 'is-invalid' : ''}}" id="cardexpirydate" name="cardexpirydate" />
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
                </div>

                <div class="tab-pane fade" id="member-tabs-contact" role="tabpanel" aria-labelledby="member-tabs-contact-tab">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group row mb-0">
                          <label for="phoneoffice" class="col-sm-3 col-form-label">Phone (Office)</label>
                          <div class="col-sm-9">
                            <input value="{{ old('phoneoffice') }}" id="phoneoffice" name="phoneoffice" class="text-uppercase form-control form-control-sm {{ $errors->has('phoneoffice') ? 'is-invalid' : ''}}" placeholder="Phone (Office)" maxlength="60" />
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
                            <textarea name="mailingaddress" id="mailingaddress" rows="3" class="text-uppercase form-control {{ $errors->has('mailingaddress') ? 'is-invalid' : ''}}" style="resize: none;" placeholder="Mailing Address" maxlength="500">{{ old('mailingaddress') }}</textarea>
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
                            <input value="{{ old('phoneresidence') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('phoneresidence') ? 'is-invalid' : ''}}" id="phoneresidence" name="phoneresidence" placeholder="Phone (Residence)" maxlength="60" />
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
                            <textarea name="workingaddress" id="workingaddress" rows="3" class="text-uppercase form-control {{ $errors->has('workingaddress') ? 'is-invalid' : ''}}" style="resize: none;" placeholder="Working Address" maxlength="500">{{ old('workingaddress') }}</textarea>
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
                            <input value="{{ old('mobileno') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('mobileno') ? 'is-invalid' : ''}}" id="mobileno" name="mobileno" placeholder="Mobile No" maxlength="20" />
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
                          <label for="mobileno2" class="col-sm-3 col-form-label">Mobile No 2.</label>
                          <div class="col-sm-9">
                            <input value="{{ old('mobileno2') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('mobileno2') ? 'is-invalid' : ''}}" id="mobileno2" name="mobileno2" placeholder="Mobile No 2" maxlength="100" readonly />
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
                            <input value="{{ old('fax') }}" class="text-uppercase form-control form-control-sm {{ $errors->has('fax') ? 'is-invalid' : ''}}" id="fax" name="fax" placeholder="Fax" maxlength="20" />
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
                            <input value="{{ old('email') }}" type="email" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" placeholder="Email" maxlength="50" />
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
                <div class="tab-pane fade" id="member-tabs-family" role="tabpanel" aria-labelledby="member-tabs-family-tab">
                  <h3>Please save member before adding the family members...</h3>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-outline-secondary ">Cancel</button>
              <button type="submit" class="btn btn-primary float-right text-white"><i class="fas fa-save mr-2"></i>Save</button>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </form>

</div>
<!-- /.content -->

@include('lovs.professions')
@include('lovs.membertypes')
@stop

@push('custom-scripts')
<script>
  // const profile_pic = "{{ asset('dist/img/profile_pic01.jpg') }}";
  // const sign_pic = "{{ asset('dist/img/sign-placeholder.png') }}";
  const create_page_url = "{{ route('member.create') }}";
</script>
<script src="{{ asset('dist/js/common/next_field_on_enter.js') }}" defer></script>
<script src="{{ asset('dist/js/members/membercommon.js') }}" defer></script>
<script src="{{ asset('dist/js/members/create.js') }}" defer></script>
@endpush