$(document).on("change", "#club", function (e) {
  const code = $(this).find(":selected").data("code");
  $("#club_code").val(code);
});

$(function(){
  $("#club").trigger("change");
})