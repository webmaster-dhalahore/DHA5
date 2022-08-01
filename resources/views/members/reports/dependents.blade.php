@extends('layouts.admin', ['title'=> 'Member List Dependents', 'page_title' => 'Member List Dependents'])


@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <form class="needs-validation" action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data" id="form">
      @csrf
      <div class="row d-print-none">
        <div class="col-12 col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 mb-0">
                  <div class="form-group row mb-0">
                    <label for="from_age" class="col-sm-3 col-form-label">From Age :</label>
                    <div class="col-sm-4">
                      <input class="form-control form-control-sm" value="{{ old('from_age') }}" autocomplete="off" maxlength="20" id="from_age" name="from_age" placeholder="Starting Age" required />
                      <div class="invalid-feedback" id="ifb_from_age"></div>
                    </div>
                    <label for="to_age" class="col-sm-2 col-form-label">To Age: </label>
                    <div class="col-sm-3">
                      <input value="{{ old('to_age') }}" class="form-control form-control-sm {{ $errors->has('to_age') ? 'is-invalid' : ''}}" id="to_age" name="to_age" placeholder="Ending Age" required />
                      <div class="invalid-feedback" id="ifb_to_age"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row mb-0">
                    <label for="relation" class="col-sm-3 col-form-label">Relation</label>
                    <div class="col-sm-9" id="relations_div">
                      <select class="form-control form-control-sm" id="relation" name="relation">
                        <option value="WIFE">WIFE</option>
                        <option value="SON" selected>SON</option>
                        <option value="DAUGHTER">DAUGHTER</option>
                        <option value="HUSBAND">HUSBAND</option>
                        <!-- <option value="ALL">ALL</option> -->
                      </select>
                      <div class="invalid-feedback" id="ifb_relation"></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-6 mb-0">
                  <div class="form-group row mb-0">
                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                      <select class="form-control form-control-sm {{ $errors->has('status') ? 'is-invalid' : ''}}" id="status" name="status">
                        @foreach (\App\Models\Membership\Consts::STATUSES as $bs)
                        <option value="{{$bs['value']}}">{{ $bs['label'] }}</option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback" id="ifb_status"></div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row mb-0">
                    <label for="block_status" class="col-sm-3 col-form-label">Block Status</label>
                    <div class="col-sm-9">
                      <select class="form-control form-control-sm {{ $errors->has('block_status') ? 'is-invalid' : ''}}" id="block_status" name="block_status">
                        @foreach (\App\Models\Membership\Consts::BLOCK_STATUSES as $st)
                        <option value="{{$st['value']}}">{{ $st['label'] }}</option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback" id="ifb_block_status"></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-sm-3 mt-2">
                  <button type="reset" class="btn btn-secondary btn-block"><i class="fas fa-times mr-2"></i> Reset</button>
                </div>
                <div class="col-sm-9 mt-2">
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
          <h3 class="text-center mt-4">Member List Dependents</h3>
          <div class="card-body px-1 py-0">
            <table class="table table-bordered table-sm" id="search_results_tbl">
              <thead>
                <tr>
                  <th width="1px">SR</th>
                  <th>Member ID</th>
                  <th>Member Name</th>
                  <th>Member ID</th>
                  <th>Member Name</th>
                  <th>DOB</th>
                  <th>Relation</th>
                  <th>Year</th>
                  <th>Month</th>
                  <th>Days</th>
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
<script src="{{ asset('dist/js/members/reports/dependents.js') }}" defer></script>
@endpush

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush