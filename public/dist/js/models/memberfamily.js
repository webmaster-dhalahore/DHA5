$(document).on("click", ".familyModalBtn", function (e) {
  $("#member_family_modal").modal("show");
});

function familyHtml(member, arr_len, index) {
  const { memberid, membername, creditallow, relation } = member;
  const { picture, fmemberpic, signature, fmembersign } = member;
  const member_id = memberid ? memberid : '';
  const member_name = membername ? membername : '';
  const member_relation = relation ? relation : '';

  let credit_allowed = `<span class="text-danger"> <img src="${icon_no}" /> NO</span>`
  let hr = '';
  // if element is not the last element
  if (!Object.is(arr_len - 1, index)) {
    hr = '<hr class="hr-primary" />';
  }

  if(creditallow == '1'){
    credit_allowed = `<span class="text-success"> <img src="${icon_yes}" /> YES</span>`
  }

  const pic = picture ? `${picsFolderPath}/${picture}` : fmemberpic;
  const sign = signature ? `${picsFolderPath}/${signature}` : fmembersign;

  var html = `<div class="row" style="font-size: 14PX">
    <div class="col-sm-6">
      <div class="row mb-1 border-bottom">
        <div class="col-sm-4 text-bold">MEMBER ID</div>
        <div class="col-sm-8 text-primary text-bold">${member_id}<i class="fas fa-ok mr-2"></i></div>
      </div>
      <div class="row mb-1 mt-1 border-bottom">
        <div class="col-sm-4 text-bold">MEMBER NAME</div>
        <div class="col-sm-8">${member_name}</div>
      </div>
      <div class="row mb-1 mt-1 border-bottom">
        <div class="col-sm-4 text-bold">CREDIT ALLOWED</div>
        <div class="col-sm-8">${credit_allowed}</div>
      </div>
      <div class="row mb-1 mt-1 border-bottom">
        <div class="col-sm-4 text-bold">RELATION</div>
        <div class="col-sm-8">${member_relation}</div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="row align-items-center">
        <div class="col-sm-6 mt-2 text-center">
          <img class="img" id="mf_pic_view" src="${pic}" height="100" alt="Photograph">
        </div>
        <div class="col-sm-6 mt-2 text-center">
          <img class="img" id="mf_sign_view" src="${sign}" width="150" alt="Signature">
        </div>
      </div>
    </div>
  </div>${hr}`;

  return html;
}

function getFamily(membersr) {
  const formData = new FormData();
  formData.append("_token", window.csrf_token);
  formData.append("membersr", membersr);

  var html = '';

  axios
    .post(member_family_route, formData)
    .then(({ data }) => {
      const len = data.length;
      data.forEach((d, index) => {
        html += familyHtml(d, len, index);
      });
      if(!html){
        html = '<h1 class="text-center">No Family</h1>'
      }
      $("#familyModalContainer").html(html);

      const member_name = $('#membername').val();
      const member_id = $('#memberid').val();
      $("#span_membername").text(`${member_name} (${member_id})`);
    })
    .catch(logErrors);
}
