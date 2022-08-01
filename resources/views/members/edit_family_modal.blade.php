<div class="modal fade" id="modal_family" data-backdrop="static" data-keyboard="false">
  <form action="{{ route('member.family.store') }}" method="POST" id="family_form">
    @csrf
    <input type="hidden" name="member_sr_fk" id="member_sr_fk" value="" />
    <input type="hidden" name="family_vno" id="family_vno" value="" />
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="mb-0">Member Name: <span class="text-primary font-weight-bold" id="span_membername"></span></h5>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row mb-0 required">
            <label for="member_family_id" class="col-sm-4 col-form-label">Member ID</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm" id="member_family_id" name="member_family_id" placeholder="Member ID"  required />
              <div class="invalid-feedback" id="ifb_member_family_id"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="member_family_name" class="col-sm-4 col-form-label">Member Name</label>
            <div class="col-sm-8">
              <input class="form-control form-control-sm" id="member_family_name" name="member_family_name" placeholder="Member Name" required />
              <div class="invalid-feedback" id="ifb_member_family_name"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="credit_allowed" class="col-sm-4 col-form-label">Credit Allowed</label>
            <div class="col-sm-8" id="credit_allowed_div">
              <select class="form-control form-control-sm" id="credit_allowed" name="credit_allowed" required>
                <option value="">-----------</option>
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
              </select>
              <div class="invalid-feedback" id="ifb_credit_allowed"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="member_family_dob" class="col-sm-4 col-form-label">Date of Birth </label>
            <div class="col-sm-8">
              <input type="date" value="" class="form-control form-control-sm" id="member_family_dob" name="member_family_dob" required />
              <div class="invalid-feedback" id="ifb_member_family_dob"></div>
            </div>
          </div>
          <div class="form-group row mb-0 required">
            <label for="member_relation" class="col-sm-4 col-form-label">Relation</label>
            <div class="col-sm-8" id="relations_div">
              <select class="form-control form-control-sm" id="member_relation" name="member_relation" required>
                <option value="">-----------</option>
                @foreach(getRelationsForViews() as $relation)
                  <option value="{{$relation['value']}}" {{$relation["selected"] ? 'selected' : ''}}>{{$relation['label']}}</option>
                @endforeach
              </select>
              <div class="invalid-feedback" id="ifb_member_relation"></div>
            </div>
          </div>
          <div class="form-group row mb-0">
            <label for="member_family_card_issue_date" class="col-sm-4 col-form-label">Card Issue Date </label>
            <div class="col-sm-8">
              <input type="date" value="" class="form-control form-control-sm" id="member_family_card_issue_date" name="member_family_card_issue_date" />
              <div class="invalid-feedback" id="ifb_member_family_card_issue_date"></div>
            </div>
          </div>
          <div class="form-group row mb-0">
            <label for="member_family_card_expiry_date" class="col-sm-4 col-form-label">Card Expiry Date </label>
            <div class="col-sm-8">
              <input type="date" value="" class="form-control form-control-sm" id="member_family_card_expiry_date" name="member_family_card_expiry_date" />
              <div class="invalid-feedback" id="ifb_member_family_card_expiry_date"></div>
            </div>
          </div>
          <div class="form-group row mb-0">
            <label for="membership_form" class="col-sm-4 col-form-label">Form Issued </label>
            <div class="col-sm-8">
            <select class="form-control form-control-sm" id="membership_form" name="membership_form">
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
              </select>
              <div class="invalid-feedback" id="ifb_membership_form"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group row mb-0 mx-auto">
                <label for="member_family_pic" class="col-sm-12 col-form-label text-center">Picture</label>
                <div class="col-sm-8">
                  <input type="file" class="form-control form-control-sm" id="member_family_pic" name="member_family_pic" accept="image/*" style="display: none" />
                  <div class="invalid-feedback" id="ifb_member_family_pic"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row mb-0 mx-auto">
                <label for="member_family_sign" class="col-sm-12 col-form-label text-center">Signature</label>
                <div class="col-sm-8">
                  <input type="file" class="form-control form-control-sm" id="member_family_sign" name="member_family_sign" accept="image/*" style="display: none" />
                  <div class="invalid-feedback" id="ifb_member_family_sign"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-sm-6 mt-2 text-center">
              <img class="img" id="mf_pic" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="200px" alt="Photograph" style="cursor: pointer;" />
            </div>
            <div class="col-sm-6 mt-2 text-center">
              <img class="img" id="mf_sign" src="{{ asset('dist/img/sign-placeholder.png') }}" width="250px" alt="Signature" style="cursor: pointer" />
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between border-top-0">
          <button type="button" id="btn_close_modal_family" class="btn bg-teal btn-sm" data-bs-dismiss="modal">
            <i class="fas fa-power-off mr-2"></i> Close Window
          </button>
          <button type="submit" id="btn_submit_family" class="btn btn-primary btn-sm">
            <i class="fas fa-save mr-2 "></i> <span id="btn_submit_family_span">Save Changes</span>
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  <!-- /.modal-dialog -->
</div>