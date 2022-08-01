$(document).on("click", "#btnSearchView", gotoView);
$(document).on("keydown", "#memberid_search", function (e) {
  const { key, keyCode } = e;
  if (key === "Enter" || keyCode === 13 || key === "F8" || keyCode === 119) {
    gotoView(e);
  }
});

function gotoView(e) {
  const memberid = $("#memberid_search").val();
  window.location.href = `${route}?memberid=${memberid}`;
}
