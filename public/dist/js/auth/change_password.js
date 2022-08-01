function openModal() {
  $("#modal_change_password").modal("show");
  $('#form_change_pwd').trigger("reset");
}

document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("form_change_pwd")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      $(".cpwd.is-invalid").removeClass("is-invalid");
      const submitFBTN = $("#btn_change_pwd");
      submitFBTN.prop("disabled", true);
      submitFBTN.text("Please wait...");
      const formData = new FormData(this);
      try {
        const { data } = await axios.post(cp_route, formData);
        const { success, sessionMsg } = data;
        // const { type, message } = sessionMsg;
        const type = sessionMsg?.type ? sessionMsg.type : "success";
        const message = sessionMsg?.message ? sessionMsg.message :"Password Changed successfully!";

        submitFBTN.prop("disabled", false);
        submitFBTN.removeClass("btn-danger");
        submitFBTN.addClass("btn-success");
        submitFBTN.text("Password Changed");
        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTN.text("Change Password");
          $("#modal_change_password").modal("hide");
        }, 2000);

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
        submitFBTN.text("Error while saving");

        setTimeout(() => {
          submitFBTN.removeClass("btn-danger");
          submitFBTN.removeClass("btn-success");
          submitFBTN.text("Change Password");
        }, 2000);
      }
    });
});
