@extends('layouts.admin', ['title'=> 'Members Summary', 'page_title' => 'Members Summary'])


@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline">

          <div class="card-body">
            <table class="table table-bordered table-sm" id="table">
              <thead>
                <tr>
                  <th width="1px" class="export">SR</th>
                  <th class="text-center export">Type</th>
                  <th class="export">Description</th>
                  <th class="text-right export">Count</th>
                  <th class="text-center">Details</th>
                  <th class="text-center">Types</th>
                </tr>
              </thead>
              <tbody id="search_results_tbl_body">
                @foreach($member_summary as $summary)
                <tr>
                  <td class="align-middle" widtd="1px">{{$loop->iteration}}</td>
                  <td class="align-middle text-center">{{ $summary->memberabbr }}</td>
                  <td class="align-middle">{{ $summary->membertype }}</td>
                  <td class="align-middle text-right">{{ $summary->countmembers }}</td>
                  <td class="align-middle text-center">
                    <a href="{{ route('member.reports.memberSummaryType', ['categoryid' => $summary->categoryid]) }}" class="btn disabled btn-outline-primary btn-sm">Details</a>
                  </td>
                  <td class="align-middle text-center">
                    <a href="{{ route('member.reports.memberSummaryType', ['categoryid' => $summary->categoryid]) }}" class="btn btn-outline-success btn-sm">Types</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <!-- <div id="loaderdiv"></div> -->
        <div class="d-none" id="loaderdiv"><span>Loading...</span></div>
        <div class="card card-primary card-outline d-none" id="tableDivSearchResults">
          <div class="card-body">
            <table class="table table-bordered table-sm" id="search_results_tbl">
              <thead>
                <tr>
                  <th width="1px">SR</th>
                  <th>Member Name</th>
                  <th>Member ID</th>
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
<script>
  const print_page_title = `Member Summary`;
</script>
<script src="{{ asset('dist/js/members/reports/summary.js') }}" defer></script>
@endpush

@push('custom-styles')
<link rel="stylesheet" href="{{ asset('dist/custom_css/members/loader.css') }}">
@endpush