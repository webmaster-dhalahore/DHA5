<div class="modal fade" id="category_modal_edit">
  <form action="{{ route('member.categories.update') }}" method="POST" id="category_form_edit">
    @csrf
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="mb-0">Edit : <strong id="edit_des"></strong></h5>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="category_modal_edit_body">
          <div class="form-group row mb-0 required">
            <label for="member_category_edit" class="col-sm-4 col-form-label">Member Category</label>
            <div class="col-sm-8">
              <input type="hidden" name="code" id="code" value="" />
              <input class="form-control form-control-sm uppercase" id="member_category_edit" name="member_category_edit" placeholder="Member Category" maxlength="100" required />
              <div class="invalid-feedback" id="ifb_member_category_edit"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="member_abbr_edit" class="col-sm-4 col-form-label">Abbreviation</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm uppercase" id="member_abbr_edit" name="member_abbr_edit" placeholder="Member Category Abbreviation"  required  maxlength="5"/>
              <div class="invalid-feedback" id="ifb_member_abbr_edit"></div>
            </div>
          </div>
          <div class="modal-footer justify-content-between border-top-0">
            <button type="button" class="btn bg-teal btn-sm" data-bs-dismiss="modal">
              <i class="fas fa-power-off mr-2"></i> Close Window
            </button>
            <button type="submit" id="btn_submit_category_edit" class="btn btn-primary btn-sm">
              <i class="fas fa-save mr-2 "></i> <span id="btn_submit_category_edit_span"> Save Changes</span>
            </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </form>
</div>
