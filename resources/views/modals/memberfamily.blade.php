<div class="modal fade" id="member_family_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="mb-0">Member Name: <span class="text-primary font-weight-bold" id="span_membername">------------------</span></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="familyModalContainer">
      </div>
      <div class="modal-footer justify-content-between border-top-0">
        <button type="button" class="btn bg-teal btn-sm" data-bs-dismiss="modal">
          <i class="fas fa-power-off mr-2"></i> Close Window
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@push('custom-scripts')
<script src="{{ asset('dist/js/models/memberfamily.js') }}" defer></script>
@endpush