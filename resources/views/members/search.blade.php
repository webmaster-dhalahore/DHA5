@extends('layouts.admin', ['title'=> 'Members', 'page_title' => 'Member Advanced Search'])

<?php
$memberid = request()->has('memberid') ? request()->input('memberid') : '';
$categoryid = request()->has('categoryid') ? request()->input('categoryid') : '';
?>

@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <form class="needs-validation" action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data" id="form">
      @csrf
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Member Advanced Search</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" id="collapse" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 mb-0">
                  <div class="form-group row mb-0">
                    <label for="memberid" class="col-sm-3 col-form-label">Member ID</label>
                    <div class="col-sm-9">
                      <input class="form-control form-control-sm" value="{{ old('memberid', $memberid) }}" autocomplete="off" maxlength="20" id="memberid" name="memberid" placeholder="Member ID" aria-describedby="memberid_feedback" style="text-transform:uppercase" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="club_id" class="col-sm-3 col-form-label">Club</label>
                    <div class="col-sm-5 pr-0">
                      <select class="form-control form-control-sm " id="club_id" name="club_id">
                        @foreach($clubs as $club)
                        <option value="{{$club->id}}" data-code="{{$club->code}}" {{ old("club_id") == $club->id ? "selected" : "" }}>{{$club->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <input class="form-control form-control-sm" id="club_code" value="" readonly tabindex="-1" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="categoryid" class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                      <select class="form-control form-control-sm " id="categoryid" name="categoryid">
                        <option value="">-----------</option>
                        @foreach($categories as $category)
                        <option value="{{$category->code}}" {{ old('categoryid', $categoryid) == $category->code ? "selected" : "" }}>{{$category->des}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="typeid" class="col-sm-3 col-form-label">Member Type</label>
                    <div class="col-sm-2 pr-0">
                      <input class="form-control form-control-sm" id="typeid" name="typeid" value="{{ old('typeid') }}" placeholder="Member Type" />
                    </div>
                    <div class="col-sm-6 pr-0">
                      <input class="form-control form-control-sm" id="member_type_desc" name="member_type_desc" readonly tabindex="-1" />
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="openMemberTypeLOV()"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="membername" class="col-sm-3 col-form-label">Member Name</label>
                    <div class="col-sm-9">
                      <input class="form-control form-control-sm" value="{{ old('membername') }}" maxlength="99" id="membername" name="membername" placeholder="Member Name" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="memberfname" class="col-sm-5 col-form-label">Husband / Father's Name</label>
                    <div class="col-sm-5">
                      <input class="form-control form-control-sm" id="memberfname" maxlength="99" name="memberfname" value="{{ old('memberfname') }}" placeholder="Husband / Father's Name" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="memberfname_blank" name="memberfname_blank" />
                        <label for="memberfname_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="cnic" class="col-sm-3 col-form-label">CNIC</label>
                    <div class="col-sm-7">
                      <input class="form-control form-control-sm" id="cnic" maxlength="17" name="cnic" value="{{ old('cnic') }}" placeholder="00000-0000000-0" data-inputmask="'mask': ['99999-9999999-9', '999999-999999-9']" data-mask />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="cnic_blank" name="cnic_blank" />
                        <label for="cnic_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="pano" class="col-sm-3 col-form-label">PA No.</label>
                    <div class="col-sm-7">
                      <input value="{{ old('pano') }}" class="form-control form-control-sm" id="pano" maxlength="8" name="pano" placeholder="PA Number" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="pano_blank" name="pano_blank" />
                        <label for="pano_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="occupationid" class="col-sm-3 col-form-label">Profession</label>
                    <div class="col-sm-2 pr-0">
                      <input value="{{ old('occupationid') }}" class="form-control form-control-sm {{ $errors->has('occupationid') ? 'is-invalid' : ''}}" id="occupationid" name="occupationid" placeholder="Profession" />
                    </div>
                    <div class="col-sm-4 pr-0">
                      <input value="{{ old('profession_desc') }}" class="form-control form-control-sm {{ $errors->has('occupationid') ? 'is-invalid' : ''}}" id="profession_desc" name="profession_desc" readonly tabindex="-1" />
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-sm btn-secondary btn-block" onclick="openProfessionsLOV()"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="occupationid_blank" name="occupationid_blank" />
                        <label for="occupationid_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="department" class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-7">
                      <input value="{{ old('department') }}" class="form-control form-control-sm {{ $errors->has('department') ? 'is-invalid' : ''}}" id="department" maxlength="200" name="department" placeholder="Department" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="department_blank" name="department_blank" />
                        <label for="department_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="organisation" class="col-sm-3 col-form-label">Organisation</label>
                    <div class="col-sm-7">
                      <input value="{{ old('organisation') }}" class="form-control form-control-sm {{ $errors->has('organisation') ? 'is-invalid' : ''}}" id="organisation" maxlength="100" name="organisation" placeholder="Organisation" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="organisation_blank" name="organisation_blank" />
                        <label for="organisation_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="dob" class="col-sm-3 col-form-label">Date of Birth</label>
                    <div class="col-sm-7">
                      <input type="date" class="form-control form-control-sm {{ $errors->has('dob') ? 'is-invalid' : ''}}" value="{{ old('dob') }}" id="dob" name="dob" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="dob_blank" name="dob_blank" />
                        <label for="dob_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="married" class="col-sm-3 col-form-label">Married</label>
                    <div class="col-sm-9">
                      <select class="form-control form-control-sm {{ $errors->has('married') ? 'is-invalid' : ''}}" id="married" name="married">
                        <option value="">-----------</option>
                        <option value="Y">YES</option>
                        <option value="N">NO</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="otherinfo" class="col-sm-3 col-form-label">Other Info</label>
                    <div class="col-sm-4">
                      <input value="{{ old('otherinfo') }}" class="form-control form-control-sm {{ $errors->has('otherinfo') ? 'is-invalid' : ''}}" id="otherinfo" name="otherinfo" maxlength="100" />
                    </div>
                    <label for="membertype" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm {{ $errors->has('membertype') ? 'is-invalid' : ''}}" id="membertype" name="membertype">
                        <option value="">-----------</option>
                        @foreach ($other_types as $type)
                        <option value="{{$type['value']}}" {{ $type['selected'] == true ? 'selected' : '' }}>{{ $type['label'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row mb-0">
                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm {{ $errors->has('status') ? 'is-invalid' : ''}}" id="status" name="status">
                        <option value="">-----------</option>
                        @foreach ($statuses as $st)
                        <option value="{{$st['value']}}">{{ $st['label'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <label for="blockstatus" class="col-sm-3 col-form-label">Block Status</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm {{ $errors->has('blockstatus') ? 'is-invalid' : ''}}" id="blockstatus" name="blockstatus">
                        <option value="">-----------</option>
                        @foreach ($block_statuses as $bs)
                        <option value="{{$bs['value']}}">{{ $bs['label'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group row mb-0">
                    <label for="block_from_from_date" class="col-sm-3 col-form-label">Block From Date</label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control form-control-sm" id="block_from_from_date" name="block_from_from_date" />
                    </div>
                    <label for="block_from_to_date" class="col-sm-3 col-form-label">Block From: To Date</label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control form-control-sm" id="block_from_to_date" name="block_from_to_date" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="block_to_from_date" class="col-sm-3 col-form-label">Block To: From Date</label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control form-control-sm" id="block_to_from_date" name="block_to_from_date" />
                    </div>
                    <label for="block_to_to_date" class="col-sm-3 col-form-label">Block To Date</label>
                    <div class="col-sm-3">
                      <input type="date" class="form-control form-control-sm" id="block_to_to_date" name="block_to_to_date" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="remarks" class="col-sm-3 col-form-label">Block Remarks</label>
                    <div class="col-sm-9">
                      <input value="{{ old('remarks') }}" class="form-control form-control-sm {{ $errors->has('remarks') ? 'is-invalid' : ''}}" id="remarks" name="remarks" placeholder="Block Remarks" />
                    </div>
                  </div>

                  <div class="form-group row mb-0">
                    <label for="membershipfromdate" class="col-sm-3 col-form-label">M'ship From Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('membershipfromdate') }}" type="date" class="form-control form-control-sm {{ $errors->has('membershipfromdate') ? 'is-invalid' : ''}}" id="membershipfromdate" name="membershipfromdate" />
                    </div>
                    <label for="membershiptodate" class="col-sm-3 col-form-label">M'ship To Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('membershiptodate') }}" type="date" class="form-control form-control-sm {{ $errors->has('membershiptodate') ? 'is-invalid' : ''}}" id="membershiptodate" name="membershiptodate" max="<?= date('Y-m-d'); ?>" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="card_issue_from_date" class="col-sm-3 col-form-label">Card Issue Fr Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('card_issue_from_date') }}" type="date" class="form-control form-control-sm {{ $errors->has('card_issue_from_date') ? 'is-invalid' : ''}}" id="card_issue_from_date" name="card_issue_from_date" />
                    </div>
                    <label for="card_issue_to_date" class="col-sm-3 col-form-label">Issue To Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('card_issue_to_date') }}" type="date" class="form-control form-control-sm {{ $errors->has('card_issue_to_date') ? 'is-invalid' : ''}}" id="card_issue_to_date" name="card_issue_to_date" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="card_expiry_from_date" class="col-sm-3 col-form-label">Card Exp Fr Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('card_expiry_from_date') }}" type="date" class="form-control form-control-sm {{ $errors->has('card_expiry_from_date') ? 'is-invalid' : ''}}" id="card_expiry_from_date" name="card_expiry_from_date" />
                    </div>
                    <label for="card_expiry_to_date" class="col-sm-3 col-form-label">Expiry To Date</label>
                    <div class="col-sm-3">
                      <input value="{{ old('card_expiry_to_date') }}" type="date" class="form-control form-control-sm {{ $errors->has('card_expiry_to_date') ? 'is-invalid' : ''}}" id="card_expiry_to_date" name="card_expiry_to_date" />
                    </div>
                  </div>

                  <div class="form-group row mb-0">
                    <label for="phoneoffice" class="col-sm-3 col-form-label">Phone (Office)</label>
                    <div class="col-sm-3">
                      <input value="{{ old('phoneoffice') }}" id="phoneoffice" name="phoneoffice" class="form-control form-control-sm {{ $errors->has('phoneoffice') ? 'is-invalid' : ''}}" placeholder="Phone (Office)" maxlength="20" />
                    </div>
                    <label for="phoneresidence" class="col-sm-3 col-form-label">Phone (Residence)</label>
                    <div class="col-sm-3">
                      <input value="{{ old('phoneresidence') }}" class="form-control form-control-sm {{ $errors->has('phoneresidence') ? 'is-invalid' : ''}}" id="phoneresidence" name="phoneresidence" placeholder="Phone (Residence)" maxlength="20" />
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="mailingaddress" class="col-sm-3 col-form-label">Mailing Address</label>
                    <div class="col-sm-7">
                      <input value="{{ old('mailingaddress') }}" class="form-control form-control-sm {{ $errors->has('mailingaddress') ? 'is-invalid' : ''}}" id="mailingaddress" name="mailingaddress" placeholder="Mailing Address" maxlength="500" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="mailingaddress_blank" name="mailingaddress_blank" />
                        <label for="mailingaddress_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="workingaddress" class="col-sm-3 col-form-label">Working Address</label>
                    <div class="col-sm-7">
                      <input value="{{ old('workingaddress') }}" class="form-control form-control-sm {{ $errors->has('workingaddress') ? 'is-invalid' : ''}}" id="workingaddress" name="workingaddress" placeholder="Working Address" maxlength="500" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="workingaddress_blank" name="workingaddress_blank" />
                        <label for="workingaddress_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="mobileno" class="col-sm-3 col-form-label">Mobile No.</label>
                    <div class="col-sm-7">
                      <input value="{{ old('mobileno') }}" class="form-control form-control-sm {{ $errors->has('mobileno') ? 'is-invalid' : ''}}" id="mobileno" name="mobileno" placeholder="Mobile No" maxlength="20" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="mobileno_blank" name="mobileno_blank" />
                        <label for="mobileno_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="fax" class="col-sm-3 col-form-label">Fax</label>
                    <div class="col-sm-7">
                      <input value="{{ old('fax') }}" class="form-control form-control-sm {{ $errors->has('fax') ? 'is-invalid' : ''}}" id="fax" name="fax" placeholder="Fax" maxlength="20" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="fax_blank" name="fax_blank" />
                        <label for="fax_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row mb-0">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                      <input value="{{ old('email') }}" type="text" class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" placeholder="Email" maxlength="50" />
                    </div>
                    <div class="col-2">
                      <div class="icheck-primary">
                        <input type="checkbox" id="email_blank" name="email_blank" />
                        <label for="email_blank">Blank</label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-3 mt-5">
                  <button type="reset" class="btn btn-secondary btn-block"><i class="fas fa-times mr-2"></i> Reset</button>
                </div>
                <div class="col-sm-9 mt-5">
                  <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search mr-2"></i>SEARCH</button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-sm-12">
        <!-- <div id="loaderdiv"></div> -->
        <div class="d-none" id="loaderdiv"><span>Loading...</span></div>
        <div class="card card-teal card-outline d-none" id="tableDivSearchResults">
          <div class="card-header">
            <h3 class="card-title">Member Advanced Search Results</h3>
            <div class="float-right" id="search_criteria">
              <button class="btn btn-outline-primary btn-sm" type="button" id="btnSearchAgain">Searh again</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-sm" id="adv_seaarch_results_tbl">
              <thead>
                <tr id="adv-search-tbl-th-tr">
                  <th width="1px">SR</th>
                  <th>Member ID</th>
                  <th>Member Name</th>
                  <th>Father / Husband Name</th>
                  <th>Category</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Block Status</th>
                  <th>Block From Date</th>
                  <th>Block To Date</th>
                  <th>Block Remarks</th>
                  <th>CNIC</th>
                  <th>Email</th>
                  <th>PANO</th>
                  <th>Working Address</th>
                  <th>Mailing Address</th>
                  <th>Mobile</th>
                  <th>Phone Office</th>
                  <th>Phone Residence</th>
                  <th>Fax</th>
                  <th>Prfoession</th>
                  <th>Department</th>
                  <th>Organisation</th>
                  <th>DOB</th>
                  <th>Age</th>
                  <th>Married</th>
                  <th>Membership Date</th>
                  <th>Card Issue Date</th>
                  <th>Card Expiry Date</th>
                  <th>Other Info</th>
                  <th>Member Type</th>
                  <th width="1px" data-orderable="false">ACT</th>
                </tr>
              </thead>
              <tbody id="adv-search-tbl-body">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->

</div>
<!-- /.content -->

@include('lovs.professions')
@include('lovs.membertypes')
@stop

@push('custom-scripts')
<script>
  const is_super = "{{ auth()->user()->hasRole(getSU()) }}";
  const submitSearchURL = "{{ route('member.submitSearch') }}";
</script>
<script src="{{ asset('dist/js/common/functions.js') }}" defer></script>
<script src="{{ asset('dist/js/members/reports/advancedSearch.js') }}" defer></script>
@endpush

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush