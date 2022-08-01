<div class="modal fade" id="show_family_modal">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Member Name: <span class="text-primary font-weight-bold" id="span_membername_view">Muhammad Usman Sharif (R-123)</span></h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-sm-7">
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Member ID</div>
                <div class="col-sm-7 text-primary text-bold" id="div_view_mid">R-3695 <i class="fas fa-ok mr-2"></i></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Date of Birth</div>
                <div class="col-sm-7" id="div_view_dob"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Member Name</div>
                <div class="col-sm-7" id="div_view_mname"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Credit Allowed</div>
                <div class="col-sm-7" id="div_view_credit_allowed"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Relation</div>
                <div class="col-sm-7" id="div_view_relation"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Card Issue Date</div>
                <div class="col-sm-7" id="div_card_issue_date"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Card Expiry Date</div>
                <div class="col-sm-7" id="div_card_expiry_date"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Form Issued ?</div>
                <div class="col-sm-7" id="div_membership_form"></div>
              </div>
              <div class="row mb-2 border-bottom">
                <div class="col-sm-5 text-bold">Last Modified By ?</div>
                <div class="col-sm-7" id="div_modified_by"></div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row align-items-center">
                <div class="col-sm-12 mt-2 text-center">
                  <img class="img" id="mf_pic_view" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="250px" alt="Photograph">
                </div>
                <div class="col-sm-12 mt-2 text-center">
                  <img class="img" id="mf_sign_view" src="{{ asset('dist/img/sign-placeholder.png') }}" width="250px" alt="Signature">
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row border-bottom">
            <div class="col-sm-6 text-bold">Picture</div>
            <div class="col-sm-6 text-bold">Signature</div>
          </div> -->
        </div>


      </div>
      <div class="modal-footer justify-content-between border-top-0">
        <button type="button" class="btn bg-teal btn-sm" data-bs-dismiss="modal"><i class="fas fa-power-off mr-2"></i>Close Window</button>
        <span id="edit_btn_spn_view"></span>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>