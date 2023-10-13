jQuery(document).ready(function (e) {
  jQuery("#rabbit-integrator-admin-template-list")
    .DataTable({
      processing: true,
      serverSide: true,
      serverMethod: "post",
      ajax: {
        url: ajaxurl,
        data: { action: "rabbit_integrator_transaction_list" },
      },
      columns: [
        { data: "transaction_history_id" },
        { data: "payer_first_name" },
        { data: "payer_last_name" },
        { data: "payer_email" },
        { data: "payment_type" },
        { data: "mc_currency" },
        { data: "payment_gross" },
        { data: "payment_date" },
        { data: "payer_payment_status" },
        { data: "txn_id" },
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
