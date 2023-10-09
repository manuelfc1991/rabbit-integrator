function new_paypal_form_submit() {
  if (validate("#rabbit-integrator-template-new")) {
    $btn_element = jQuery("#rabbit-integrator-paypal-submit");
    $btn_element
      .prop("disabled", true)
      .html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...'
      );
    jQuery.ajax({
      url: ajaxurl,
      data: {
        template_data: jQuery("#rabbit-integrator-template-new").serialize(),
        action: "rabbit_integrator_new_template",
      },
      type: "POST",
      dataType: "json",
      success: function (json) {
        $btn_element.prop("disabled", false).html("Submit");
        if (json.msg == "Y") {
          html =
            "<div class='rabbit-integrator-popup-success'><strong>Template created Successfully.</strong></div>";
          jQuery(".rabbit-integrator-popup-wrap").append(html);
          jQuery("#rabbit-integrator-template-new").trigger("reset");
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

  jQuery(
    "#price,#button-text,#button-text-size,#button-width,#button-height,#button-text-color,#button-color"
  ).on("keyup", function (e) {
    // jQuery(".rabbit-integrator-paypal-btn").removeClass(
    //   "rabbit-integrator-paypal-btn-default"
    // );
    var price = jQuery("#price").val();
    var button_txt = jQuery("#button-text").val();
    var button_txt_size = jQuery("#button-text-size").val();
    var button_width = jQuery("#button-width").val();
    var button_height = jQuery("#button-height").val();
    var button_color = jQuery("#button-text-color").val();
    var button_bg_color = jQuery("#button-color").val();
    if (
      price !== "" ||
      button_txt !== "" ||
      button_txt_size !== "" ||
      button_width !== "" ||
      button_height !== "" ||
      button_color !== "" ||
      button_bg_color !== ""
    ) {
      jQuery(".rabbit-integrator-paypal-btn span").text(button_txt);
      jQuery(".rabbit-integrator-paypal-btn").css(
        "font-size",
        button_txt_size + "px"
      );
      jQuery(".rabbit-integrator-paypal-btn").css("width", button_width + "px");
      jQuery(".rabbit-integrator-paypal-btn").css(
        "height",
        button_height + "px"
      );
      jQuery(".rabbit-integrator-paypal-btn").css("color", button_color);
      jQuery(".rabbit-integrator-paypal-btn").css(
        "background-color",
        button_bg_color
      );
    }
  });
  jQuery("input#button-text-color, input#button-color").simpleColorPicker({
    onChangeColor: function (color) {
      jQuery(this).keyup();
    },
  });
});
