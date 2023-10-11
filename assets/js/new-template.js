function new_paypal_form_submit() {
  var rabbit_integrator_url = jQuery(".rabbit-integrator-admin-logo a").attr(
    "data-assets-url"
  );
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
          jQuery(".rabbit-integrator-popup-wrap").addClass(
            "rabbit-integrator-popup-active"
          );
          jQuery("html, body").animate(
            {
              scrollTop: 0,
            },
            800
          );
          var success_text = "Template created successfully.";
          if (
            jQuery(".rabbit-integrator-template-new").hasClass(
              "rabbit-integrator-template-edit"
            )
          ) {
            success_text = "Template updated successfully.";
          }
          html =
            "<div class='rabbit-integrator-popup-success'><div class='rabbit-integrator-popup-close-btn'></div><div class='rabbit-integrator-popup-content'><img src='" +
            rabbit_integrator_url +
            "assets/images/done.png' /><strong>" +
            success_text +
            "</strong><div class='rabbit-integrator-popup-output'><div class='rabbit-integrator-popup-output-text'>[rabbit_integrator id='" +
            json.ID +
            "']</div><img class='rabbit-integrator-popup-output-copy' src='" +
            rabbit_integrator_url +
            "assets/images/copy.png' alt='copy' title='copy shortcode' /></div></div></div>";
          var success_popup = jQuery(html).hide();
          jQuery(".rabbit-integrator-popup-wrap").append(success_popup);
          success_popup.show(400);
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

  jQuery(document).on(
    "click",
    ".rabbit-integrator-popup-output-copy",
    function (e) {
      var textToCopy = jQuery(".rabbit-integrator-popup-output-text").text();
      var $temp = jQuery("<textarea>");
      jQuery("body").append($temp);
      $temp.val(textToCopy).select();
      document.execCommand("copy");
      $temp.remove();
      html = "<div class='rabbit-integrator-popup-copied'>Copied</div>";
      jQuery(".rabbit-integrator-popup-wrap").append(html);

      setTimeout(function () {
        jQuery(".rabbit-integrator-popup-copied").hide(400);
        setTimeout(function () {
          jQuery(".rabbit-integrator-popup-copied").remove();
        }, 500);
      }, 200);
    }
  );

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

  if (
    jQuery(".rabbit-integrator-template-new").hasClass(
      "rabbit-integrator-template-edit"
    ) ||
    jQuery(".rabbit-integrator-template-new").hasClass(
      "rabbit-integrator-template-cpy"
    )
  ) {
    jQuery("#button-text").keyup();
  }
});
