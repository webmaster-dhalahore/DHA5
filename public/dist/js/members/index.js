var exportOptions = ":visible:not(:last-child)"; // 'th:not(:last-child)';
$(function () {
  const dataTablesOptions = {
    processing: true,
    serverSide: true,
    iDisplayLength: 10,
    // bFilter: false, // hide search bar
    ajax: dataRoute,
    // dom: "lBfrtip",
    searchDelay: 350,
    // lengthMenu: [
    //   [10, 25, 50, 100, 200, 500, 1000],
    //   ["10", "25", "50", "100", "200", "500", "1000"],
    // ],

    // buttons: [
    //   {
    //     extend: "copy",
    //     // text: '<i class="far fa-copy"></i> Copy',
    //     titleAttr: "Copy",
    //     action: newexportaction,
    //     exportOptions: {
    //       // columns: ":visible",
    //       columns: "th:not(:last-child)",
    //     },
    //   },
    //   {
    //     extend: "excelHtml5",
    //     // text: '<i class="fas fa-file-excel"></i> Excel',
    //     titleAttr: "Excel",
    //     action: newexportaction,
    //     exportOptions: {
    //       // columns: ":visible",
    //       // columns: ":visible:not(:last-child)",
    //       columns: "th:not(:last-child)",
    //     },
    //   },
    //   {
    //     extend: "csv",
    //     // text: '<i class="fas fa-file-csv"></i> CSV',
    //     titleAttr: "CSV",
    //     action: newexportaction,
    //     exportOptions: {
    //       // columns: ":visible",
    //       columns: ":visible:not(:last-child)",
    //       // columns: "th:not(:last-child)",
    //     },
    //   },
    //   {
    //     extend: "pdf",
    //     // text: '<i class="fas fa-file-pdf"></i> PDF',
    //     titleAttr: "PDF",
    //     action: newexportaction,
    //     orientation: "landscape",
    //     pageSize: "LEGAL",
    //     exportOptions: {
    //       // columns: ":visible",
    //       columns: "th:not(:last-child)",
    //     },
    //   },
    //   {
    //     text: '<i class="fas fa-sync-alt"></i> Reload',

    //     action: function (e, dt, node, config) {
    //       dt.ajax.reload();
    //     },
    //   },
    //   "colvis",
    // ],
    columnDefs: [
      { targets: 7, visible: false },
      { targets: 8, visible: false },
      { targets: 9, visible: false },
      { targets: 10, visible: false },
    ],
    search: { search: initialSearchTerm },
    columns: [
      { data: "DT_RowIndex", name: "DT_RowIndex" },
      { data: "memberid", name: "memberid" },
      { data: "membername", name: "membername" },
      { data: "categoryid", name: "categoryid" },
      { data: "typeid", name: "typeid" },
      { data: "status", name: "status" },
      { data: "blockstatus", name: "blockstatus" },
      { data: "mobileno", name: "mobileno" },
      { data: "cnic", name: "cnic" },
      { data: "mailingaddress", name: "mailingaddress" },
      { data: "email", name: "email" },
      // { data: "action", name: "action", orderable: false, searchable: false },
    ],
  };

  dataTablesOptions["lengthMenu"] = [
    [10, 25, 50, 100, 200, 500, 1000],
    ["10", "25", "50", "100", "200", "500", "1000"],
  ];
  var table = $("#members-table").DataTable(dataTablesOptions);

  // var data = table.buttons.exportData({
  //   columns: ":visible",
  // });
});

$(document).on("preInit.dt", function () {
  let $sb = $(".dataTables_filter input[type='search']");
  // remove current handler
  $sb.off();
  // Add key hander
  $sb.on("keypress", function (evtObj) {
    if (evtObj.keyCode == 13) {
      $("#members-table").DataTable().search($sb.val()).draw();
    }
  });
  // add button and button handler
  let btn = $(
    "<button type='button' class='btn btn-primary btn-sm'> <i class='fas fa-search'></i> </button>"
  );
  $sb.after(btn);
  btn.on("click", function (evtObj) {
    $("#members-table").DataTable().search($sb.val()).draw();
  });
});
