var items = [];
var current_id = 2;
var selected_el_id = 1;

/**** TOTALS */
var total_taxable = 0;
var total_non_taxable = 0;
var gross_total = 0;
var overall_discount = 0;
var overall_sales_tax = 0;
var net_payable = 0;

function createRow(row_num) {
  var html = `<tr>
      <td class="pt-0 pl-1 px-0" id="td_${row_num}">
        <input readonly class="br-0 form-control form-control-sm bg-white srno" tabIndex="-1" />
      </td>
      <td class="pt-0 px-1">
        <div class="input-group">
          <input class="br-0 form-control form-control-sm only-ints" id="item_alias_${row_num}" name="item_alias[]" onblur="getSingleItem(event, ${row_num})" >
          <div class="input-group-append">
            <button onclick="openPSItemsLOV(${row_num})" id="btn_item_lov_${row_num}" data-row="${row_num}" type="button" class="btn btn-secondary btn-sm open-items"><i class="fas fa-ellipsis-h"></i></button>
          </div>
        </div>
      </td>
      <td class="pt-0 px-0">
        <input readonly class="br-0 form-control form-control-sm" tabIndex="-1" id="item_id_${row_num}" name="item_id[]" />
      </td>
      <td class="pt-0 px-1">
        <input readonly class="br-0 form-control form-control-sm" tabIndex="-1" id="item_name_${row_num}" name="item_name[]" />
      </td>
      <td class="pt-0 px-0">
        <input name="quantity" class="br-0 form-control form-control-sm only-ints text-right" id="item_qty_${row_num}" name="item_qty[]" onblur="qtyOnBlur(event, ${row_num})" />
      </td>
      <td class="pt-0 px-1">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" id="item_tax_${row_num}" name="item_tax[]" />
      </td>
      <td class="pt-0 px-0">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" id="item_rate_${row_num}" name="item_rate[]" />
      </td>
      <td class="pt-0 px-1">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" id="item_amount_${row_num}" name="item_amount[]" />
      </td>
      <td class="pt-0 px-0">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" id="item_discount_${row_num}" name="item_discount[]" />
      </td>
      <td class="pt-0 px-1">
        <button type="button" class="br-0 btn btn-sm btn-danger remove-row">
          <i class="fas fa-trash-alt"></i>
        </button>
      </td>
    </tr>`;
  return html;
}

function openPSItemsLOV(selected_id) {
  // $('.only-ints').closest('tr').remove();
  selected_el_id = selected_id;
  // console.log('openPSItemsLOV',{selected_id, selected_el_id});
  $("#lov_ps_items").modal("show");
}

function forceNumeric() {
  const $input = $(this);
  $input.val(
    $input
      .val()
      .replace(/[^0-9.]/g, "")
      .replace(/(\..*?)\..*/g, "$1")
  );
}

$(document).on("input", ".only-ints", forceNumeric);

function addRow() {
  // document.getElementById("sale_items_tbl").insertRow(-1).innerHTML = createRow(current_id);
  $("#sale_items_tbl > tbody:last-child").append(createRow(current_id));
  current_id++;
  updateRowNum();
}

function updateRowNum() {
  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const sr = index + 1;
    const html = `<input readonly class="br-0 form-control form-control-sm bg-white srno" tabIndex="-1" value="${sr}" />`;
    $(this).find("td:first").html(html);
    // $(this).find("td:nth-child(5)").html(html);
  });
}

$("#sale_items_tbl").on("click", ".remove-row", function (e) {
  $(this).closest("tr").remove();
  updateRowNum();
});

$(document).on("click", "#add_rows", addRow);

/*************************** PS LOV ***************************/

async function refetchPSItemsData() {
  getItems();
}

function searchPSItems(e) {
  const val = e.target.value.toLowerCase();
  const filtered_items = items.filter((item) => {
    const item_alias = item.item_alias.toString();
    const item_name = item.item_name.toLowerCase();
    return item_alias.includes(val) || item_name.includes(val);
  });

  drawItemsTable(filtered_items);
}

$("#lov_ps_items").on("shown.bs.modal", function () {
  $("#item_search_input").focus();
});

$("#lov_ps_items").on("hide.bs.modal", function () {
  $("#item_search_input").val("").focus();
  drawItemsTable(items);
});

async function getItems() {
  try {
    const res = await axios.get(`${item_route}`);
    items = res.data;
    drawItemsTable(res.data);
  } catch (e) {
    console.log(e);
    console.log(e.response.data);
  }
}

function drawItemsTable(items) {
  let html = `<table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col" width="1px">#</th>
          <th scope="col">Alias</th>
          <th scope="col">Item Name</th>
          <th scope="col">Price</th>
          <th scope="col">ID</th>
          <th scope="col">Tax-able</th>
          <th scope="col">ST Rate</th>
        </tr>
      </thead>
      <tbody id="itemsBody">`;

  items.forEach((item, ind) => {
    const { item_alias, item_id, item_name, sale_price, taxable } = item;
    html += `<tr class="" id="item-${item_id}" style="cursor: pointer;" onclick="selectedItem('${item_alias}')">
          <th scope="row">${ind + 1}</th>
          <td>${item_alias}</td>
          <td>${item_name}</td>
          <td>${sale_price}</td>
          <td>${item_id}</td>
          <td>${taxable}</td>
          <td>${item.staxrate}</td>
        </tr>`;
  });
  html += `</tbody></table>`;
  $("#lovPSItemTable").html(html);
  // return html;
}

function selectedItem(item_alias, row_id = null) {
  row_id = row_id || selected_el_id;
  selected_el_id = row_id + 1;
  // console.log("selectedItem", { item_alias, row_id, selected_el_id });
  const item = items.find((i) => i.item_alias == item_alias);
  if (!item) {
    $(`#item_id_${row_id}`).val("");
    $(`#item_name_${row_id}`).val("");
    $(`#item_rate_${row_id}`).val("");
    $(`#item_qty_${row_id}`).val("");
    $(`#item_tax_${row_id}`).val("");
    $(`#item_amount_${row_id}`).val("");
    $(`#item_discount_${row_id}`).val("");
    // $("#lov_ps_items").modal("show");
    openPSItemsLOV(row_id)
    calculateRowTotal(row_id);
    return;
  }

  $(`#item_alias_${row_id}`).val(item.item_alias);
  $(`#item_id_${row_id}`).val(item.item_id);
  $(`#item_name_${row_id}`).val(item.item_name);
  $(`#item_rate_${row_id}`).val(item.sale_price);
  $(`#item_tax_${row_id}`).val(item.staxrate);
  $("#lov_ps_items").modal("hide");

  if (!$(`#td_${row_id + 1}`).length) {
    addRow();
  }

  // --- dont delete
  // const x = $(`#item_alias_${row_id}`).closest('tr').find('td:first').find('input')
  // console.log('----x----', x);

  calculateRowTotal(row_id);

  $(`#item_qty_${row_id}`).focus();
}

$(function () {
  getItems();
});

function getSingleItem(e, row_id) {
  // console.log('e.target.id', e.target.id);
  const item_alias = e.target.value.trim();
  if (item_alias) {
    selectedItem(item_alias, row_id);
  }
}

function qtyOnBlur(e, id_seq) {
  const item_alias = $(`#item_alias_${id_seq}`);
  if (!item_alias.val()) {
    item_alias.focus();
    return;
  }
  const qty = e.target.value;
  calculateRowTotal(id_seq, qty);
}

function calculate_row_total() {}

function calculateRowTotal(row_id, qty = null) {
  const item_id = $(`#item_id_${row_id}`).val();
  let item_qty = qty || parseInt($(`#item_qty_${row_id}`).val()) || 0;
  const discount_per = parseInt($("#dha_dis_per").val().trim()) || 0;

  const item = items.find((i) => i.item_id === item_id);

  if (!item) {
    calculateOverallTotals();
    return;
  }

  item_qty = parseInt(item_qty);
  const sale_price = parseFloat(item.sale_price);
  const row_total = sale_price * item_qty;

  // const taxable = item.taxable;
  // const staxrate = parseInt(item.staxrate);
  // let tax = 0;
  // if (taxable.toLowerCase() === "y") {
  //   tax = (row_total / 100) * staxrate;
  // }

  $(`#item_amount_${row_id}`).val(row_total);
  const item_type_id = parseInt(item.item_type_id);
  if (allwowed_discount_types.includes(item_type_id) && item_qty) {
    const discount = row_total * (discount_per / 100);
    if (discount > 0) {
      $(`#item_discount_${row_id}`).val(discount);
    }
  } else {
    $(`#item_discount_${row_id}`).val("");
  }

  /**** Overall Totals *****/
  calculateOverallTotals();
}

$(document).on("click", "#calculate_totals", function () {
  calculateOverallTotals();
});

function calculateOverallTotals() {
  total_taxable = 0;
  total_non_taxable = 0;
  gross_total = 0;
  overall_discount = 0;
  overall_sales_tax = 0;
  net_payable = 0;

  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const $this = $(this);
    const item_alias = $this.find("td:nth-child(2)").find("input").val();
    const item_id = $this.find("td:nth-child(3)").find("input").val();
    const item_qty = $this.find("td:nth-child(5)").find("input").val();

    if (item_qty && item_alias && item_id) {
      let tax_rate = $this.find("td:nth-child(6)").find("input").val();
      tax_rate = parseInt(tax_rate);
      const price = $this.find("td:nth-child(7)").find("input").val();
      const dis = $this.find("td:nth-child(9)").find("input").val() || 0;

      let tax = 0;
      const row_total = parseFloat(price) * parseInt(item_qty);
      if (tax_rate) {
        total_taxable += row_total;
        tax = (row_total / 100) * tax_rate;
      } else {
        total_non_taxable += row_total;
      }

      overall_discount += parseFloat(dis);

      overall_sales_tax += tax;
    }
  });

  gross_total = total_non_taxable + total_taxable;
  net_payable = gross_total + overall_sales_tax - overall_discount;

  $(`#total_taxable`).val(total_taxable.toFixed(2));
  $(`#total_non_taxable`).val(total_non_taxable.toFixed(2));
  $(`#gross_total`).val(gross_total.toFixed(2));
  $(`#overall_discount`).val(overall_discount.toFixed(2));
  $(`#overall_sales_tax`).val(overall_sales_tax.toFixed(2));
  $(`#net_payable`).val(Math.round(net_payable.toFixed(2)));
}

function calculateAllRows() {
  let discount_per = parseInt($("#dha_dis_per").val().trim()) || 0;

  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const $this = $(this);
    const item_alias = $this.find("td:nth-child(2)").find("input").val();
    const item_id = $this.find("td:nth-child(3)").find("input").val();
    const item_qty = $this.find("td:nth-child(5)").find("input").val();

    if (item_qty && item_alias && item_id) {
      const item = items.find((i) => i.item_id === item_id);
      if (!item) {
        return;
      }
      // console.log({item_type_id: item.item_type_id, item_id: item.item_id, item_name: item.item_name});
      const item_type_id = parseInt(item.item_type_id);
      if (!allwowed_discount_types.includes(item_type_id)) {
        // console.log('type passed');
        $this.find("td:nth-child(9)").find("input").val("");
        return;
      }

      const row_total = parseFloat(item.sale_price) * parseInt(item_qty);
      const discount = row_total * (discount_per / 100);

      if (discount > 0) {
        $this.find("td:nth-child(9)").find("input").val(discount);
      } else {
        $this.find("td:nth-child(9)").find("input").val("");
      }
    }
  });
}


$(document).on('click', '.open-items', function(){
  const tr = $(this).closest('tr')
  const x = tr.find("td:nth-child(2)").find("input").val();
  console.log('xxxxxx', x);
})