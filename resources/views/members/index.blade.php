@extends('layouts.admin', ['title'=> 'All Member', 'page_title' => 'Members List', 'icon' => '<i class="fas fa-address-card text-primary mr-1"></i>'])

@section('buttons')
<a href="{{ route('member.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-user-plus mr-1"></i> Create new Member</a>
@stop

@section('content')
<style>
  .table-sm {
    font-size: 15px;
  }
</style>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <table class="table table-bordered table-sm" id="members-table">
          <thead>
            <tr>
              <th>SR</th>
              <th>Member ID</th>
              <th>Member Name</th>
              <th>Category</th>
              <th>Type</th>
              <th>Status</th>
              <th>Block Status</th>
              <th>Mobile</th>
              <th>CNIC</th>
              <th>Address</th>
              <th>Email</th>
              <!-- <th width="1">Actions</th> -->
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@stop

@push('custom-scripts')
<script src="{{ asset('dist/js/members/index.js') }}" defer></script>
<script src="{{ asset('dist/js/common/datatables.functions.js') }}" defer></script>
<script>
  const dataRoute = "{!! route('member.getMembers') !!}";
  const initialSearchTerm = "{{ app('request')->filled('search') ? app('request')->input('search')  : '' }}"
</script>
@endpush