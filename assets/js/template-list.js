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
              '<a href="?page=programmatic-seo-template-edit&id=' +
              row["template_id"] +
              '" class="rabbit-integrator-button rabbit-integrator-button-edit" >Edit</a>';
            html +=
              ' <a href="?page=programmatic-seo-template-new&cpy_id=' +
              row["template_id"] +
              '" class="rabbit-integrator-button rabbit-integrator-button-duplicate" >Duplicate</a>';
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
});
