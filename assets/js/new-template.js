function new_paypal_form_submit() {
  if (validate("#rabbit-integrator-template-new")) {
    $btn_element = jQuery("#rabbit-integrator-paypal-submit");
    $btn_element
      .prop("disabled", true)
      .html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...'
      );
    // $.ajax({
    //   url: base_url + "api/job-feed-source-add-data/",
    //   data: $("#feed_post_form").serialize(),
    //   type: "POST",
    //   dataType: "json",
    //   success: function (json) {
    //     $btn_element.prop("disabled", false).html("Submit");
    //     if (json.msg == "Y") {
    //       alert("Experience added Successfully");
    //       $("#feed_post_form").trigger("reset");
    //     } else if (json.status == "N") {
    //       var element = $('#feed_post_form [name="rf_title"]');
    //       element.focus();
    //       element.addClass("form-validation-error");
    //     }
    //   },
    //   error: function (err) {},
    // });
  }
}

jQuery(document).ready(function (e) {
  jQuery("#rabbit-integrator-paypal-submit").on("click", function (e) {
    e.preventDefault();
    new_paypal_form_submit();
  });

  jQuery("#price,#button-text,#button-text-size").on("keyup", function (e) {
    jQuery(".rabbit-integrator-paypal-btn").removeClass(
      "rabbit-integrator-paypal-btn-default"
    );

    var price = jQuery("#price").val();
    var button_txt = jQuery("#button-text").val();
    var button_txt_size = jQuery("#button-text-size").val();
    var button_width = jQuery("#button-width").val();
    var button_height = jQuery("#button-height").val();
    var button_color = jQuery("#button-text-color").val();
    console.log(button_txt);

    if (
      price !== "" ||
      button_txt !== "" ||
      button_txt_size !== "" ||
      button_width !== "" ||
      button_height !== "" ||
      button_color !== ""
    ) {
      jQuery(".rabbit-integrator-paypal-btn").text(button_txt);
      jQuery(".rabbit-integrator-paypal-btn").css("font-size", button_txt_size);
    }
  });
});
