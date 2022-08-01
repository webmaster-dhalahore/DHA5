const member_pic = document.getElementById("memberpic");
const member_sign = document.getElementById("membersign");

const member_pic_img = document.getElementById("member_pic_img");
const member_sign_img = document.getElementById("member_sign_img");

$("#member_pic_img").click(function () {
  member_pic.click();
});
$("#member_sign_img").click(function () {
  member_sign.click();
});

$(function () {
  $("#typeid").trigger("blur");
  $("#occupationid").trigger("blur");
  $("#mobileno").trigger("blur");
  $("#memberid").focus();
});

function log(...args) {
  if (true) {
    console.log(...args);
  }
}

function gotopage() {
  const memberid = $("#memberid").val().trim().toUpperCase();
  if(!memberid){
    // Swal.fire('Please Provida a Member ID')
    return;
  }
  const url = `${_baseURL}members/${memberid}/edit`;
  window.location.href = url;
}

async function getProfession(e) {
  const code = e.target.value;
  const desc = $("#profession_desc");
  if (!code) {
    desc.val("");
    return;
  }
  try {
    const p = await getProfessionData();
    const profession = p.find((x) => Number(x.code) === Number(code));
    const msg = "Not a valid Profession";
    const profession_desc = (profession && profession.des) || msg;
    desc.val(profession_desc);
  } catch (error) {
    getProfession(e);
  }
}

async function getMemberTypes(e) {
  const code = e.target.value;
  const desc = $("#member_type_desc");
  if (!code) {
    desc.val("");
    return;
  }
  try {
    const mts = await getMemberTypesData();
    const mt = mts.find((mt) => Number(mt.code) === Number(code));
    const member_type_desc = (mt && mt.des) || "Not a valid Member Type";
    desc.val(member_type_desc);
  } catch (error) {
    getMemberTypes(e);
  }
}

$(document).on("blur", "#typeid", getMemberTypes);
$(document).on("blur", "#occupationid", getProfession);

function previewImage(source, destination, dest_img = "#") {
  const [file] = source.files;
  if (file && file.type.includes("image")) {
    destination.src = URL.createObjectURL(file);
  } else {
    destination.src = dest_img;
  }
}

member_pic.onchange = () => {
  previewImage(member_pic, member_pic_img, profile_pic);
};
member_sign.onchange = () => {
  previewImage(member_sign, member_sign_img, sign_pic);
};

function openProfessionsLOV() {
  $("#lov_profession").modal("show");
}

function openMemberTypeLOV() {
  $("#lov_membertypes").modal("show");
}

function openMembersLOV() {
  console.log('open member lov onlye');
}

// $("#form").on("keyup keypress", function (e) {
//   var keyCode = e.keyCode || e.which;
//   if (keyCode === 13) {
//     e.preventDefault();
//     return false;
//   }
// });

$("#occupationid").on("keyup", function (e) {
  if (e.key === "Enter" || e.keyCode === 13) {
    const occupationid = $("#occupationid");
    if (!occupationid.val().trim()) {
      openProfessionsLOV();
    }
  }
});

// $("body").on("keydown", "input, select", function (e) {
//   if (e.which === 13) {
//     var self = $(this),
//       form = self.parents("form:eq(0)"),
//       focusable,
//       next;
//     focusable = form
//       .find("input:not(:read-only),select,textarea")
//       .filter(":visible");
//     next = focusable.eq(focusable.index(this) + 1);
//     if (next.length) {
//       next.focus();
//     }
//     return false;
//   }
// });

onlyIntValues("typeid");
onlyIntValues("occupationid");
onlyIntValues("pano");
onlyPhoneNumbers("mobileno");
onlyPhoneNumbers("mobileno2");
onlyPhoneNumbers("phoneoffice");
onlyPhoneNumbers("phoneresidence");
onlyPhoneNumbers("fax");

$(document).on("keydown", "#club_name", function (event) {
  event.preventDefault();
  return false;
});

$(document).on("blur", "#mobileno", function (e) {
  const value = e.target.value.trim();
  if (value) {
    $("#mobileno2").attr("readonly", false);
  } else {
    $("#mobileno2").attr("readonly", true);
  }
});

document.addEventListener("keydown", onKeyDown, false);

function onKeyDown(e) {
  var x = e.keyCode;
  if (x == 118) {
    window.location.href = create_page_url;
  }
}

// async function searchByAnyField() {
//   console.log("You can search by any field now");
//   form = document.getElementById("form");
//   const formData = new FormData(form);

//   try {
//     const { data } = axios.post(
//       "http://127.0.0.1:8000/membership/member-search",
//       formData
//     );
//     console.log(data);
//   } catch (e) {
//     console.log(e, e.response.data);
//   }
// }

// $('#form').parsley()
