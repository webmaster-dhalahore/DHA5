<div class="modal fade" id="lov_members">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Members List</h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row mb-1">
          <label for="member_search_input" class="col-sm-3 col-form-label">Find</label>
          <div class="col-sm-9">
            <input class="form-control form-control-sm text-uppercase" id="member_search_input" name="member_search_input" placeholder="Search..." autofocus />
          </div>
        </div>

        <div class="row lovTable">
          <div class="col-sm-12" id="lovMembersTable"></div>
        </div>
        <div class="row">
          <div class="col-sm-3" id="member_count">
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between border-top-0">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

@push('custom-scripts')
<script>
  var members_lov_route = "{{ route('apis.members_lov') }}";
  var get_member_route = "{{ route('apis.getMemberBySR') }}";
</script>
<script src="{{ asset('dist/js/lovs/memberslov.js') }}" defer></script>
@endpush