// member_pic.onchange = (evt) => {
//   const [file] = member_pic.files;
//   if (file) {
//     member_pic_img.src = URL.createObjectURL(file);
//   }
// };

// $(function () {
//   $("#typeid").trigger("blur");
//   $("#occupationid").trigger("blur");
// });

/*** EDIT MEMBER CODE */

$("#modal_family").on("shown.bs.modal", function () {
  $("#member_sr_fk").val($("#membersr").val());
  $("#member_family_id").focus();
});

$("#show_family_modal").on("hide.bs.modal", function () {
  $("#mf_pic_view").attr("src", old_family_profile_pic);
  $("#mf_sign_view").attr("src", old_family_sign_pic);
});

$("#modal_family").on("hide.bs.modal", function () {
  // $("#member_sr_fk").val("");
  $("#family_vno").val("");
  $("#member_family_id").val("");
  $("#member_family_dob").val("");
  $("#member_family_name").val("");
  $("#member_familY_sr").val("");
  $("#member_relation").val("");
  $("#credit_allowed").val("");
  $("#mf_pic").attr("src", old_family_profile_pic);
  $("#mf_sign").attr("src", old_family_sign_pic);
  const submitFBTN = $("#btn_submit_family");
  submitFBTN.prop("disabled", false);
  submitFBTN.removeClass("btn-danger");
  submitFBTN.removeClass("btn-success");
  $("#btn_submit_family_span").text("Save Changes");
  $(".is-invalid").removeClass("is-invalid");
  $("#family_form").parsley().reset();
});

function addNewFamilyModal(membersr) {
  const membername = $("#membername").val();
  const memberid = $("#memberid").val();
  $("#span_membername").text(`${membername} (${memberid})`);
  $("#modal_family").modal("show");
}

async function editFamilyModal(vno) {
  family_profile_pic = old_family_profile_pic;
  family_sign_pic = old_family_sign_pic;

  try {
    const { data } = await axios.get(`${_baseURL}api/v1/familyByVNO/${vno}`);
    $("#modal_family").modal("show");
    $("#show_family_modal").modal("hide");
    const membername = $("#membername").val();
    const memberid = $("#memberid").val();
    $("#span_membername").text(`${membername} (${memberid})`);
    if (data.data) {
      const dob = data?.data?.dob
        ? moment(data.data.dob).format("YYYY-MM-DD")
        : "";
      //new Date(data.data.dob).toISOString().slice(0, 10);
      const card_issue_date = data?.data?.cardissuedate
        ? moment(data.data.cardissuedate).format("YYYY-MM-DD")
        : "";
      const card_expiry_date = data?.data?.cardexpirydate
        ? moment(data.data.cardexpirydate).format("YYYY-MM-DD")
        : "";

      const formIssued = data?.data?.membership_form ? "1" : "0";

      $("#member_sr_fk").val(data.data.fkmembersr);
      $("#family_vno").val(vno);
      $("#member_family_id").val(data.data.memberid); // 2017-06-01
      $("#member_family_dob").val(dob); // 2017-06-01
      $("#member_family_name").val(data.data.membername);
      $("#member_familY_sr").val(data.data.vno);
      $("#member_relation").val(data.data.relation);
      $("#credit_allowed").val(data.data.creditallow);
      $("#member_family_card_issue_date").val(card_issue_date);
      $("#member_family_card_expiry_date").val(card_expiry_date);
      $("#membership_form").val(formIssued);

      if (data.data.picture) {
        // src="http://127.0.0.1:8000/dist/img/profile_pic01.jpg"
        $("#mf_pic").attr("src", `${picsFolderPath}/${data.data.picture}`);
        family_profile_pic = data.data.fmemberpic;
      } else if (data.data.fmemberpic) {
        $("#mf_pic").attr("src", data.data.fmemberpic);
        family_profile_pic = data.data.fmemberpic;
      } else {
        $("#mf_pic").attr("src", old_family_profile_pic);
        family_profile_pic = old_family_profile_pic;
      }

      if (data.data.signature) {
        $("#mf_sign").attr("src", `${picsFolderPath}/${data.data.signature}`);
        family_sign_pic = data.data.fmembersign;
      } else if (data.data.fmembersign) {
        $("#mf_sign").attr("src", data.data.fmembersign);
        family_sign_pic = data.data.fmembersign;
      } else {
        $("#mf_sign").attr("src", old_family_sign_pic);
        family_sign_pic = old_family_sign_pic;
      }
    }
  } catch (e) {
    console.log("error---", e.response.data);
    console.log("error---", e);
  }
}

async function showFamilModal(vno) {
  try {
    const { data } = await axios.get(`${_baseURL}api/v1/familyByVNO/${vno}`);
    $("#show_family_modal").modal("show");
    const membername = $("#membername").val();
    const memberid = $("#memberid").val();
    $("#span_membername_view").text(`${membername} (${memberid})`);
    if (data.data) {
      const { cardissuedate, cardexpirydate, membership_form, dob } = data.data;
      const { creditallow, relation, picture, signature } = data.data;
      const { fmembersign, fmemberpic } = data.data;

      const card_issue_date = cardissuedate
        ? moment(cardissuedate).format("DD-MMM-YYYY")
        : "";
      const dob_ = dob ? moment(dob).format("DD-MMM-YYYY") : "";
      const card_expiry_date = cardexpirydate
        ? moment(cardexpirydate).format("DD-MMM-YYYY")
        : "";

      let formIssued = "NO";
      let formModifier = "";
      if (membership_form) {
        const { formIssuer } = data.data;
        formIssued = '<i class="fas fa-check mr-2 text-green"></i> ';
        if (formIssuer) {
          formIssued += `By : <strong>${formIssuer.name} </strong>`;
        }
        if (membership_form) {
          const dt = moment(membership_form).format("DD MMMM, YYYY @ h:mm a");
          formIssued += `<br />Date - <strong>${dt}</strong>`;
        }
      }

      if (data.data.updated_by) {
        const { modifier, updated_at } = data.data;
        formModifier = modifier.name;
        const dt = moment(updated_at).format("DD MMMM, YYYY @ h:mm a");
        formModifier += `<br />Date - <strong>${dt}</strong>`;
      }

      $("#div_view_mid").text(data.data.memberid); // 2017-06-01
      $("#div_view_dob").text(dob_); // 2017-06-01
      $("#div_view_mname").text(data.data.membername);
      $("#div_view_relation").text(relation);
      $("#div_view_credit_allowed").text(creditallow ? "YES" : "NO");
      $("#div_card_issue_date").text(card_issue_date);
      $("#div_card_expiry_date").text(card_expiry_date);
      $("#div_membership_form").html(formIssued);
      $("#div_modified_by").html(formModifier);

      if (picture) {
        $("#mf_pic_view").attr("src", `${picsFolderPath}/${picture}`);
      } else if (fmemberpic) {
        $("#mf_pic_view").attr("src", fmemberpic);
      } else {
        $("#mf_pic_view").attr("src", old_family_profile_pic);
      }
      if (signature) {
        const img = `${picsFolderPath}/${signature}`;
        $("#mf_sign_view").attr("src", img);
      } else if (fmembersign) {
        $("#mf_sign_view").attr("src", fmembersign);
      } else {
        $("#mf_sign_view").attr("src", old_family_sign_pic);
      }

      $("#edit_btn_spn_view").html(
        `<button type="button" class="btn btn-danger btn-sm" onclick="editFamilyModal('${vno}')"><i class="fas fa-edit mr-2"></i> Edit</button>`
      );
    } else {
      alert("Error Occured Please try again");
    }
  } catch (e) {
    let message = "Error while saving the data.";
    if (e?.response?.data?.sessionMsg) {
      const { data } = e.response;
      const { sessionMsg } = data;
      message = sessionMsg.message;
    }

    Command: toastr["error"](message);
    console.log("error---", e);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("family_form")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const vno = $("#family_vno").val();
      if (vno && !confirm("Are you sure you want to save this?")) return;

      const submitFBTN = $("#btn_submit_family");
      const submitFBTNSapn = $("#btn_submit_family_span");
      $(".is-invalid").removeClass("is-invalid");
      submitFBTN.prop("disabled", true);
      submitFBTNSapn.text("Please wait...");
      const formData = new FormData(this);
      try {
        const url = `${_baseURL}members/family`;
        const { data } = await axios.post(url, formData);
        const { success, sessionMsg } = data;
        const { type, message } = sessionMsg;

        const { pathname, origin } = window.location;
        let hrefStr = `${origin}${pathname}`;
        if (!getField("tab")) {
          hrefStr += "?tab=family";
        }

        submitFBTN.prop("disabled", false);
        submitFBTN.removeClass("btn-danger");
        submitFBTN.addClass("btn-success");
        submitFBTNSapn.text("Changes saved");
        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTNSapn.text("Save Changes");
          if (success) {
            window.location.href = hrefStr;
          }
        }, 3000);

        Command: toastr[type](message);
      } catch (e) {
        const errors = e?.response?.data?.errors || null;
        console.log(e, e.response);
        let message = "Error while saving the data.";
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

        submitFBTN.prop("disabled", false);
        submitFBTN.addClass("btn-danger");
        submitFBTN.removeClass("btn-success");
        submitFBTNSapn.text("Error while saving");

        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTNSapn.text("Save Changes");
        }, 2000);
      }
    });
});

const member_family_pic = document.getElementById("member_family_pic");
const mf_pic = document.getElementById("mf_pic");
member_family_pic.onchange = () => {
  previewImage(member_family_pic, mf_pic, family_profile_pic);
};

const member_family_sign = document.getElementById("member_family_sign");
const mf_sign = document.getElementById("mf_sign");
member_family_sign.onchange = () => {
  previewImage(member_family_sign, mf_sign, family_sign_pic);
};

function getField(filedname) {
  var field = filedname;
  const { pathname, origin } = window.location;
  var url = `${origin}${pathname}`;
  if (url.indexOf("?" + field + "=") != -1) return true;
  else if (url.indexOf("&" + field + "=") != -1) return true;
  return false;
}

function showToast({ type, message }) {
  Command: toastr[type](message);
}

$("#mf_pic").click(function () {
  $("#member_family_pic").trigger("click");
});
$("#mf_sign").click(function () {
  $("#member_family_sign").trigger("click");
});
