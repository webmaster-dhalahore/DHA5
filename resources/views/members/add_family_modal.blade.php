<div class="modal fade" id="modal_family_add">
  <form action="{{ route('member.family.store') }}" method="POST">
    @csrf
    <input type="hidden" name="member_sr_fk" id="member_sr_fk" />
    <input type="hidden" name="family_vno" id="family_vno" />
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="mb-0">Member Name: <span class="text-primary font-weight-bold" id="span_membername">Muhammad Usman Sharif (R-123)</span></h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group row mb-0">
                <label for="member_family_id" class="col-sm-5 col-form-label">Member ID</label>
                <div class="col-sm-7">
                  <input class="form-control form-control-sm" id="member_family_id" name="member_family_id" placeholder="Member ID" />
                </div>
              </div>
              <div class="form-group row mb-0">
                <label for="member_family_name" class="col-sm-5 col-form-label">Member Name</label>
                <div class="col-sm-7">
                  <input class="form-control form-control-sm" id="member_family_name" name="member_family_name" placeholder="Member Name" />
                </div>
              </div>
              <div class="form-group row mb-0">
                <label for="credit_allowed" class="col-sm-5 col-form-label">Credit Allowed</label>
                <div class="col-sm-7" id="credit_allowed_div">
                  <select class="form-control form-control-sm" id="credit_allowed" name="credit_allowed">
                    <option>-----------</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row mb-0">
                <label for="member_familY_sr" class="col-sm-5 col-form-label">Member SR</label>
                <div class="col-sm-7">
                  <input class="form-control form-control-sm" id="member_familY_sr" name="member_familY_sr" placeholder="Member ID" />
                </div>
              </div>
              <div class="form-group row mb-0">
                <label for="member_family_dob" class="col-sm-5 col-form-label">Date of Birth </label>
                <div class="col-sm-7">
                  <input type="date" value="" class="form-control form-control-sm" id="member_family_dob" name="member_family_dob" />
                </div>
              </div>
              <div class="form-group row mb-0">
                <label for="member_relation" class="col-sm-5 col-form-label">Relation</label>
                <div class="col-sm-7" id="relations_div">
                  <select class="form-control form-control-sm" id="member_relation" name="member_relation">
                    <option>-----------</option>
                    <option value="WIFE">WIFE</option>
                    <option value="SON">SON</option>
                    <option value="DAUGHTER">DAUGHTER</option>
                    <option value="HUSBAND">HUSBAND</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group row mb-0">
                <label for="member_familY_pic" class="col-sm-5 col-form-label">Picture</label>
                <div class="col-sm-7">
                  <input type="file" class="form-control form-control-sm" id="member_familY_pic" name="member_familY_pic" />
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group row mb-0">
                <label for="member_family_sign" class="col-sm-5 col-form-label">Signature</label>
                <div class="col-sm-7">
                  <input type="file" class="form-control form-control-sm" id="member_family_sign" name="member_family_sign" />
                </div>
              </div>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-sm-6 mt-2 text-center">
              <img class="img" id="mf_pic" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="200px" alt="Photograph">
            </div>
            <div class="col-sm-6 mt-2 text-center">
              <img class="img" id="mf_sign" src="{{ asset('dist/img/sign-placeholder.png') }}" width="250px" alt="Signature">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between border-top-0">
          <button type="button" class="btn bg-teal btn-sm" data-dismiss="modal"><i class="fas fa-power-off mr-2"></i> Close Window</button>
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save mr-2"></i> Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </form>
  <!-- /.modal-dialog -->
</div>