var items = [];
var current_tr = null;

// positions in table starting from sr till discount
const item_sr_td = "td:first";
const item_alias_td = "td:nth-child(2)";
const item_id_td = "td:nth-child(3)";
const item_name_td = "td:nth-child(4)";
const item_qty_td = "td:nth-child(5)";
const item_tax_td = "td:nth-child(6)";
const item_rate_td = "td:nth-child(7)";
const item_amount_td = "td:nth-child(8)";
const item_discount_td = "td:nth-child(9)";

function createRow() {
  var html = `<tr>
      <td class="pt-0 pl-1 px-0">
        <input readonly class="br-0 form-control form-control-sm bg-white srno" tabIndex="-1" />
      </td>
      <td class="pt-0 px-1">
        <div class="input-group">
          <input class="br-0 form-control form-control-sm only-ints item-alias"name="item_alias[]" >
          <div class="input-group-append">
            <button type="button" class="btn btn-secondary btn-sm open-items"><i class="fas fa-ellipsis-h"></i></button>
          </div>
        </div>
      </td>
      <td class="pt-0 px-0">
        <input readonly class="br-0 form-control form-control-sm" tabIndex="-1" name="item_id[]" />
      </td>
      <td class="pt-0 px-1">
        <input readonly class="br-0 form-control form-control-sm" tabIndex="-1" name="item_name[]" />
      </td>
      <td class="pt-0 px-0">
        <input class="br-0 form-control form-control-sm only-ints text-right item-qty" name="item_qty[]" />
      </td>
      <td class="pt-0 px-1">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" name="item_tax[]" />
      </td>
      <td class="pt-0 px-0">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" name="item_rate[]" />
      </td>
      <td class="pt-0 px-1">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" name="item_amount[]" />
      </td>
      <td class="pt-0 px-0">
        <input type="text" readonly class="br-0 form-control form-control-sm text-right" tabIndex="-1" name="item_discount[]" />
      </td>
      <td class="pt-0 px-1">
        <button type="button" class="br-0 btn btn-sm btn-danger remove-row">
          <i class="fas fa-trash-alt"></i>
        </button>
      </td>
    </tr>`;
  return html;
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
  $("#sale_items_tbl > tbody:last-child").append(createRow());
  updateRowNum();
}

function updateRowNum() {
  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const sr = index + 1;
    const html = `<input readonly class="br-0 form-control form-control-sm bg-white srno" tabIndex="-1" value="${sr}" />`;
    $(this).find("td:first").html(html);
    // $(this).find(item_qty_td).html(html);
  });
}

$("#sale_items_tbl").on("click", ".remove-row", function (e) {
  $(this).closest("tr").remove();
  updateRowNum();
  calculateOverallTotals();
});

$(document).on("click", "#add_rows", addRow);

$(document).on("click", ".open-items", function () {
  current_tr = $(this).closest("tr");
  // const x = tr.find(item_alias_td).find("input").val();
  openPSItemsLOV();
});

/*******************PASTRYSHOP LOV */

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

$(function () {
  getItems();
});

function openPSItemsLOV() {
  $("#lov_ps_items").modal("show");
}

$(document).on("blur", ".item-alias", function (e) {
  current_tr = $(this).closest("tr");
  // selectedItem(null);
  const item_alias_input = current_tr.find(item_alias_td).find("input");
  const item_alias = item_alias_input.val().trim();
  if (item_alias) {
    item_alias_input.removeClass("is-invalid");
    selectedItem(null);
  }
});

$(document).on("blur", ".item-qty", function (e) {
  current_tr = $(this).closest("tr");
  const item_alias_input = current_tr.find(item_alias_td).find("input");
  current_tr.find(item_qty_td).find("input").removeClass("is-invalid");
  if (!item_alias_input.val().trim()) {
    item_alias_input.focus();
    return;
  }
  calculateRowTotal();
});

$(document).on("click", "#calculate_totals", function () {
  calculateOverallTotals();
});

function selectedItem(item_alias = null) {
  if (!current_tr) {
    console.log("no tr is set");
    return;
  }
  const item_alias_input = current_tr.find(item_alias_td).find("input");
  const item_id_input = current_tr.find(item_id_td).find("input");
  const item_name_input = current_tr.find(item_name_td).find("input");
  const item_qty_input = current_tr.find(item_qty_td).find("input");
  const item_tax_input = current_tr.find(item_tax_td).find("input");
  const item_rate_input = current_tr.find(item_rate_td).find("input");
  const item_amount_input = current_tr.find(item_amount_td).find("input");
  const item_discount_input = current_tr.find(item_discount_td).find("input");

  item_alias = item_alias || item_alias_input.val().trim();
  // console.log({item_alias}, item_alias_input.val().trim());

  const item = items.find((i) => i.item_alias == item_alias);
  if (!item) {
    item_alias_input.val("");
    item_id_input.val("");
    item_name_input.val("");
    item_rate_input.val("");
    item_qty_input.val("");
    item_tax_input.val("");
    item_amount_input.val("");
    item_discount_input.val("");
    // $("#lov_ps_items").modal("show");
    openPSItemsLOV();
    calculateRowTotal();
    return;
  }

  item_alias_input.val(item.item_alias);
  item_id_input.val(item.item_id);
  item_name_input.val(item.item_name);
  item_rate_input.val(item.sale_price);
  item_tax_input.val(item.staxrate);
  $("#lov_ps_items").modal("hide");

  // $(this).closest("tr").next("tr");
  if (!current_tr.next("tr").length) {
    addRow();
  }
  calculateRowTotal();
  item_qty_input.focus();
}

function calculateRowTotal() {
  const item_id = current_tr.find(item_id_td).find("input").val();
  const item_qty =
    parseInt(current_tr.find(item_qty_td).find("input").val()) || 0;
  const discount_per = parseInt($("#dha_dis_per").val().trim()) || 0;

  const item = items.find((i) => i.item_id === item_id);

  // console.log({item_id, item_qty, discount_per, }, item);
  if (!item) {
    calculateOverallTotals();
    return;
  }

  const sale_price = parseFloat(item.sale_price);
  const row_total = sale_price * item_qty;

  // const taxable = item.taxable;
  // const staxrate = parseInt(item.staxrate);
  // let tax = 0;
  // if (taxable.toLowerCase() === "y") {
  //   tax = (row_total / 100) * staxrate;
  // }

  current_tr.find(item_amount_td).find("input").val(row_total);
  const item_type_id = parseInt(item.item_type_id);
  if (allwowed_discount_types.includes(item_type_id) && item_qty) {
    const discount = row_total * (discount_per / 100);
    if (discount > 0) {
      current_tr.find(item_discount_td).find("input").val(discount);
    }
  } else {
    current_tr.find(item_discount_td).find("input").val("");
  }

  /**** Overall Totals *****/
  calculateOverallTotals();
}

function calculateOverallTotals() {
  total_taxable = 0;
  total_non_taxable = 0;
  gross_total = 0;
  overall_discount = 0;
  overall_sales_tax = 0;
  net_payable = 0;

  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const $this = $(this);
    const item_alias = $this.find(item_alias_td).find("input").val();
    const item_id = $this.find(item_id_td).find("input").val();
    const item_qty = $this.find(item_qty_td).find("input").val();

    if (item_qty && item_alias && item_id) {
      let tax_rate = $this.find(item_tax_td).find("input").val();
      tax_rate = parseInt(tax_rate);
      const price = $this.find(item_rate_td).find("input").val();
      const dis = $this.find(item_discount_td).find("input").val() || 0;

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
    const item_alias = $this.find(item_alias_td).find("input").val();
    const item_id = $this.find(item_id_td).find("input").val();
    const item_qty = $this.find(item_qty_td).find("input").val();

    if (item_qty && item_alias && item_id) {
      const item = items.find((i) => i.item_id === item_id);
      if (!item) {
        return;
      }

      const item_type_id = parseInt(item.item_type_id);
      if (!allwowed_discount_types.includes(item_type_id)) {
        $this.find(item_discount_td).find("input").val("");
        return;
      }

      const row_total = parseFloat(item.sale_price) * parseInt(item_qty);
      const discount = row_total * (discount_per / 100);

      if (discount > 0) {
        $this.find(item_discount_td).find("input").val(discount);
      } else {
        $this.find(item_discount_td).find("input").val("");
      }
    }
  });
}

function getItemsToSubmit() {
  const data = {
    items: [],
    item_ids: [],
  };
  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const $this = $(this);
    const item_alias = $this.find(item_alias_td).find("input").val();
    const item_id = $this.find(item_id_td).find("input").val();
    const item_qty = $this.find(item_qty_td).find("input").val();

    if (item_qty && item_alias && item_id) {
      const item = items.find((i) => i.item_id === item_id);
      if (!item) {
        return;
      }
      data.item_ids.push(item_id);
      data.items.push({
        item_id,
        item_alias,
        item_qty,
        price: item.sale_price,
      });
    }
  });

  return data;
}
