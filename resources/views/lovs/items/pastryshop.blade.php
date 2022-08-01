<div class="modal fade" id="lov_ps_items">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Pastryshop Item List</h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row mb-1">
          <label for="item_search_input" class="col-sm-3 col-form-label">Find</label>
          <div class="col-sm-9">
            <input class="form-control form-control-sm text-uppercase" id="item_search_input" name="item_search_input" placeholder="Search..." onkeyup="searchPSItems(event)" autofocus />
          </div>
        </div>

        <div class="row lovTable">
          <div class="col-sm-12" id="lovPSItemTable"></div>
        </div>
        <div class="row">
          <div class="col-sm-3" id="items_count">
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
  var item_route = "{{ route('apis.ps_items') }}";
</script>
<script src="{{ asset('dist/js/lovs/ps_items.js') }}" defer></script>
@endpush