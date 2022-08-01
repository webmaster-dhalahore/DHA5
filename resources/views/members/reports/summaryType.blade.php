<?php
$category_name = $category ? '(' . $category->des . ')' : '';
$page_title = "Members Summary $category_name";
?>
@extends('layouts.admin', ['title'=> $page_title, 'page_title' => $page_title])

@section('buttons')
<button onclick="history.back()" class="btn btn-sm btn-secondary"><i class="fas fa-backward"></i> Go Back</button>
@include('members.includes.homeButton')
@stop

@section('content')
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Members Summary {{ $category_name }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" id="collapse" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-sm" id="table">
              <thead>
                <tr>
                  <th width="1px" class="export">SR</th>
                  <th class="text-center export">Type</th>
                  <th class="export">Description</th>
                  <th class="text-right export">Count</th>
                  <!-- <th class="text-center">Details</th>
                  <th class="text-center">Types</th> -->
                </tr>
              </thead>
              <tbody id="search_results_tbl_body">
                @foreach($result as $summary)
                <tr>
                  <td class="align-middle" widtd="1px">{{$loop->iteration}}</td>
                  <td class="align-middle text-center">{{ $summary->memberabbr }}</td>
                  <td class="align-middle">{{ $summary->des }}</td>
                  <td class="align-middle text-right">{{ $summary->countmembers }}</td>
                  <!-- <td class="align-middle text-center">
                    <a href="#" class="btn btn-outline-primary btn-sm">Details</a>
                  </td>
                  <td class="align-middle text-center">
                    <a href="#" class="btn btn-outline-success btn-sm">Types</a>
                  </td> -->
                </tr>
                @endforeach
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
  const category = "{{$category_name}}";
  const print_page_title = `Member Summary ${category}`;
</script>
<script src="{{ asset('dist/js/members/reports/summary.js') }}" defer></script>
@endpush