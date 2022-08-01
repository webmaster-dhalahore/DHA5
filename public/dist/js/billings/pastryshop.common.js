var current_mid = null;
var membersr = null;
const block_statuses = ["cancel", "block", "outstation"];

$(document).on("click", ".openLOV", function () {
  $("#lov_members").modal("show");
});
// function openLOVMembers() {
//   $("#lov_members").modal("show");
// }

$(document).on("blur", "#memberid", function (e) {
  const $this = $(this);
  const { value } = e.target;
  const trimmedVal = value.trim();
  $this.removeClass("is-invalid");
  if (!value.trim()) {
    $("#lov_members").modal("show");
    return;
  } else if (trimmedVal === current_mid) {
    return;
  }

  const url = `${get_mid_route}?memberid=${value}`;
  axios
    .get(url)
    .then((res) => {
      printData(res.data, value);
    })
    .catch(logErrors);
});

// used by member LOV
function printData(data, mem_id = null) {
  const { member } = data;

  const btnSubmitOne = $(".btn-save");
  const member_pic_img = $("#member_pic_img");
  const member_sign_img = $("#member_sign_img");
  const bs_input = $("#block_status");
  const mid_input = $("#memberid");
  const msr_input = $("#membersr");
  const mname_input = $("#membername");

  if (!member) {
    member_pic_img.attr("src", profile_pic);
    member_sign_img.attr("src", sign_pic);
    bs_input.removeClass("bg-green").removeClass("bg-red").val("");
    mid_input.val("");
    msr_input.val("");
    mname_input.val("");
    $("#lov_members").modal("show");
    $("#familyModalContainer").html('<h1 class="text-center">No Family</h1>');
    $("#span_membername").text("------------------");
    $("#dha_dis_per").val("");
    btnSubmitOne.attr("disabled", true);
    current_mid = mem_id;
    calculateAllRows();
    calculateOverallTotals();
    return;
  }

  btnSubmitOne.attr("disabled", false);
  const { picture, memberpic, signature, membersign } = member;
  const { memberid, membername, blockstatus, type } = member;
  membersr = member.membersr;
  current_mid = memberid;
  const cash_customers = memberid.startsWith("1");
  const pay_mode_input = $("#pay_mode");
  const el = '<option value="R" selected="selected">Member Credit</option>';
  $("#pay_mode option[value='R']").remove();
  if (cash_customers) {
    pay_mode_input.val("C");
   
    pay_mode_input.attr("disabled", false);
  } else {
    // pay_mode_input.append(
    //   $("<option>", {
    //     value: "R",
    //     text: "Member Credit",
    //   })
    // );
    pay_mode_input.append(el)
    // pay_mode_input.val("R");
    pay_mode_input.attr("disabled", true);
  }

  mid_input.val(memberid);
  msr_input.val(membersr);
  mname_input.val(membername);
  let discount = 0;

  if (type && type.subscription) {
    discount = type.subscription.dhadiscount;
  }

  $("#dha_dis_per").val(discount);

  if (block_statuses.includes(blockstatus.toLocaleLowerCase())) {
    bs_input.removeClass("bg-green").addClass("bg-red").val("IN-ACTIVE");
    btnSubmitOne.attr("disabled", true);
  } else {
    bs_input.removeClass("bg-red").addClass("bg-green").val("ACTIVE");
    btnSubmitOne.attr("disabled", false);
  }

  if (picture) {
    member_pic_img.attr("src", `${picsFolderPath}/${picture}`);
  } else if (memberpic) {
    member_pic_img.attr("src", memberpic);
  } else {
    member_pic_img.attr("src", profile_pic);
  }

  if (signature) {
    member_sign_img.attr("src", `${picsFolderPath}/${signature}`);
  } else if (membersign) {
    member_sign_img.attr("src", membersign);
  } else {
    member_sign_img.attr("src", sign_pic);
  }

  getFamily(membersr);
  calculateAllRows();
  calculateOverallTotals();
  $("#remarks").focus();
}

// function getFamily(membersr) {
//   const formData = new FormData();
//   formData.append("_token", csrf_token);
//   formData.append("membersr", membersr);
//   axios
//     .post(member_family_route, formData)
//     .then((res) => {

//     })
//     .catch(logErrors);
// }

function placeImage(element, data, defaultPic) {
  const { img, blob } = data;
  if (img) {
    element.attr("src", `${picsFolderPath}/${img}`);
  } else if (blob) {
    element.attr("src", blob);
  } else {
    element.attr("src", defaultPic);
  }
}

$(document).on("submit", "form", function (e) {
  e.preventDefault();
  const $this = $(this);

  const mid_input = $("#memberid");
  const mid_val = mid_input.val().trim();
  if (!mid_val) {
    mid_input.addClass("is-invalid");
    return;
  } else {
    mid_input.removeClass("is-invalid");
  }

  let has_error = false;

  $("#sale_items_tbl > tbody > tr").each(function (index, el) {
    const $this = $(this);
    const item_alias_input = $this.find("td:nth-child(2)").find("input");
    const item_id = $this.find("td:nth-child(3)").find("input").val();
    const item_alias = item_alias_input.val();
    const item_qty_input = $this.find("td:nth-child(5)").find("input");
    const item_qty = item_qty_input.val().trim();

    if (item_alias && item_id && !item_qty) {
      item_qty_input.addClass("is-invalid");
      if (!has_error) has_error = true;
    } else {
      item_qty_input.removeClass("is-invalid");
    }

    if (item_qty && !item_alias) {
      item_alias_input.addClass("is-invalid");
      if (!has_error) has_error = true;
    } else {
      item_alias_input.removeClass("is-invalid");
    }
  });

  console.log(has_error ? "errors" : "no errors", has_error);

  if (has_error) {
    return;
  }

  $('#pay_mode').prop("disabled", false);

  const formData = new FormData(document.getElementById("form"));
  const item_data = getItemsToSubmit();
  formData.append("items", JSON.stringify(item_data.items));
  formData.append("item_ids", JSON.stringify(item_data.item_ids));

  const action = $this.attr("action") || create_bill_route;
  // formData.append('memberid', 'R-5464645x')
  axios
    .post(action, formData)
    .then(({ data }) => {
      console.log(data);
    })
    .catch((e) => {
      console.log(e)
      console.log(e.response.data)
      const errors = e?.response?.data?.errors || null;
      let message = "Error while saving the data.";
      if (errors) {
        Object.keys(errors).forEach((id) => {
          $(`#${id}`).addClass("is-invalid");
          $(`#ifb_${id}`).text(errors[id][0]);
        });

        // Command: toastr["error"](message);
        Swal.fire("Oppss!", message, "error");
      }
    });
});
