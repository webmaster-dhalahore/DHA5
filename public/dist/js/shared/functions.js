$("form").on("keyup keypress", function (e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) {
    e.preventDefault();
    return false;
  }
});

$("body").on("keydown", "input, select", function (e) {
  if (e.which === 13) {
    var self = $(this),
      form = self.parents("form:eq(0)"),
      focusable,
      next;
    focusable = form
      .find("input:not(:read-only),select,textarea")
      .filter(":visible");
    next = focusable.eq(focusable.index(this) + 1);
    if (next.length) {
      next.focus();
    }
    return false;
  }
});
