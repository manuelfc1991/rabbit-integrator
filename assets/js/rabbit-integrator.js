jQuery(document).ready(function ($) {
  jQuery(window).resize(function () {
    rabbit_init();
  });
  function rabbit_init() {
    $("body").addClass("rabbit-integrator-popup-wrap-outer");
    jQuery(".rabbit-integrator-popup-wrap").width(jQuery(document).width());
    jQuery(".rabbit-integrator-popup-wrap").height(jQuery(document).height());
    var adminMenuWidth = jQuery("#adminmenuwrap").width() + 20;
    jQuery(".rabbit-integrator-popup-wrap").css(
      "left",
      "-" + adminMenuWidth + "px"
    );
  }
  rabbit_init();
  html =
    "<div class='rabbit-integrator-popup-success'><div class='rabbit-integrator-popup-close-btn'></div><img src='images/prize.png' /><strong>Template created successfully.</strong></div>";
  jQuery(".rabbit-integrator-popup-wrap").append(html);
});
