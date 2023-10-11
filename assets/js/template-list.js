jQuery(document).ready(function (e) {
  jQuery("#rabbit-integrator-admin-template-list")
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
              ' <a href="?page=rabbit-integrator-new-template&cpy_id=' +
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
});
