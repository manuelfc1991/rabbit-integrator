jQuery(document).ready(function ($) {
  var rabbit_integrator_url = jQuery(".rabbit-integrator-admin-logo a").attr(
    "data-assets-url"
  );
  jQuery(window).resize(function () {
    // rabbit_init();
  });
  function rabbit_init() {
    $("body").addClass("rabbit-integrator-popup-wrap-outer");
    // jQuery(".rabbit-integrator-popup-wrap").css(
    //   "width",
    //   jQuery(".rabbit-integrator-admin-wrap").innerWidth()
    // );
    // jQuery(".rabbit-integrator-popup-wrap").height(jQuery(document).height());
    // jQuery(window).resize();
  }
  rabbit_init();
});
