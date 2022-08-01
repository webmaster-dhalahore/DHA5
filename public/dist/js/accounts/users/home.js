$("#users_tbl").DataTable({
  columnDefs: [
    { orderable: false, targets: [-1, -2] },
    // { searchable: false, targets: [-1, 1] },
  ],
});
