// Restricts input for the set of matched elements to the given inputFilter function.
var allowed_submit = true;
var is_required = true;

(function ($) {
  $.fn.inputFilter = function (callback, errMsg) {
    return this.on(
      "input keydown keyup mousedown mouseup select contextmenu drop focusout",
      function (e) {
        if (callback(this.value)) {
          // Accepted value
          if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
            $(this).removeClass("input-error");
            this.setCustomValidity("");
          }
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          // Rejected value - restore the previous one
          $(this).addClass("input-error");
          this.setCustomValidity(errMsg);
          this.reportValidity();
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          // Rejected value - nothing to restore
          this.value = "";
        }
      }
    );
  };
})(jQuery);

function setInputFilter(textbox, inputFilter, errMsg) {
  [
    "input",
    "keydown",
    "keyup",
    "mousedown",
    "mouseup",
    "select",
    "contextmenu",
    "drop",
    "focusout",
  ].forEach(function (event) {
    textbox.addEventListener(event, function (e) {
      if (inputFilter(this.value)) {
        // Accepted value
        if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
          this.classList.remove("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        this.classList.add("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
      }
    });
  });
}

function checkFields(form) {
  var checks_radios = form.find(":checkbox, :radio"),
    inputs = form
      .find(":input")
      .not(checks_radios)
      .not('[type="submit"],[type="button"],[type="reset"],[type="hidden"]'),
    checked = checks_radios.filter(":checked"),
    filled = inputs.filter(function () {
      // console.log({ v: $.trim($(this).val()) });
      return $.trim($(this).val()).length > 0;
    });

  if (checked.length + filled.length === 0) {
    return false;
  }

  return true;
}

function onlyIntValues(element, errMsg = "Only digits are allowed") {
  const el = document.getElementById(element);
  setInputFilter(el, (value) => /^\d*\.?\d*$/.test(value), errMsg);
}

function onlyFloatValues(element) {
  onlyIntValues(element, "Only digits and '.' are allowed");
}

function onlyPhoneNumbers(element) {
  const el = document.getElementById(element);
  const errMsg = "Only numbers, (+ - ()) are allowed";
  setInputFilter(el, (value) => /^[0-9,-\s\(\)\+]*$/.test(value), errMsg);
}

function onlyUnique(value, index, self) {
  return self.indexOf(value) === index;
}

function getAge(d1, d2) {
  d2 = d2 || new Date();
  var diff = d2.getTime() - d1.getTime();
  return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
}

$("form").on("keyup keypress", function (e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13 && !allowed_submit) {
    e.preventDefault();
    return false;
  }
});

function debounce(cb, delay = 1000) {
  let timeout;
  return (...args) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      cb(...args);
    }, delay);
  };
}

function logErrors(e) {
  console.log("error (e) ---", e);
  console.log("e.response.data (e) ---", e.response?.data);
}

var formatter = new Intl.NumberFormat("en-US", {
  style: "currency",
  currency: "PKR",

  // These options are needed to round to whole numbers if that's what you want.
  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
  //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}
