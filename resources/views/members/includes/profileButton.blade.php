<form id="profile-form" action="{{ route('member.reports.member-profilePost') }}" method="POST" class="d-none">
    @csrf
    <input type="hidden" name="memberid" value="{{ $memberid }}" />
</form>

<button type="button" class="btn btn-sm btn-primary mr-1" onclick="submitForm(event, 'profile-form')"><i class="fas fa-address-card mr-2"></i> Profile</button>