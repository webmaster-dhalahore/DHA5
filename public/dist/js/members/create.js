// const member_pic = document.getElementById("memberpic");
// const member_sign = document.getElementById("membersign");

// const member_pic_img = document.getElementById("member_pic_img");
// const member_sign_img = document.getElementById("member_sign_img");

// $("#member_pic_img").click(function () {
//   // $("#memberpic").trigger("click");
//   member_pic.click();
// });
// $("#member_sign_img").click(function () {
//   // $("#membersign").trigger("click");
//   member_sign.click();
// });

// function log(...args) {
//   if (true) {
//     console.log(...args);
//   }
// }

// $(document).on("change", "#club_id", function (e, x) {
//   // log({ e, x });
//   const $this = $(this);

//   log($this.val());
// });
// // member_pic.onchange = (evt) => {
// //   const [file] = member_pic.files;
// //   if (file) {
// //     member_pic_img.src = URL.createObjectURL(file);
// //   }
// // };

// function previewImage(source, destination, dest_img = "#") {
//   const [file] = source.files;
//   if (file && file.type.includes("image")) {
//     log("file detected", file);
//     destination.src = URL.createObjectURL(file);
//   } else {
//     log("file NOT detected", file);
//     destination.src = dest_img;
//   }
// }

// member_pic.onchange = (evt) => {
//   // previewImage(member_pic, member_pic_img, "dist/img/profile_pic01.jpg");
//   previewImage(member_pic, member_pic_img, profile_pic);
// };
// member_sign.onchange = (evt) => {
//   // previewImage(member_sign, member_sign_img, "dist/img/sign-placeholder.png");
//   previewImage(member_sign, member_sign_img, sign_pic);
// };

// function openProfessionsLOV() {
//   $("#lov_profession").modal("show");
// }

// function openMemberTypeLOV() {
//   $("#lov_membertypes").modal("show");
// }

// $("#form").on("keyup keypress", function (e) {
//   var keyCode = e.keyCode || e.which;
//   if (keyCode === 13) {
//     e.preventDefault();
//     return false;
//   }
// });

// $("#occupationid").on("keyup", function (e) {
//   if (e.key === "Enter" || e.keyCode === 13) {
//     const occupationid = $("#occupationid");
//     if (!occupationid.val().trim()) {
//       openProfessionsLOV();
//     }
//   }
// });

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

// async function getProfession(e) {
//   const code = e.target.value;
//   try {
//     const p = await getProfessionData();
//     const profession = p.find((x) => Number(x.code) === Number(code));
//     console.log({ code, p, profession });
//     const msg = "Not a valid Profession";
//     const profession_desc = (profession && profession.des) || msg;
//     $("#profession_desc").val(profession_desc);
//   } catch (error) {
//     getProfession(e);
//   }
// }

// async function getMemberTypes(e) {
//   const code = e.target.value;
//   try {
//     const mts = await getMemberTypesData();
//     const mt = mts.find((mt) => Number(mt.code) === Number(code));
//     const member_type_desc = (mt && mt.des) || "Not a valid Member Type";
//     $("#member_type_desc").val(member_type_desc);
//   } catch (error) {
//     getMemberTypes(e);
//   }
// }
