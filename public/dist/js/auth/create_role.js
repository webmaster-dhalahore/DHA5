let permissions = [];
let selected_permission = null;
let selected_permissions = [];
let selected_permissions_ids = [];

async function getPermissions() {
  try {
    const { data } = await axios.get(permission_route);

    permissions = Object.keys(data).map((k) => {
      const { fullForm } = data[k];
      const perms = data[k].data;

      const str = `${k} Report`;

      const reports = perms.filter((p) => p.name.startsWith(str));
      const forms = perms.filter((p) => !p.name.startsWith(str));

      return { key: k, data: { reports, forms }, fullForm };
    });

    // console.log(permissions);
    renderPermissionTypesOptions();
  } catch (e) {
    console.log(e);
    console.log(e?.response?.data);
  }
}

function renderPermissionTypesOptions() {
  const per_list = $("#permissions_by_type");
  permissions.forEach((p) => {
    const option = `<option value="${p.key}" data-ff="${p.fullForm}">${p.fullForm}</option>`;
    per_list.append(option);
  });
}

$(document).on("change", "#permissions_by_type", function (e) {
  const $this = $(this);
  const k = $this.val();
  $("#select_all").prop("checked", false);
  // const dt_table = $('#dt_permissions')
  const tbody = $("#permission_tbody");
  tbody.html("");
  selected_permission = permissions.find((p) => p.key == k);

  const { fullForm, data } = selected_permission;
  const { reports, forms } = data;

  if (forms.length) {
    const title_tr = `<tr class="bg-white text-center"><th colspan="3">${fullForm} Forms</th></tr>`;
    tbody.append(title_tr);
    forms.forEach((f) => {
      tbody.append(getTR(f));
    });
  }

  if (reports.length) {
    const title_tr = `<tr class="bg-white text-center"><th colspan="3">${fullForm} Reports</th></tr>`;
    tbody.append(title_tr);

    reports.forEach((r) => {
      tbody.append(getTR(r));
    });
  }
});

function getTR({ id, name, description }) {
  const x = selected_permissions_ids.find((sid) => sid === id);
  const checkbox = `<input 
    type="checkbox" 
    class="permission_cls" 
    value="${id}" 
    id="permission_${id}" 
    name="permissions[]" 
    ${x ? "checked" : ""} />`;

  const chkDiv = `<div class="icheck-primary d-inline">
    ${checkbox}<label for="permission_${id}">${name}</label>
  </div>`;

  return `<tr>
    <td>${chkDiv}</td>
    <td>${description}</td>
  </tr>`;
}

getPermissions();

$(document).on("change", ".permission_cls", function () {
  const $this = $(this);
  // console.log('triggered', $this.val(), $this);
  // return
  const sid = parseInt($this.val()); //selected_id
  if ($this.prop("checked")) {
    addSelectedItem(sid);
  } else {
    selected_permissions_ids = selected_permissions_ids.filter(
      (id) => id !== sid
    );
    const { key } = selected_permission;

    const sel_per = selected_permissions.find((sp) => sp.key === key);

    let forms = sel_per?.data?.forms?.filter((f) => f.id !== sid);
    let reports = sel_per?.data?.reports?.filter((r) => r.id !== sid);
    const filtered_obj = { ...sel_per, data: { forms, reports } };

    selected_permissions = selected_permissions.map((sp) => {
      if (sp.key === key) {
        return filtered_obj;
      }
      return sp;
    });
  }

  triggerAddSelectedPermissions();
});

function addSelectedItem(id) {
  selected_permissions_ids.push(id);
  const { key, fullForm, data } = selected_permission;
  const { forms, reports } = data;
  let data_key = "forms";
  let selected_item = forms.find((d) => d.id === id);
  if (!selected_item) {
    data_key = "reports";
    selected_item = reports.find((d) => d.id === id);
  }

  if (!selected_item) return;

  const current_obj = { id: selected_item.id, name: selected_item.name };

  const new_obj = {
    key,
    fullForm,
    data: { [data_key]: [{ ...current_obj }] },
  };
  const is_added_before = selected_permissions.find((sp) => sp.key === key);

  if (!is_added_before) {
    selected_permissions.push(new_obj);
    return;
  }

  if (is_added_before.data[data_key] !== undefined) {
    const data_obj = is_added_before.data[data_key];
    var i = data_obj.findIndex((x) => x.id === id);
    if (i === -1) data_obj.push(current_obj);
  } else {
    is_added_before.data[data_key] = [current_obj];
  }
}

$(document).on("click", "#dummy", function () {
  console.log(selected_permissions);
  console.log(selected_permissions_ids);
});

function triggerAddSelectedPermissions() {
  const permissions_div = $("#selected_permission_div");
  permissions_div.html("");
  let counter = 1;

  selected_permissions.forEach((sp, index) => {
    // console.log({index, sp});
    const { fullForm, data, key } = sp;
    const { reports, forms } = data;

    if (forms && forms.length) {
      let row = ``;
      forms.forEach(({ name, id }) => {
        row += coordianRow(counter++, name, key, "forms", id, index);
      });

      const title = `${fullForm} Forms`;
      const html = getCoordianBody(`${key}_forms`, title, row);
      permissions_div.append(html);
    }

    if (reports && reports.length) {
      let row = ``;
      reports.forEach(({ name, id }) => {
        row += coordianRow(counter++, name, key, "reports", id, index);
      });

      const title = `${fullForm} Reports`;
      const html = getCoordianBody(`${key}_reports`, title, row);
      permissions_div.append(html);
    }
  });
}

// function xyz(key, data_key, id, index) {
//   // console.log({ key, data_key, id, index });
//   const data = selected_permissions[index]['data'][data_key];
//   const filtered_data = data.filter(d => d.id !== id)
//   console.log(`selected_permissions before`, selected_permissions);
//   const newPermissions = selected_permissions.filter(sp => {
//     if(sp.key === key){
//       // console.log('key found');
//       const filtered_sp = sp;
//       const a = filtered_sp.data[data_key].filter(d => d.id !== id)
//       const newObj = {...filtered_sp, data: {...filtered_sp.data, [data_key]: a}}
//       console.log('key found', newObj, a);
//       return newObj
//     }
//     return sp;
//   })
//   selected_permissions = newPermissions
//   console.log(`selected_permissions after`, newPermissions);
//   // triggerAddSelectedPermissions()
//   console.log({data, filtered_data});

// }

function coordianRow(counter, title, key, data_key, id, index) {
  // console.log("sp", sp);
  return `<div class="col-sm-1 mb-2">${counter}</div>
  <div class="col-sm-11">
    <div class="icheck-primary d-inline">
      <input type="checkbox" checked />
      <label>${title}</label>
    </div>
  </div>`;
}

function getCoordianBody(id, title, body) {
  return `<div class="card card-primary mb-2">
  <p 
  class="card-header text-bold py-2" 
  style="cursor: pointer" 
  data-toggle="collapse" 
  aria-expanded="true" 
  data-target="#${id}" 
  aria-controls="${id}"
>${title}</p>

<div id="${id}" class="collapse show" data-parent="#accordion">
  <div class="card-body">
    <div class="row">
    ${body}
    </div>
  </div>
</div>
</div>`;
}

$(document).on("click", "#select_all", function (event) {
  if (this.checked) {
    // Iterate each checkbox
    $(".permission_cls")
      .each(function () {
        this.checked = true;
      })
      .trigger("change");
  } else {
    $(".permission_cls")
      .each(function () {
        this.checked = false;
      })
      .trigger("change");
  }
});

document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("form")
    .addEventListener("submit", async function (e) {
      e.preventDefault();

      const $this = $(this);
      const url = $this.attr("action");
      console.log($this.attr("action"));
      console.log($this.prop("action"));
      // return
      const submitBtn = $("#btn_submit");
      const submitBtnSapn = $("#btn_submit_span");
      $(".is-invalid").removeClass("is-invalid");
      submitBtn.prop("disabled", true);
      submitBtnSapn.text("Please wait...");
      const formData = new FormData(this);
      for (var i = 0; i < selected_permissions_ids.length; i++) {
        formData.append("permission_ids[]", selected_permissions_ids[i]);
      }

      try {
        const { data } = await axios.post(url, formData);
        const { sessionMsg, redirect_to } = data;
        const { type, message, expression } = sessionMsg;

        
        submitBtn.prop("disabled", false);
        submitBtn.removeClass("btn-danger");
        // submitBtn.addClass("btn-success");
        submitBtnSapn.text("Create Role");
        // setTimeout(() => {
        //   submitBtn.removeClass("btn-danger");
        //   submitBtn.removeClass("btn-success");
        //   submitBtnSapn.text("Save Changes");
        //   if (success) {
        //     window.location.href = hrefStr;
        //   }
        // }, 3000);

        // Command: toastr[type](message);

        Swal.fire({
          icon: type,
          title: expression,
          text: message,
        }).then(() => {
          // window.location.href = redirect_to
          console.log("redirect here");
        });
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

        submitBtn.prop("disabled", false);
        submitBtn.addClass("btn-danger");
        submitBtn.removeClass("btn-success");
        submitBtnSapn.text("Error while saving");

        setTimeout(() => {
          submitBtn.removeClass("btn-danger");
          submitBtn.removeClass("btn-success");
          submitBtnSapn.text("Save Changes");
        }, 2000);
      }
    });
});
