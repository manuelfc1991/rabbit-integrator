<?php
$action = '';
$html = array('msg' => 'N', 'html' => '');
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}
if($action == 'rabbit_integrator_new_template')
{
    $template_data = $_POST['template_data'];
    parse_str($template_data, $template_data_array);
    $title  = $template_data_array['title'];
    $price   = $template_data_array['price'];
    $btn_txt = $template_data_array['button_text'];
    $btn_txt_size = $template_data_array['button_text_size'];
    $btn_width = $template_data_array['button_width'];
    $btn_height = $template_data_array['button_height'];
    $btn_txt_color = $template_data_array['button_text_color'];
    $btn_color = $template_data_array['button_color'];
    $wpdb->insert($wpdb->prefix."rabbit_integrator_template", array( 'template_title' => $title, 'template_price' => $price, 'template_btn_txt' => $btn_txt, 'template_btn_txt_size' => $btn_txt_size, 'template_btn_width' => $btn_width, 'template_btn_height' => $btn_height, 'template_btn_txt_color' => $btn_txt_color, 'template_btn_bg_color' => $btn_color, 'template_status' => 'Y'), array('%s','%s','%s','%s','%s','%s','%s','%s','%s') );
    $html['msg'] = 'Y';
}
echo json_encode($html);