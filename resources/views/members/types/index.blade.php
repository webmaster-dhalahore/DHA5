@extends('layouts.admin', ['title'=> 'Member Types', 'page_title' => 'Member Types'])

@section('buttons')
<button type="button" id="add_new_member_type" class="btn btn-sm btn-primary">
  <i class="fas fa-plus mr-1"></i> Add new Member Type
</button>
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
        <table class="table table-bordered table-sm" id="member-types-table">
          <thead>
            <tr>
              <th>CODE</th>
              <th>DESCRIPTION</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($types as $type)
            <tr>
              <td class="align-middle">{{$type->code}}</td>
              <td class="align-middle">{{$type->des}}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-primary" onclick="edit('{{$type->code}}', '{{$type->des}}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteType('{{$type->code}}')">
                  <i class="fas fa-trash"></i> Delete
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div><!-- /.container-fluid -->



  @include('members.types.create_type_modal')

  @include('members.types.edit_type_modal')
</div>
@stop

@push('custom-scripts')
<script>
  const route_home = "{{ route('member.types.index') }}";
  const delete_route = "{{ route('member.types.destroy') }}";
  // const csrf_token = "{{ csrf_token() }}";
  // console.log(csrf_token, delete_route);
</script>
<script src="{{ asset('dist/js/members/member_types.js') }}" defer></script>
@endpush