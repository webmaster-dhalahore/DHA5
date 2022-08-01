$("#table").dataTable({
  aLengthMenu: [
    [25, 50, 100, 200, -1],
    [25, 50, 100, 200, "All"],
  ],
  iDisplayLength: -1,
  dom: "lBfrtip",
  bPaginate: false,
  bFilter: false,
  buttons: [
    {
      extend: "print",
      customize: function (win) {
        // $(win.document.body)
        //   .css("font-size", "10pt")
        //   .prepend(
        //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
        //   );

        $(win.document.body).prepend(print_page_title);

        $(win.document.body)
          .find("table")
          .addClass("compact")
          .css("font-size", "inherit");
      },
      exportOptions: {
        columns: [".export"],
      },
    },
    {
      extend: "excel",
      titleAttr: "EXCEL",
      exportOptions: {
        columns: [".export"],
      },
    },
    {
      extend: "csv",
      titleAttr: "CSV",
      exportOptions: {
        columns: [".export"],
      },
    },
    {
      extend: "pdf",
      titleAttr: "PDF",
      exportOptions: {
        columns: [".export"],
      },
    },
  ],

  //   buttons: ["excel", "csv", "pdf"],
  // buttons: [
  //   {
  //     extend: "excel",
  //     titleAttr: "EXCEL",
  //     exportOptions: {
  //       columns: [".export"],
  //     },
  //   },
  //   {
  //     extend: "csv",
  //     titleAttr: "CSV",
  //     exportOptions: {
  //       columns: [".export"],
  //     },
  //   },
  //   {
  //     extend: "pdf",
  //     titleAttr: "PDF",
  //     exportOptions: {
  //       columns: [".export"],
  //     },
  //   },
  // ],
});
