let clubs = [];

$("#lov_clubs").on("shown.bs.modal", async function () {
  $("#clubs_search_input").focus();
  clubs = await getClubsData();
  drawMTLOVTable(clubs);
});

async function getClubsData() {
  try {
    clubs = localStorage.getItem("clubs");
    if (!clubs) {
      clubs = await fetchClubsData();
    } else {
      clubs = JSON.parse(clubs);
    }

    return clubs;
  } catch (e) {
    console.log("error---", e);
    return [];
  }
}

async function fetchClubsData() {
  try {
    const res = await axios.get(`${_baseURL}api/v1/clubs`);
    clubs = res.data;
    localStorage.setItem("clubs", JSON.stringify(clubs));
    return clubs;
  } catch (error) {
    return [];
  }
}

$("#lov_clubs").on("hide.bs.modal", function () {
  $("#clubs_search_input").val("");
  $("#typeid").focus();
});

function drawMTLOVTable(clubs) {
  let html = `<table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col" width="1px">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Code</th>
        </tr>
      </thead>
      <tbody id="professionTbody">`;

  clubs.forEach((club) => {
    html += `<tr class="" id="club-${club.id}" onclick="selectedClub('${club.id}', '${club.name}', '${club.code}'')" style="cursor: pointer;">
          <th scope="row">${club.id}</th>
          <td>${club.name}</td>
          <td>${club.code}</td>
        </tr>`;
  });
  html += `</tbody></table>`;
  $("#lovMTTable").html(html);
  return html;
}

async function refetchClubsData() {
  const clubs = await fetchClubsData();
  drawMTLOVTable(clubs);
}

// async function getClubs() {
//   try {
//     const clubs = await axios.get("/api/v1/clubs");
//     return clubs.data;
//   } catch (e) {
//     console.log("error---", e);
//     return [];
//   }
// }

function searchClubs(e) {
  const val = e.target.value.toLowerCase();
  const filteredClubs = clubs.filter(({ code, des }) => {
    return code.toString().includes(val) || des.toLowerCase().includes(val);
  });

  drawMTLOVTable(filteredClubs);
}

function selectedClub(club_id, name, code) {
  $("#club_id").val(club_id);
  $("#clube").val(name);
  $("#clube_code").val(code);
  $("#lov_clubs").modal("hide");
}
