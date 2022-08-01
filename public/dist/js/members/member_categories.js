$("#category_modal").on("hide.bs.modal", function () {
  $("#member_category").removeClass("is-invalid").val("");
  $("#member_abbr").removeClass("is-invalid").val("");
});

$("#category_modal_edit").on("hide.bs.modal", function () {
  $("#member_category_edit").removeClass("is-invalid").val("");
  $("#member_abbr_edit").removeClass("is-invalid").val("");
});

$(document).on("click", "#add_new_member_category", function () {
  $("#category_modal").modal("show");
});

document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("category_form")
    .addEventListener("submit", async function (e) {
      e.preventDefault();
      const action = this.action;

      const submitFBTN = $("#btn_submit_category");
      const submitFBTNSapn = $("#btn_submit_category_span");
      $(".is-invalid").removeClass("is-invalid");
      submitFBTN.prop("disabled", true);
      submitFBTNSapn.text("Please wait...");
      const formData = new FormData(this);
      try {
        const { data } = await axios.post(action, formData);
        const { success, sessionMsg } = data;
        const { type, message } = sessionMsg;

        submitFBTN.prop("disabled", false);
        submitFBTN.removeClass("btn-danger");
        submitFBTN.addClass("btn-success");
        submitFBTNSapn.text("Changes saved");
        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTNSapn.text("Save Changes");
          if (success) {
            window.location.href = route_home;
          }
        }, 3000);

        Command: toastr[type](message);
      } catch (e) {
        const errors = e?.response?.data?.errors || null;
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

  document
    .getElementById("category_form_edit")
    .addEventListener("submit", async function (e) {
      e.preventDefault();
      const action = this.action;

      const submitFBTN = $("#btn_submit_category_edit");
      const submitFBTNSapn = $("#btn_submit_category_edit_span");
      $(".is-invalid").removeClass("is-invalid");
      submitFBTN.prop("disabled", true);
      submitFBTNSapn.text("Please wait...");
      const formData = new FormData(this);
      try {
        const { data } = await axios.post(action, formData);
        const { success, sessionMsg } = data;
        const { type, message } = sessionMsg;

        submitFBTN.prop("disabled", false);
        submitFBTN.removeClass("btn-danger");
        submitFBTN.addClass("btn-success");
        submitFBTNSapn.text("Changes saved");
        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTNSapn.text("Save Changes");
          if (success) {
            window.location.href = route_home;
          }
        }, 3000);

        Command: toastr[type](message);
      } catch (e) {
        const errors = e?.response?.data?.errors || null;
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

function edit(code, des, abbr) {
  if (code && des) {
    $("#code").val(code);
    $("#member_category_edit").val(des);
    $("#member_abbr_edit").val(abbr);
    $("#edit_des").text(des);
    $("#category_modal_edit").modal("show");
  }
}

function deleteCategory(code) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
    customClass: {
      confirmButton: "shadow-none",
      cancelButton: "shadow-none",
    },
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const formData = new FormData();
        formData.append("_token", csrf_token);
        formData.append("code", code);
        axios.post(delete_route, formData);
        Swal.fire("Deleted!", "Member type has been deleted.", "success");
        window.location.href = route_home;
      } catch (e) {
        Swal.fire("Error!", "Member type could not been deleted.", "success");
      }
    }
  });
}
