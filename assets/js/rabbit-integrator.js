jQuery(document).ready(function ($) {
  var rabbit_integrator_url = jQuery(".rabbit-integrator-admin-logo a").attr(
    "data-assets-url"
  );
  jQuery(window).resize(function () {
    // rabbit_init();
  });
  function rabbit_init() {
    jQuery(document).on(
      "click",
      ".rabbit-integrator-admin-rabbit-meet-team",
      function (e) {
        jQuery(".rabbit-integrator-popup-wrap").addClass(
          "rabbit-integrator-popup-active"
        );
        var content =
          "<div><strong>Meet Our Rabbit Team</strong></div><div class='rabbit-integrator-popup-content'><div class='rabbit-integrator-popup-content-developer'><img src='" +
          rabbit_integrator_url +
          "assets/images/rabbit-face.png' alt='user'><div class='rabbit-integrator-popup-content-developer-details'>Manuel Francis Correya<span>Full stack devloper</span></div></div><div class='rabbit-integrator-popup-content-developer'><img src='" +
          rabbit_integrator_url +
          "assets/images/rabbit-face.png' alt='user'><div class='rabbit-integrator-popup-content-developer-details'>Joseph Rony Correya<span>Full stack devloper</span></div></div></div>";
        var html =
          "<div class='rabbit-integrator-popup-team'><div class='rabbit-integrator-popup-close-btn rabbit-integrator-popup-support-close-btn'></div>" +
          content +
          "<a href='http://rabbitcreators.com/contact-us/' class='rabbit-integrator-popup-content-developer-support-btn' target='_blank'>Contact Us</a></div></div>";
        var success_popup = jQuery(html).hide();
        jQuery(".rabbit-integrator-popup-wrap").append(success_popup);
        success_popup.show(400);
        jQuery("html, body").animate(
          {
            scrollTop: 0,
          },
          800
        );
      }
    );

    jQuery(document).on(
      "click",
      ".rabbit-integrator-admin-rabbit-team-support",
      function (e) {
        jQuery(".rabbit-integrator-popup-wrap").addClass(
          "rabbit-integrator-popup-active"
        );
        var content =
          "<div><strong>Our Little Rabbit Need Your Help!</strong></div><div class='rabbit-integrator-popup-content'><div class='rabbit-integrator-popup-content-support-content'><p>Hey there! 🌟 Your support means the world to us! Our little rabbit family is hopping with joy because of your generosity. To keep providing you with top-notch WordPress plugins, we kindly ask for your support. Help us grow and continue creating amazing features by making a payment today. Every contribution, big or small, helps our little rabbit thrive and brings you even more fantastic plugins in the future. Thank you for being a part of our journey! 🐇💖</p></div></div>";
        var html =
          "<div class='rabbit-integrator-popup-team'><div class='rabbit-integrator-popup-close-btn rabbit-integrator-popup-support-close-btn'></div>" +
          content +
          "<a href='http://rabbitcreators.com/buy-me-a-carrot/' class='rabbit-integrator-popup-content-developer-support-btn rabbit-integrator-popup-content-developer-buy-me-btn' target='_blank'>Buy Me a Carrot</a></div></div>";
        var success_popup = jQuery(html).hide();
        jQuery(".rabbit-integrator-popup-wrap").append(success_popup);
        success_popup.show(400);
        jQuery("html, body").animate(
          {
            scrollTop: 0,
          },
          800
        );
      }
    );

    jQuery(document).on(
      "click",
      ".rabbit-integrator-popup-support-close-btn",
      function (e) {
        e.preventDefault();
        jQuery(".rabbit-integrator-popup-team").hide(200);
        setTimeout(function () {
          jQuery(".rabbit-integrator-popup-team").remove();
          jQuery(".rabbit-integrator-popup-wrap").removeClass(
            "rabbit-integrator-popup-active"
          );
        }, 500);
      }
    );
    $("body").addClass("rabbit-integrator-popup-wrap-outer");
  }
  rabbit_init();
});
