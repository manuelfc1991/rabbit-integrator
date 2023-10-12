<?php
$action = '';
$html = array('msg' => 'N', 'html' => '', 'ID' => 0);
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}
if($action == 'rabbit_integrator_settings')
{
    $settings_data = $_POST['settings_data'];
    parse_str($settings_data, $settings_data_array);
    $paypal_id  = empty($settings_data_array['paypal_id']) ? '' : $settings_data_array['paypal_id']; 
    $server = empty($settings_data_array['server']) ? '' : $settings_data_array['server'];
    $success_url = empty($settings_data_array['success_url']) ? '' : $settings_data_array['success_url'];
    $return_url = empty($settings_data_array['return_url']) ? '' : $settings_data_array['return_url'];
    $notify_url = empty($settings_data_array['notify_url']) ? '' : $settings_data_array['notify_url'];
    $currency = empty($settings_data_array['currency']) ? '' : $settings_data_array['currency'];
    $tax = empty($settings_data_array['tax']) ? '' : $settings_data_array['tax'];

    $data = array(
        'paypal_id' => $paypal_id,
        'server' => $server,
        'success_url' => $success_url,
        'return_url' => $return_url,
        'notify_url' => $notify_url,
        'currency' => $currency,
        'tax' => $tax,
        'settings_status' => 'Y'
    );

    $data_format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
    $table_name = $wpdb->prefix . 'rabbit_integrator_settings';
    $wpdb->insert($table_name, $data, $data_format);
    $inserted_id = $wpdb->insert_id;
    $html['msg'] = 'Y';
    $html['ID'] = $inserted_id;
    echo json_encode($html);
}