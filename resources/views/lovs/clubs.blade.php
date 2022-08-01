<div class="modal fade" id="lov_clubs">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Member Types</h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row mb-1">
          <label for="clubs_search_input" class="col-sm-3 col-form-label">Find</label>
          <div class="col-sm-6">
            <input class="form-control form-control-sm text-uppercase" id="clubs_search_input" name="clubs_search_input" placeholder="Search..." onkeyup="searchClubs(event)" autofocus />
          </div>
          <div class="col-sm-3">
            <button class="btn bg-teal btn-block btn-sm" onclick="refetchClubsData()">
              <i class="fas fa-sync fa-lg mr-2"></i> Refetch
            </button>
          </div>
        </div>

        <div class="row lovTable">
          <div class="col-sm-12" id="lovMTTable"></div>
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
<script src="{{ asset('dist/js/lovs/clubs.js') }}" defer></script>
@endpush