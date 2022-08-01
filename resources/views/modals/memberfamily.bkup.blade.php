<div class="modal fade" id="member_family_modal">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Member Name: <span class="text-primary font-weight-bold" id="span_membername_view">Muhammad Usman Sharif (R-123)</span></h5>

        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container" id="familyModalContainer">
          <div class="row" style="font-size: 14PX">
            <div class="col-sm-6">
              <div class="row mb-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER ID</div>
                <div class="col-sm-8 text-primary text-bold" id="div_view_mid">R-3695 <i class="fas fa-ok mr-2"></i></div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER NAME</div>
                <div class="col-sm-8" id="div_view_mname">MRS. SAJIDA ZEHRA RAZA MASHHADI</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">CREDIT ALLOWED</div>
                <div class="col-sm-8" id="div_view_credit_allowed">YES</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">RELATION</div>
                <div class="col-sm-8" id="div_view_relation">DAUGHTER</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row align-items-center">
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_pic_view" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="100" alt="Photograph">
                </div>
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_sign_view" src="{{ asset('dist/img/sign-placeholder.png') }}" width="150" alt="Signature">
                </div>
              </div>
            </div>
          </div>
          <hr class="hr-primary">
          <div class="row" style="font-size: 14PX">
            <div class="col-sm-6">
              <div class="row mb-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER ID</div>
                <div class="col-sm-8 text-primary text-bold" id="div_view_mid">R-3695 <i class="fas fa-ok mr-2"></i></div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER NAME</div>
                <div class="col-sm-8" id="div_view_mname">MRS. SAJIDA ZEHRA RAZA MASHHADI</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">CREDIT ALLOWED</div>
                <div class="col-sm-8" id="div_view_credit_allowed">YES</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">RELATION</div>
                <div class="col-sm-8" id="div_view_relation">DAUGHTER</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row align-items-center">
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_pic_view" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="100" alt="Photograph">
                </div>
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_sign_view" src="{{ asset('dist/img/sign-placeholder.png') }}" width="150" alt="Signature">
                </div>
              </div>
            </div>
          </div>
          <hr class="hr-primary">
          <div class="row" style="font-size: 14PX">
            <div class="col-sm-6">
              <div class="row mb-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER ID</div>
                <div class="col-sm-8 text-primary text-bold" id="div_view_mid">R-3695 <i class="fas fa-ok mr-2"></i></div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">MEMBER NAME</div>
                <div class="col-sm-8" id="div_view_mname">MRS. SAJIDA ZEHRA RAZA MASHHADI</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">CREDIT ALLOWED</div>
                <div class="col-sm-8" id="div_view_credit_allowed">YES</div>
              </div>
              <div class="row mb-1 mt-1 border-bottom">
                <div class="col-sm-4 text-bold">RELATION</div>
                <div class="col-sm-8" id="div_view_relation">DAUGHTER</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row align-items-center">
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_pic_view" src="{{ asset('dist/img/profile_pic01.jpg') }}" height="100" alt="Photograph">
                </div>
                <div class="col-sm-6 mt-2 text-center">
                  <img class="img" id="mf_sign_view" src="{{ asset('dist/img/sign-placeholder.png') }}" width="150" alt="Signature">
                </div>
              </div>
            </div>
          </div>
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

@push('custom-scripts')
<script src="{{ asset('dist/js/models/memberfamily.js') }}" defer></script>
@endpush