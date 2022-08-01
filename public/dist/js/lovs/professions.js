let professions = [];

$("#lov_profession").on("shown.bs.modal", async function () {
  const searchInput = $("#profession_search_input");
  searchInput.val("").focus();
  professions = await getProfessionData();
  drawProfessionLOVTable(professions);
});

async function getProfessionData() {
  try {
    professions = localStorage.getItem("professions");
    if (!professions) {
      professions = await fetchProfessionsData();
    } else {
      professions = JSON.parse(professions);
    }

    return professions;
  } catch (e) {
    console.log("error---", e);
    return [];
  }
}

async function fetchProfessionsData() {
  try {
    const res = await axios.get(`${_baseURL}api/v1/professions`);
    professions = res.data;
    localStorage.setItem("professions", JSON.stringify(professions));
    return professions;
  } catch (error) {
    return [];
  }
}

async function refetchProfessionsData() {
  const p = await fetchProfessionsData();
  drawProfessionLOVTable(p);
}

$("#lov_profession").on("hide.bs.modal", function () {
  $("#profession_search_input").val("");
  $("#occupationid").focus();
});

function drawProfessionLOVTable(professions) {
  let html = `<table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col" width="1px">#</th>
          <th scope="col">Description</th>
          <th scope="col">Code</th>
        </tr>
      </thead>
      <tbody id="professionTbody">`;

  professions.forEach((profession, ind) => {
    html += `<tr class="" id="prof-${
      profession.code
    }" onclick="selectedProfession('${profession.code}', '${
      profession.des
    }')" style="cursor: pointer;">
          <th scope="row">${ind + 1}</th>
          <td>${profession.des}</td>
          <td>${profession.code}</td>
        </tr>`;
  });
  html += `</tbody></table>`;
  $("#tableDiv").html(html);
  return html;
}

function searchProfession(e) {
  const val = e.target.value.toLowerCase();
  const filteredProfessions = professions.filter(({ code, des }) => {
    return code.toString().includes(val) || des.toLowerCase().includes(val);
  });

  drawProfessionLOVTable(filteredProfessions);
}

function selectedProfession(code, des) {
  $("#occupationid").val(code);
  $("#profession_desc").val(des);
  $("#lov_profession").modal("hide");
}
