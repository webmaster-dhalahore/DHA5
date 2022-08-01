var $table;
const baseURL = `${_baseURL}membership/`;
function openProfessionsLOV() {
  $("#lov_profession").modal("show");
}

function openMemberTypeLOV() {
  $("#lov_membertypes").modal("show");
}

async function getProfession(e) {
  const code = e.target.value;
  const desc = $("#profession_desc");
  if (!code) {
    desc.val("");
    return;
  }
  try {
    const p = await getProfessionData();
    const profession = p.find((x) => Number(x.code) === Number(code));
    const msg = "Not a valid Profession";
    const profession_desc = (profession && profession.des) || msg;
    desc.val(profession_desc);
  } catch (error) {
    getProfession(e);
  }
}

async function getMemberTypes(e) {
  const code = e.target.value;
  const desc = $("#member_type_desc");
  if (!code) {
    desc.val("");
    return;
  }
  try {
    const mts = await getMemberTypesData();
    const mt = mts.find((mt) => Number(mt.code) === Number(code));
    const member_type_desc = (mt && mt.des) || "Not a valid Member Type";
    desc.val(member_type_desc);
  } catch (error) {
    getMemberTypes(e);
  }
}

onlyIntValues("typeid");
onlyIntValues("occupationid");
onlyIntValues("pano");

$(function () {
  $("#form").on("submit", async function (e) {
    e.preventDefault();
    var oneFilled = checkFields($(this));
    if (!oneFilled) {
      const msg = "Minimum one field is required to perform the search.";
      Command: toastr["error"](msg);
      return;
    }
    const loaderDiv = $("#loaderdiv");
    const tableDiv = $("#tableDivSearchResults");
    tableDiv.addClass("d-none");
    loaderDiv.removeClass("d-none");
    // const loaderHtml = `<div class="spinner-border text-primary" style="width: 5rem; height: 5rem;"  role="status">
    //       <span class="sr-only"> <i class="fas fa-3x fa-sync-alt"></i> Loading...</span>
    //     </div>`;

    const loaderHtml = `<div>
    <svg id="preloader" width="240px" height="120px" viewBox="0 0 240 120" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <path id="loop-normal" class="st1" d="M120.5,60.5L146.48,87.02c14.64,14.64,38.39,14.65,53.03,0s14.64-38.39,0-53.03s-38.39-14.65-53.03,0L120.5,60.5
L94.52,87.02c-14.64,14.64-38.39,14.64-53.03,0c-14.64-14.64-14.64-38.39,0-53.03c14.65-14.64,38.39-14.65,53.03,0z">
        <animate attributeName="stroke-dasharray" from="500, 50" to="450 50" begin="0s" dur="2s" repeatCount="indefinite" />
        <animate attributeName="stroke-dashoffset" from="-40" to="-540" begin="0s" dur="2s" repeatCount="indefinite" />
      </path>
      <path id="loop-offset" d="M146.48,87.02c14.64,14.64,38.39,14.65,53.03,0s14.64-38.39,0-53.03s-38.39-14.65-53.03,0L120.5,60.5L94.52,87.02c-14.64,14.64-38.39,14.64-53.03,0c-14.64-14.64-14.64-38.39,0-53.03c14.65-14.64,38.39-14.65,53.03,0L120.5,60.5L146.48,87.02z"></path>
      <path id="socket" d="M7.5,0c0,8.28-6.72,15-15,15l0-30C0.78-15,7.5-8.28,7.5,0z">
        <animateMotion dur="2s" repeatCount="indefinite" rotate="auto" keyTimes="0;1" keySplines="0.42, 0.0, 0.58, 1.0">
          <mpath xlink:href="#loop-offset" />
        </animateMotion>
      </path>
      <path id="plug" d="M0,9l15,0l0-5H0v-8.5l15,0l0-5H0V-15c-8.29,0-15,6.71-15,15c0,8.28,6.71,15,15,15V9z">
        <animateMotion dur="2s" rotate="auto" repeatCount="indefinite" keyTimes="0;1" keySplines="0.42, 0, 0.58, 1">
          <mpath xlink:href="#loop-normal" />
        </animateMotion>
      </path>
    </svg>
  </div>`;
    loaderDiv.html(loaderHtml);
    // loaderDiv.addClass("loader");

    const formData = new FormData(this);
    $("#collapse").trigger("click");
    try {
      const { data } = await axios.post(submitSearchURL, formData);
      if ($.fn.DataTable.isDataTable("#adv_seaarch_results_tbl")) {
        $("#adv_seaarch_results_tbl").DataTable().clear().destroy();
      }
      // loaderDiv.html("");
      loaderDiv.removeClass("loader");
      loaderDiv.addClass("d-none");
      tableDiv.removeClass("d-none");
      $.each(data.members, function (i, member) {
        const cat = member.category ? member.category.des : "";
        const mt = member.type ? member.type.des : "";
        const line_num = i + 1;
        const editURL = `${baseURL}${member.memberid}/edit`;
        const infoReportURL = `${baseURL}reports/${member.memberid}/info`;

        const html = `<div class="dropdown">
              <button role="button" type="button" class="btn" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item text-primary" href="#" target="_blank"><i class="fas fa-eye"></i> View</a>
              <a class="dropdown-item text-primary" href="${editURL}" target="_blank"><i class="fas fa-edit"></i> Edit</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-success" href="${infoReportURL}" target="_blank"><i class="fas fa-info-circle"></i> Member Info Report</a>
              </div>
            </div>`;
        $("<tr class='align-middle'>")
          .append(
            $("<td width='1'>").text(line_num).addClass("align-middle"),
            $("<td>").text(member.memberid).addClass("align-middle"),
            $("<td>").text(member.membername).addClass("align-middle"),
            $("<td>").text(cat).addClass("align-middle"),
            $("<td>").text(mt).addClass("align-middle"),
            $("<td>").text(member.status).addClass("align-middle"),
            $("<td>").text(member.blockstatus).addClass("align-middle"),
            $("<td>").text(member.mobile).addClass("align-middle"),
            $("<td>").text(member.cnic).addClass("align-middle"),
            $("<td>").text(member.mailingaddress).addClass("align-middle"),
            $("<td>").text(member.email).addClass("align-middle"),
            $("<td width='1'>").html(html).addClass("align-middle")
          )
          .appendTo("#adv-search-tbl-body");
      });

      let lengthMenu = [
        [10, 25, 50, 100, 200, 500, 1000],
        [10, 25, 50, 100, 200, 500, 1000],
      ];
      if (data.count && data.count >= 50 && data.count < 100) {
        lengthMenu = [
          [10, 25, 50, -1],
          [10, 25, 50, "All"],
        ];
      } else if (data.count && data.count >= 100 && data.count < 1000) {
        lengthMenu = [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ];
      } else if (data.count && data.count >= 1000 && data.count < 2000) {
        lengthMenu = [
          [10, 25, 50, 100, 200],
          [10, 25, 50, 100, 200],
        ];
      }
      $table = $("#adv_seaarch_results_tbl").DataTable({
        dom: "lBfrtip",
        // lengthChange: false,
        lengthMenu: lengthMenu,
        destroy: true,
        buttons: [
          {
            extend: "excel",
            split: [
              {
                extend: "csv",
                titleAttr: "CSV",
                exportOptions: {
                  columns: ":visible:not(:last-child)",
                },
              },
              {
                extend: "pdf",
                titleAttr: "PDF",
                orientation: "landscape",
                pageSize: "LEGAL",
                exportOptions: {
                  columns: ":visible:not(:last-child)",
                },
              },
              {
                extend: "copy",
                titleAttr: "Copy",
                exportOptions: {
                  columns: "th:not(:last-child)",
                },
              },
            ],
          },
          "colvis",
        ],
        columnDefs: [
          { targets: 8, visible: false },
          { targets: 9, visible: false },
          { targets: 10, visible: false },
        ],
      });
    } catch (e) {
      console.log(e);
      $("#collapse").trigger("click");
      let message = "Invalid data.";
      const errors = e?.response?.data?.errors || null;
      if (e?.response?.data?.sessionMsg) {
        const { data } = e.response;
        const { sessionMsg } = data;
        message = sessionMsg.message;
      }
      if (errors) {
        Object.keys(errors).forEach((id) => {
          $(`#${id}`).addClass("is-invalid");
          $(`#ifb_${id}`).text(errors[id][0]);
        });
      }

      // show error message
      Command: toastr["error"](message);
    }
  });
});

// $("#collapse").trigger("click");
$(document).on("click", "#btnSearchAgain", function () {
  $("#collapse").trigger("click");
  $("html, body").animate({ scrollTop: 0 }, "slow");
  return false;
});
