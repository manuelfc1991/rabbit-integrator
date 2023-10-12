function new_paypal_form_submit() {
  var rabbit_integrator_url = jQuery(".rabbit-integrator-admin-logo a").attr(
    "data-assets-url"
  );
  if (validate("#rabbit-integrator-settings")) {
    $btn_element = jQuery("#rabbit-integrator-paypal-submit");
    $btn_element
      .prop("disabled", true)
      .html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...'
      );
    jQuery.ajax({
      url: ajaxurl,
      data: {
        settings_data: jQuery("#rabbit-integrator-settings").serialize(),
        action: "rabbit_integrator_settings",
      },
      type: "POST",
      dataType: "json",
      success: function (json) {
        $btn_element.prop("disabled", false).html("Submit");
        if (json.msg == "Y") {
          jQuery(".rabbit-integrator-popup-wrap").addClass(
            "rabbit-integrator-popup-active"
          );
          jQuery("html, body").animate(
            {
              scrollTop: 0,
            },
            800
          );
          var success_text = "Settings updated successfully.";
          html =
            "<div class='rabbit-integrator-popup-success'><div class='rabbit-integrator-popup-close-btn'></div><div class='rabbit-integrator-popup-content'><img src='" +
            rabbit_integrator_url +
            "assets/images/done.png' /><strong>" +
            success_text +
            "</strong></div></div>";
          var success_popup = jQuery(html).hide();
          jQuery(".rabbit-integrator-popup-wrap").append(success_popup);
          success_popup.show(400);
        } else if (json.status == "N") {
        }
      },
      error: function (err) {},
    });
  }
}
jQuery(document).ready(function (e) {
  jQuery("#rabbit-integrator-paypal-submit").on("click", function (e) {
    e.preventDefault();
    new_paypal_form_submit();
  });
  jQuery(document).on(
    "click",
    ".rabbit-integrator-popup-close-btn",
    function (e) {
      e.preventDefault();
      jQuery(".rabbit-integrator-popup-success").hide(200);
      setTimeout(function () {
        jQuery(".rabbit-integrator-popup-success").remove();
        jQuery(".rabbit-integrator-popup-wrap").removeClass(
          "rabbit-integrator-popup-active"
        );
      }, 500);
    }
  );
});
