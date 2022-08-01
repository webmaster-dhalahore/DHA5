var $table;
const baseURL = `${_baseURL}membership/`;
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

onlyPhoneNumbers("mobileno");
onlyPhoneNumbers("fax");
onlyPhoneNumbers("phoneoffice");
onlyPhoneNumbers("phoneresidence");

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
  $("#club_id").trigger("change");

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

    // loaderDiv.html(loaderHtml);
    loaderDiv.addClass("loader");

    const formData = new FormData(this);
    try {
      const { data } = await axios.post(submitSearchURL, formData);
      if ($.fn.DataTable.isDataTable("#adv_seaarch_results_tbl")) {
        $("#adv_seaarch_results_tbl").DataTable().clear().destroy();
      }
      // loaderDiv.html("");
      loaderDiv.removeClass("loader");
      loaderDiv.addClass("d-none");
      tableDiv.removeClass("d-none");
      $("#collapse").trigger("click");
      const dateDisplayFormat = "DD/MM/YYYY";
      const tblBody = $("#adv-search-tbl-body");
      $.each(data.members, function (i, member) {
        const cat = member.category ? member.category.des : "";
        const mt = member.type ? member.type.des : "";
        const line_num = i + 1;
        const editURL = `${baseURL}${member.memberid}/edit`;
        const infoReportURL = `${baseURL}reports/${member.memberid}/info`;

        const actionHTML = `<div class="dropdown">
              <button role="button" type="button" class="btn" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item text-primary" href="${editURL}" target="_blank"><i class="fas fa-edit"></i> Edit</a>
                <a class="dropdown-item text-success" href="${infoReportURL}" target="_blank"><i class="fas fa-info-circle"></i> Member Info Report</a>
              </div>
            </div>`;
        const blockfromdate = member.fromdate
          ? moment(member.fromdate).format(dateDisplayFormat)
          : "";
        const blocktodate = member.todate
          ? moment(member.todate).format(dateDisplayFormat)
          : "";

        const dob = member.dob
          ? moment(member.dob).format(dateDisplayFormat)
          : "";
        const age = member.dob ? getAge(new Date(member.dob)) : "";

        const membershipdate = member.membershipdate
          ? moment(member.membershipdate).format(dateDisplayFormat)
          : "";
        const cardissuedate = member.cardissuedate
          ? moment(member.cardissuedate).format(dateDisplayFormat)
          : "";
        const cardexpirydate = member.cardexpirydate
          ? moment(member.cardexpirydate).format(dateDisplayFormat)
          : "";
        const occupation = member.occupation
          ? member.occupation.des
          : member.occupationid;
        const married =
          member.married === "Y" ? "YES" : member.married === "N" && "NO";

        $("<tr class='align-middle'>")
          .append(
            $("<td width='1px'>").text(line_num).addClass("align-middle"),
            $("<td>").text(member.memberid).addClass("align-middle"),
            $("<td>").text(member.membername).addClass("align-middle"),
            $("<td>").text(member.memberfname).addClass("align-middle"),
            $("<td>").text(cat).addClass("align-middle"),
            $("<td>").text(mt).addClass("align-middle"),
            $("<td>").text(member.status).addClass("align-middle"),
            $("<td>").text(member.blockstatus).addClass("align-middle"),
            $("<td>").text(blockfromdate).addClass("align-middle"),
            $("<td>").text(blocktodate).addClass("align-middle"),
            $("<td>").text(member.remarks).addClass("align-middle"),
            $("<td>").text(member.cnic).addClass("align-middle"),
            $("<td>").text(member.email).addClass("align-middle"),
            $("<td>").text(member.pano).addClass("align-middle"),
            $("<td>").text(member.mailingaddress).addClass("align-middle"),
            $("<td>").text(member.workingaddress).addClass("align-middle"),
            $("<td>").text(member.mobileno).addClass("align-middle"),
            $("<td>").text(member.phoneoffice).addClass("align-middle"),
            $("<td>").text(member.phoneresidence).addClass("align-middle"),
            $("<td>").text(member.fax).addClass("align-middle"),
            $("<td>").text(occupation).addClass("align-middle"),
            $("<td>").text(member.department).addClass("align-middle"),
            $("<td>").text(member.organisation).addClass("align-middle"),
            $("<td>").text(dob).addClass("align-middle"),
            $("<td>").text(age).addClass("align-middle text-right"),
            $("<td>").text(married).addClass("align-middle"),
            $("<td>").text(membershipdate).addClass("align-middle"),
            $("<td>").text(cardissuedate).addClass("align-middle"),
            $("<td>").text(cardexpirydate).addClass("align-middle"),
            $("<td>").text(member.otherinfo).addClass("align-middle"),
            $("<td>").text(member.membertype).addClass("align-middle"),
            $("<td width='1px'>").html(actionHTML).addClass("align-middle")
          )
          .appendTo(tblBody);
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
      const dt_options = {
        // lengthChange: false,
        lengthMenu: lengthMenu,
        destroy: true,
        columnDefs: [
          { targets: 3, visible: false },
          { targets: 6, visible: false },
          { targets: 8, visible: false },
          { targets: 9, visible: false },
          { targets: 10, visible: false },
          { targets: 11, visible: false },
          { targets: 12, visible: false },
          { targets: 13, visible: false },
          { targets: 14, visible: false },
          { targets: 15, visible: false },
          { targets: 16, visible: false },
          { targets: 17, visible: false },
          { targets: 18, visible: false },
          { targets: 19, visible: false },
          { targets: 20, visible: false },
          { targets: 21, visible: false },
          { targets: 22, visible: false },
          { targets: 23, visible: false },
          { targets: 24, visible: false },
          { targets: 25, visible: false },
          { targets: 26, visible: false },
          { targets: 27, visible: false },
          { targets: 28, visible: false },
          { targets: 29, visible: false },
          { targets: 30, visible: false },
        ],
      };

      if (is_super) {
        dt_options["dom"] = "lBfrtip";
        dt_options["buttons"] = [
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
        ];
      }
      $table = $("#adv_seaarch_results_tbl").DataTable(dt_options);
    } catch (e) {
      // console.log(e);
      loaderDiv.removeClass("loader");
      loaderDiv.addClass("d-none");
      // $("#collapse").trigger("click");
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

$(document).on("change", "#club_id", function (e) {
  const code = $(this).find(":selected").data("code");
  $("#club_code").val(code);
});
