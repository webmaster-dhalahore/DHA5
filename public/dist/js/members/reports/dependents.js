onlyIntValues("from_age");
onlyIntValues("to_age");

$(function () {
  $("#form").on("submit", async function (e) {
    e.preventDefault();

    const loaderDiv = $("#loaderdiv");
    const tableDiv = $("#tableDivSearchResults");
    const searchTbl = $("#search_results_tbl");
    const tblBody = $("#search_results_tbl_body");
    const formData = new FormData(this);

    tableDiv.addClass("d-none");
    loaderDiv.removeClass("d-none");
    loaderDiv.addClass("loader");

    try {
      const { pathname, origin } = window.location;
      const url = `${origin}${pathname}`;
      const { data } = await axios.post(url, formData);

      if ($.fn.DataTable.isDataTable("#search_results_tbl")) {
        searchTbl.DataTable().clear().destroy();
      }

      loaderDiv.removeClass("loader");
      loaderDiv.addClass("d-none");
      tableDiv.removeClass("d-none");

      data.forEach((member, i) => {
        const line_num = i + 1;
        const dob = member.dob ? moment(member.dob).format("DD/MM/YYYY") : "";

        $("<tr class='align-middle'>")
          .append(
            $("<td width='1px'>").text(line_num).addClass("align-middle"),
            $("<td>").text(member.memberid).addClass("align-middle"),
            $("<td>").text(member.membername).addClass("align-middle"),
            $("<td>").text(member.family_memberid).addClass("align-middle"),
            $("<td>").text(member.family_membername).addClass("align-middle"),
            $("<td>").text(dob).addClass("align-middle"),
            $("<td>").text(member.relation).addClass("align-middle"),
            $("<td>").text(member.years).addClass("align-middle"),
            $("<td>").text(member.months).addClass("align-middle"),
            $("<td>").text(member.days).addClass("align-middle")
          )
          .appendTo(tblBody);
      });

      $(searchTbl).DataTable({
        dom: "lBfrtip",
        lengthMenu: [
          [10, 25, 50, 100, 200, 500, -1],
          [10, 25, 50, 100, 200, 500, "All"],
        ],
        destroy: true,
        // buttons: ["excel", "print", "csv", "pdf"],
        buttons: [
          "excel",
          {
            extend: "print",
            title: "Member List Dependents",
            customize: function (win) {
              $(win.document.body).find("h1").css("text-align", "center");
              $(win.document.body).css("font-size", "11px");
              $(win.document.body)
                .find("table")
                .addClass("compact")
                .css("font-size", "inherit");
            },
          },
        ],
      });
    } catch (e) {
      loaderDiv.removeClass("loader");
      loaderDiv.addClass("d-none");

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
