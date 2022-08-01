<div class="modal fade" id="modal_change_password">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('changePassword') }}" method="POST" id="form_change_pwd">
        @csrf
        <div class="modal-header bg-light">
          <h5 class="mb-0">Change Password</h5>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group row mb-1">
            <label for="current_password" class="col-sm-4 col-form-label">Current Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm cpwd" id="current_password" name="current_password" autofocus required />
              <div class="invalid-feedback" id="ifb_current_password">
                Confirm passwor error.
              </div>
            </div>
          </div>

          <div class="form-group row mb-1">
            <label for="password" class="col-sm-4 col-form-label">New Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm cpwd" id="password" name="password" required />
              <div class="invalid-feedback" id="ifb_password">
                Confirm passwor error.
              </div>
            </div>
          </div>
          <div class="form-group row mb-1">
            <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm cpwd" id="password_confirmation" name="password_confirmation" required data-parsley-equalto="#password" data-parsley-equalto-message="Confirm passwor and new password should be the same!" />
              <div class="invalid-feedback" id="ifb_password_confirmation">
                Confirm passwor error.
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between border-top-0">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn_change_pwd">Change Password</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

<script>
  const cp_route = "{{ route('changePassword') }}"
</script>