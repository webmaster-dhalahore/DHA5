var members = [];
var searchedMembers = [];
async function getMembers() {
  try {
    const { data } = await axios.get(members_lov_route);
    members = data;
    searchedMembers = data;
    drawMTLOVTable(data);
  } catch (e) {
    logErrors(e);
    members = [];
    searchedMembers = [];
  }
}

getMembers();

function drawMTLOVTable(members) {
  let html = `<table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col" width="1px">#</th>
          <th scope="col">Member ID</th>
          <th scope="col">Member Name</th>
          <th scope="col">Address</th>
        </tr>
      </thead>
      <tbody id="professionTbody">`;

  members.forEach((member, ind) => {
    const { memberid, membersr, membername, mailingaddress } = member;
    // const dis = discperc ? discperc : 0;
    html += `<tr class="" id="member-${membersr}" style="cursor: pointer; font-size:14px;" onclick="fetchMember(${membersr}, '${memberid}')">
          <th scope="row">${ind + 1}</th>
          <td>${memberid}</td>
          <td>${membername}</td>
          <td>${mailingaddress ? mailingaddress : ''}</td>
        </tr>`;
  });
  html += `</tbody></table>`;
  $("#lovMembersTable").html(html);
}

var debounceTest = debounce(async function (query) {
  try {
    const { data } = await axios.get(`${members_lov_route}?query=${query}`);
    searchedMembers = data;
    drawMTLOVTable(data);
    return data;
  } catch (e) {
    logErrors(e);
    searchedMembers = [];
    return [];
  }
}, 250);

$(document).on("keyup", "#member_search_input", function (e) {
  const { value } = e.target;
  debounceTest(value);
});

$("#lov_members").on("shown.bs.modal", async function () {
  $("#member_search_input").focus();
});

$("#lov_members").on("hide.bs.modal", function () {
  $("#member_search_input").val("");
  drawMTLOVTable(members);
});

// function printData(){}

async function fetchMember(membersr, memberid) {
  const member_pk = membersr || memberid;
  try {
    const url = `${get_member_route}?membersr=${member_pk}`;
    const { data } = await axios.get(url);
    $("#lov_members").modal("hide");
    printData(data);
  } catch (e) {
    logErrors(e);
  }
}
