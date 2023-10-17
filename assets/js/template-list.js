jQuery(document).ready(function (e) {
  var rabbit_integrator_url = jQuery(".rabbit-integrator-admin-logo a").attr(
    "data-assets-url"
  );
  var table = jQuery("#rabbit-integrator-admin-template-list")
    .DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: ajaxurl,
        data: { action: "rabbit_integrator_template_list" },
      },
      columnDefs: [
        {
          targets: [3],
          className: "rabbit-integrator-shortcode-wrap",
        },
      ],
      columns: [
        { data: "template_id" },
        { data: "template_title" },
        { data: "template_price" },
        {
          orderable: false,
          mRender: function (data, type, row) {
            var html =
              "<div class='rabbit-integrator-shortcode'>[rabbit_integrator id='" +
              row["template_id"] +
              "']</div>";
            html += "<a class='rabbit-integrator-button-cpy'></a>";
            return html;
          },
        },
        {
          orderable: false,
          mRender: function (data, type, row) {
            var html =
              '<a href="?page=rabbit-integrator-edit-template&id=' +
              row["template_id"] +
              '" class="rabbit-integrator-button rabbit-integrator-button-edit" >Edit</a>';
            html +=
              ' <a href="?page=rabbit-integrator-new-template&cpy_id=' +
              row["template_id"] +
              '" class="rabbit-integrator-button rabbit-integrator-button-duplicate" >Duplicate</a>';
            html +=
              ' <a href="' +
              row["template_id"] +
              '" class="rabbit-integrator-button rabbit-integrator-button-delete" >Delete</a>';
            return html;
          },
        },
      ],
      order: [[0, "desc"]],
    })
    .on("draw", function () {
      jQuery(".dataTables_length > label > select").css(
        "padding",
        "0 24px 0 8px"
      );
    });

  jQuery(document).on("click", ".rabbit-integrator-button-cpy", function (e) {
    jQuery(".rabbit-integrator-popup-wrap").addClass(
      "rabbit-integrator-popup-active"
    );
    // jQuery("html, body").animate(
    //   {
    //     scrollTop: 0,
    //   },
    //   100
    // );
    var textToCopy = jQuery(this)
      .siblings(".rabbit-integrator-shortcode")
      .text();
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
        jQuery(".rabbit-integrator-popup-wrap").removeClass(
          "rabbit-integrator-popup-active"
        );
      }, 500);
    }, 200);
  });

  jQuery(document).on(
    "click",
    ".rabbit-integrator-button-delete",
    function (e) {
      e.preventDefault();
      var id = jQuery(this).attr("href");
      jQuery(".rabbit-integrator-popup-wrap").addClass(
        "rabbit-integrator-popup-active"
      );
      html =
        "<div class='rabbit-integrator-popup-success rabbit-integrator-popup-delete'><div class='rabbit-integrator-popup-close-btn'></div><div class='rabbit-integrator-popup-content'><img src='" +
        rabbit_integrator_url +
        "assets/images/delete.png' /><strong>" +
        "</strong><div class='rabbit-integrator-popup-output'>Are you sure. Do you want to delete?</div><button class='rabbit-integrator-popup-delete-btn' data-id='" +
        id +
        "'>Confirm</button></div></div>";
      var success_popup = jQuery(html).hide();
      jQuery(".rabbit-integrator-popup-wrap").append(success_popup);
      success_popup.show(400);
    }
  );

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
    ".rabbit-integrator-popup-delete-btn",
    function (e) {
      showDelete();
      jQuery.ajax({
        url: ajaxurl,
        data: {
          id: jQuery(".rabbit-integrator-popup-delete-btn").attr("data-id"),
          action: "rabbit_integrator_delete_template",
        },
        type: "POST",
        dataType: "json",
        success: function (json) {},
        error: function (err) {},
      });
    }
  );

  function showDelete() {
    html = "<div class='rabbit-integrator-popup-copied'>Deleted</div>";
    jQuery(".rabbit-integrator-popup-wrap").append(html);
    table.ajax.reload();
    setTimeout(function () {
      jQuery(".rabbit-integrator-popup-copied").hide(400);
      jQuery(".rabbit-integrator-popup-success").hide(200);
      setTimeout(function () {
        jQuery(".rabbit-integrator-popup-copied").remove();
        jQuery(".rabbit-integrator-popup-wrap").removeClass(
          "rabbit-integrator-popup-active"
        );
      }, 500);
    }, 200);
  }
});
