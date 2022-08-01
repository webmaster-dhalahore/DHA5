let memberTypes = [];

$("#lov_membertypes").on("shown.bs.modal", async function () {
  $("#mt_search_input").focus();
  memberTypes = await getMemberTypesData();
  drawMTLOVTable(memberTypes);
});

async function getMemberTypesData() {
  try {
    memberTypes = localStorage.getItem("memberTypes");
    if (!memberTypes) {
      // const res = await axios.get("/api/v1/memberTypes");
      // memberTypes = res.data;
      // localStorage.setItem("memberTypes", JSON.stringify(memberTypes));
      memberTypes = await fetchMemberTypesData();
    } else {
      memberTypes = JSON.parse(memberTypes);
    }

    return memberTypes;
  } catch (e) {
    console.log("error---", e);
    return [];
  }
}

async function fetchMemberTypesData() {
  try {
    // const res = await axios.get("/api/v1/professions");
    // professions = res.data;
    // localStorage.setItem("professions", JSON.stringify(professions));
    const res = await axios.get(`${_baseURL}api/v1/memberTypes`);
    memberTypes = res.data;
    localStorage.setItem("memberTypes", JSON.stringify(memberTypes));
    return memberTypes;
  } catch (error) {
    return [];
  }
}

$("#lov_membertypes").on("hide.bs.modal", function () {
  $("#mt_search_input").val("");
  $("#typeid").focus();
});

function drawMTLOVTable(memberTypes) {
  let html = `<table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col" width="1px">#</th>
          <th scope="col">Description</th>
          <th scope="col">Code</th>
        </tr>
      </thead>
      <tbody id="professionTbody">`;

  memberTypes.forEach((mt, ind) => {
    html += `<tr class="" id="mt-${mt.code}" onclick="selectedMemberType('${
      mt.code
    }', '${mt.des}')" style="cursor: pointer;">
          <th scope="row">${ind + 1}</th>
          <td>${mt.des}</td>
          <td>${mt.code}</td>
        </tr>`;
  });
  html += `</tbody></table>`;
  $("#lovMTTable").html(html);
  return html;
}

async function refetchMemberTypesData() {
  const p = await fetchMemberTypesData();
  drawMTLOVTable(p);
}

async function getMemberTypes() {
  try {
    const memberTypes = await axios.get(`${_baseURL}api/v1/memberTypes`);
    return memberTypes.data;
  } catch (e) {
    console.log("error---", e);
    return [];
  }
}

function searchMemberTypes(e) {
  const val = e.target.value.toLowerCase();
  const filteredMTs = memberTypes.filter(({ code, des }) => {
    return code.toString().includes(val) || des.toLowerCase().includes(val);
  });

  drawMTLOVTable(filteredMTs);
}

function selectedMemberType(code, des) {
  $("#typeid").val(code);
  $("#member_type_desc").val(des);
  $("#lov_membertypes").modal("hide");
}
