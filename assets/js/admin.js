jQuery(document).ready(function ($) {
  if ($(".rabbit-integrator-container > .wrap").width() > 1220) {
    $(".rabbit-integrator-datatable-wrap").css(
      "max-width",
      $(".rabbit-integrator-container > .wrap").width()
    );
  }
});
function rabbit_integrator_admin_media_uploader(
  btn_id,
  value_id,
  title,
  btn_title
) {
  var custom_uploader;
  jQuery(btn_id).click(function (e) {
    e.preventDefault();
    //If the uploader object has already been created, reopen the dialog
    if (custom_uploader) {
      custom_uploader.open();
      return;
    }
    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
      title: title,
      button: {
        text: btn_title,
      },
      multiple: false,
    });
    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on("select", function () {
      attachment = custom_uploader.state().get("selection").first().toJSON();
      jQuery(value_id).val(attachment.url);
    });
    //Open the uploader dialog
    custom_uploader.open();
  });
}
