@extends('layouts.admin', ['title'=> 'Members Age Wise', 'page_title' => 'Members Age Wise'])


@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <form class="needs-validation" action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data" id="form">
      @csrf
      <div class="row">
        <div class="col-12 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 mb-0">
                  <div class="form-group row mb-0">
                    <div class="col-sm-6"></div>
                    <label for="from_age" class="col-sm- col-form-label">From Age</label>
                    <div class="col-sm-4">
                      <input class="form-control form-control-sm" value="{{ old('from_age') }}" autocomplete="off" maxlength="20" id="from_age" name="from_age" placeholder="Starting Age" required />
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row mb-0">
                    <label for="to_age" class="col-sm- col-form-label">To Age</label>
                    <div class="col-sm-4">
                      <input value="{{ old('to_age') }}" class="form-control form-control-sm {{ $errors->has('to_age') ? 'is-invalid' : ''}}" id="to_age" name="to_age" placeholder="Ending Age" required />
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
        <div class="card card-primary card-outline d-none" id="tableDivSearchResults">
          <h3 class="text-center mt-4">Members Age Wise</h3>
          <div class="card-body px-1 py-0">
            <table class="table table-bordered table-sm" id="search_results_tbl">
              <thead>
                <tr>
                  <th width="1px">SR</th>
                  <th>Member Name</th>
                  <th>MemberID</th>
                  <th>Membership Date</th>
                  <th>DOB</th>
                  <th>Year</th>
                  <th>Month</th>
                  <th>Days</th>
                  <th>Mailing Address</th>
                </tr>
              </thead>
              <tbody id="search_results_tbl_body">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->

</div>
<!-- /.content -->
@stop

@push('custom-scripts')
<script src="{{ asset('dist/js/members/reports/agewise.js') }}" defer></script>
@endpush

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush