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
});
