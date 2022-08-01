<form id="info-form" action="{{ route('member.reports.member-infoPost') }}" method="POST" class="d-none">
    @csrf
    <input type="hidden" name="memberid" value="{{ $memberid }}" />
</form>

<button type="button" class="btn btn-sm btn-primary mr-1" onclick="submitForm(event, 'info-form')"><i class="fas fa-info-circle mr-2"></i> Info Report</button>