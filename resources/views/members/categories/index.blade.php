@extends('layouts.admin', ['title'=> 'Member Categories', 'page_title' => 'Member Categories'])

@section('buttons')
<button type="button" id="add_new_member_category" class="btn btn-sm btn-primary">
  <i class="fas fa-plus mr-1"></i> Add new Member Category
</button>
@stop

@section('content')

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <table class="table table-bordered table-sm" id="category-table">
          <thead>
            <tr>
              <th>CODE</th>
              <th>DESCRIPTION</th>
              <th>ABBR</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $category)
            <?php $code = $category->code ?>
            <tr>
              <td class="align-middle">{{$code}}</td>
              <td class="align-middle">{{$category->des}}</td>
              <td class="align-middle">{{$category->abbr}}</td>
              <td class="text-center">
                <button class="btn btn-sm btn-primary" onclick="edit('{{$code}}', '{{$category->des}}', '{{$category->abbr}}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteCategory('{{$code}}')">
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

  @include('members.categories.create_category_modal')
  @include('members.categories.edit_category_modal')
</div>
<!-- /.content -->


@stop

@push('custom-scripts')
<script>
  const route_home = "{{ route('member.categories.index') }}";
  const delete_route = "{{ route('member.categories.destroy') }}";
  // const csrf_token = "{{ csrf_token() }}";
</script>
<script src="{{ asset('dist/js/members/member_categories.js') }}" defer></script>
@endpush