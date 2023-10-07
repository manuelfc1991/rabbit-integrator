// Text Max Length Counter
function textMaxLengthCounter(id) {
  var $element = jQuery("#" + id);
  $element
    .parent()
    .append(
      ' <div id="excerpt-text-length-couter" style="text-align : right; color: green; position: absolute; right: 3px ; top: 3px;">' +
        $element.attr("data-validation-max-length") +
        "</div>"
    );
  $element.on("change paste keyup", function (e) {
    var text_max_length = jQuery(this).attr("data-validation-max-length");
    var $excerpt_counter = jQuery(
      "#" + jQuery(this).prop("id") + "-text-length-couter"
    );
    var text_length = jQuery(this).val().length;
    var text_length_diff = text_max_length - text_length;
    $excerpt_counter.html(text_length_diff);
    if (text_length_diff < 0) {
      jQuery(this).css("border-color", "red");
      $excerpt_counter.css("color", "red");
    } else {
      $excerpt_counter.css("color", "green");
      jQuery(this).css("border-color", "green");
    }
  });
}
// Name Validation
function validateName(name) {
  if (name != "") {
    return true;
  } else {
    return false;
  }
}
// Email Validation
function validateEmail(email) {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
// Phone Validation
function validatePhone(phone) {
  if (phone != "") {
    var match_p = /[^0-9\s+\-(\).]/im;
    if (phone.match(match_p)) {
      return false;
    } else {
      return true;
    }
  } else {
    return false;
  }
}
// URL Validation
function validateURL(str) {
  var pattern = new RegExp(
    "^(https?:\\/\\/)?" + // protocol
      "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
      "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
      "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
      "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
      "(\\#[-a-z\\d_]*)?$",
    "i"
  ); // fragment locator
  return !!pattern.test(str);
}
// Date Validation
function validateDate(dateString) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  if (!dateString.match(regEx)) return false; // Invalid format
  var d = new Date(dateString);
  var dNum = d.getTime();
  if (!dNum && dNum !== 0) return false; // NaN value, Invalid date
  return d.toISOString().slice(0, 10) === dateString;
}
// HHmm time validation
function validateHHmm(hhmm) {
  return /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(hhmm);
}
// show error
function validatorShowErrorMessage(e, m) {
  e.parent().find(".rabbit-integrator-validation-error-message").remove();
  if (e.attr("data-error-info") != "hide") {
    e.parent().append(
      '<div class="rabbit-integrator-validation-error-message">' + m + "</div>"
    );
  }
}
// clear field error
function validatorHideErrorMessage(field_ob) {
  if (field_ob.hasClass("form-validation-error")) {
    field_ob.removeClass("form-validation-error");
    field_ob
      .parent()
      .find(".rabbit-integrator-validation-error-message")
      .remove();
  }
}
function validatorHookFieldEvents() {
  jQuery(".validate-field")
    .not(".validate-field-event-hooked")
    .on("change paste keyup", function () {
      validatorHideErrorMessage(jQuery(this));
    });
  jQuery(".validate-field")
    .not(".validate-field-event-hooked")
    .on("click", function (e) {
      var field_validation_type = jQuery(this).attr("data-validation-type");
      if (
        field_validation_type == "date" ||
        field_validation_type == "time-HHmm"
      ) {
        validatorHideErrorMessage($(this));
      }
    });
  jQuery(".validate-field")
    .not(".validate-field-event-hooked")
    .addClass("validate-field-event-hooked");
}
// core
function validate(parent_element) {
  var submit = true;
  if (jQuery(parent_element).length > 0) {
    jQuery(parent_element + " .validate-field").removeClass(
      "form-validation-error"
    );
    jQuery(
      parent_element + " .rabbit-integrator-validation-error-message"
    ).remove();
    var field_type = "";
    var field_value = "";
    var field_validation_type = "";
    jQuery(parent_element + " .validate-field").each(function () {
      field_type = this.type || this.tagName.toLowerCase();
      field_value = "";
      field_is_mandatory = jQuery(this).attr("data-validation-mandatory");
      field_validation_type = jQuery(this).attr("data-validation-type");
      switch (field_type) {
        case "select":
        case "select-one":
          field_value = jQuery("option:selected", this).attr("value");
          break;
        default:
          field_value = jQuery(this).val();
      }
      if (field_is_mandatory == "yes" && field_value == "") {
        if (submit) jQuery(this).focus();
        jQuery(this).addClass("form-validation-error");
        validatorShowErrorMessage(jQuery(this), "This field is required");
        submit = false;
        //return false;
      } else if (field_value != "") {
        switch (field_validation_type) {
          case "dropdown_>_0":
            if (
              Number(field_value) != field_value ||
              field_value % 1 != 0 ||
              field_value <= 0
            ) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(jQuery(this), "This field is required");
              submit = false;
            }
            break;
          case "email":
            if (!validateEmail(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid email address"
              );
              submit = false;
            }
            break;
          case "url":
            if (!validateURL(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid URL"
              );
              submit = false;
            }
            break;
          case "phone":
            if (!validatePhone(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid phone number"
              );
              submit = false;
            }
            break;
          case "name":
            if (!validateName(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid name"
              );
              submit = false;
            }
            break;
          case "date":
            if (!validateDate(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid date"
              );
              submit = false;
            }
            break;
          case "time-HHmm":
            if (!validateHHmm(field_value)) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid time"
              );
              submit = false;
            }
            break;
          case "number":
            if (Number(field_value) != field_value) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid number"
              );
              submit = false;
            }
            break;
          case "int":
            if (Number(field_value) != field_value || field_value % 1 != 0) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid number"
              );
              submit = false;
            }
            break;
          case "int_>_0":
            if (
              Number(field_value) != field_value ||
              field_value % 1 != 0 ||
              field_value <= 0
            ) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid number"
              );
              submit = false;
            }
            break;
          case "int_>=_0":
            if (
              Number(field_value) != field_value ||
              field_value % 1 != 0 ||
              field_value < 0
            ) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid number"
              );
              submit = false;
            }
            break;
          case "float":
            if (Number(field_value) != field_value || field_value % 1 === 0) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Please enter a valid float number"
              );
              submit = false;
            }
            break;
          case "comma_seperate_emails":
            var emails = field_value.split(",");
            for (var i = 0; i < emails.length; i++) {
              var email = emails[i].trim();
              if (email != "" && !validateEmail(email)) {
                if (submit) jQuery(this).focus();
                jQuery(this).addClass("form-validation-error");
                validatorShowErrorMessage(
                  jQuery(this),
                  "Please enter a valid email address"
                );
                submit = false;
              }
            }
            break;
          case "text_max_length":
            var text_max_length = jQuery(this).attr(
              "data-validation-max-length"
            );
            var field_value_length = field_value.length;
            if (field_value_length > text_max_length) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "Text max length " +
                  text_max_length +
                  ". Yo have entered a text of length " +
                  field_value_length
              );
              submit = false;
            }
            break;
          case "file":
            var supported_file_types = jQuery(this).attr(
              "data-validation-file-types"
            );
            var supported_max_file_size = jQuery(this).attr(
              "data-validation-file-max-size"
            );
            if (!this.files) {
              // This is VERY unlikely, browser support is near-universal
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(
                jQuery(this),
                "This browser doesn't seem to support the 'files' property of file inputs."
              );
              submit = false;
            } else if (!this.files[0]) {
              if (submit) jQuery(this).focus();
              jQuery(this).addClass("form-validation-error");
              validatorShowErrorMessage(jQuery(this), "Please select a file'");
              submit = false;
            } else {
              var file_obj = this.files[0];
              var file_extension = file_obj.name.split(".").pop();
              if (
                file_extension &&
                !supported_file_types.includes(file_extension)
              ) {
                if (submit) jQuery(this).focus();
                jQuery(this).addClass("form-validation-error");
                validatorShowErrorMessage(
                  jQuery(this),
                  "Incorrect file format."
                );
                submit = false;
              }
              if (submit && file_obj.size && supported_max_file_size) {
                supported_max_file_size =
                  Number(supported_max_file_size) * 1000000;
                if (file_obj.size > supported_max_file_size) {
                  if (submit) jQuery(this).focus();
                  jQuery(this).addClass("form-validation-error");
                  validatorShowErrorMessage(
                    jQuery(this),
                    "File size(" +
                      Math.round(file_obj.size / 1000000) +
                      "MB) exceeded limit."
                  );
                  submit = false;
                }
              }
            }
            break;
          default:
        }
        /*
                if(!submit){
                    return false;
                }
                */
      }
    });
  } else {
    submit = false;
  }
  return submit;
}
// Remove Attr Required
function validatorRemoveRequiredAttr(parent_element) {
  jQuery(parent_element + " .validate-field").removeAttr("required");
}
// Normal form submit
function validateSubmit(parent_element) {
  if (jQuery(parent_element).length > 0) {
    validatorRemoveRequiredAttr(parent_element);
    jQuery(parent_element).on("submit", function (e) {
      if (!validate(parent_element)) {
        e.preventDefault();
        return false;
      } else {
        return true;
      }
    });
  }
}
jQuery(document).ready(function () {
  validatorHookFieldEvents();
});
