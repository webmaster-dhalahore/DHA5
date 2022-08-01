<div class="modal fade" id="types_modal">
  <form action="{{ route('member.types.store') }}" method="POST" id="types_form">
    @csrf
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="mb-0" id="modal-title">Add New Member Type</h5>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="types_modal_body">
          <div class="form-group row mb-0">
            <label for="member_type" class="col-sm-4 col-form-label">Member Type</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm uppercase" id="member_type" name="member_type" placeholder="Member Type" maxlength="100" required />
              <div class="invalid-feedback" id="ifb_member_type"></div>
            </div>
          </div>

          <div class="modal-footer justify-content-between border-top-0">
            <button type="button" class="btn bg-teal btn-sm" data-bs-dismiss="modal">
              <i class="fas fa-power-off mr-2"></i> Close Window
            </button>
            <button type="submit" id="btn_submit_type" class="btn btn-primary btn-sm">
              <i class="fas fa-save mr-2 "></i> <span id="btn_submit_type_span">Save Changes</span>
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </form>
</div>