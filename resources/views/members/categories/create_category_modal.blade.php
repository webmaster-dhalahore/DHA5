<div class="modal fade" id="category_modal">
  <form action="{{ route('member.categories.store') }}" method="POST" id="category_form">
    @csrf
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="mb-0" id="modal-title">Add New Member Category</h5>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="category_modal_body">
          <div class="form-group row mb-0 required">
            <label for="member_category" class="col-sm-4 col-form-label">Member Category</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm uppercase" id="member_category" name="member_category" placeholder="Member Category" maxlength="100" required />
              <div class="invalid-feedback" id="ifb_member_category"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="member_abbr" class="col-sm-4 col-form-label">Abbreviation</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm uppercase" id="member_abbr" name="member_abbr" placeholder="Member Category Abbreviation" maxlength="5" required />
              <div class="invalid-feedback" id="ifb_member_abbr"></div>
            </div>
          </div>
          <div class="modal-footer justify-content-between border-top-0">
            <button type="button" class="btn bg-teal btn-sm" data-bs-dismiss="modal">
              <i class="fas fa-power-off mr-2"></i> Close Window
            </button>
            <button type="submit" id="btn_submit_category" class="btn btn-primary btn-sm">
              <i class="fas fa-save mr-2 "></i> <span id="btn_submit_category_span"> Save Changes</span>
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </form>
</div>