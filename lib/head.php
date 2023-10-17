<?php
function rabbit_integrator_enqueue_front_script_style(){
    wp_enqueue_script('jquery');
    wp_register_style( 'rabbit_integrator_front_style', RI_PLUGIN_URL. 'assets/css/rabbit-head.css');
    wp_register_script( 'rabbit_integrator_front_script', RI_PLUGIN_URL. 'assets/js/rabbit-head.js');
    wp_enqueue_script('rabbit_integrator_front_script');
    wp_enqueue_style( 'rabbit_integrator_front_style' );
}
add_action('wp_enqueue_scripts', 'rabbit_integrator_enqueue_front_script_style');
function rabbit_integrator_shortcode( $atts ) {
    global $wpdb;
    $rabbit_integrator_atts = shortcode_atts( array(
        'id' => '',
    ), $atts );

    $id = $rabbit_integrator_atts['id'];

    $title = '';
    $price = '';
    $button_text = 'Continue With';
    $button_text_size = '';
    $button_width = '';
    $button_height = '';
    $button_text_color = '';
    $button_color = '';
    $paypal_flag = false;
    $templateResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_template WHERE template_id = '$id'", ARRAY_A);
    if($templateResults)
    {
        $paypal_flag = true;
        $title = $templateResults[0]['template_title'];
        $price = empty($templateResults[0]['template_price']) ? '' : $templateResults[0]['template_price'];    
        $button_text = $templateResults[0]['template_btn_txt']; 
        $button_text_size = $templateResults[0]['template_btn_txt_size'];
        $button_width = $templateResults[0]['template_btn_width'];
        $button_height = $templateResults[0]['template_btn_height'];
        $button_text_color = $templateResults[0]['template_btn_txt_color'];
        $button_color = $templateResults[0]['template_btn_bg_color'];
    }

    ob_start(); // Start output buffering
    include('class.paypal.php');
    $success_url = RI_SITE_URL.'rabbit-integrator-paypal-success/';
    $return_url = RI_SITE_URL.'rabbit-integrator-paypal-failed/';
    $notify_url = RI_SITE_URL.'rabbit-integrator-ipn/';
    $paypal_id  = ''; 
    $server = '';
    $currency = '';
    $tax = '';
    $settingsResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_settings ORDER BY settings_id DESC", ARRAY_A);
    if($settingsResults)
    {
        $paypal_id  = $settingsResults[0]['paypal_id']; 
        $server = $settingsResults[0]['server']; 
        if(!empty($settingsResults[0]['success_url']))
            $success_url = $settingsResults[0]['success_url']; 
        if(!empty($settingsResults[0]['return_url']))
            $return_url = $settingsResults[0]['return_url']; 
        if(!empty($settingsResults[0]['notify_url']))
            $notify_url = $settingsResults[0]['notify_url']; 
        $currency = $settingsResults[0]['currency']; 
        $tax = $settingsResults[0]['tax']; 
    }
    else 
    {
        $paypal_flag = false;
    }
    if(isset($_POST['rabbit-integrator-submit-btn'])){
        $paypal->add_field('return', $success_url);
        $paypal->add_field('cancel_return', $return_url);
        $paypal->add_field('notify_url', $notify_url);
        $paypal->add_field('item_name', $title);
        $paypal->add_field('custom', $id);
        $paypal->add_field('amount', $price);
        $paypal->add_field('business', $paypal_id);
        $paypal->add_field('cmd', '_xclick');
        $paypal->add_field('currency_code', $currency); 
        $paypal->add_field('no_shipping', 1);
        $paypal->add_field('tax_rate', $tax);
        echo $paypal_html = $paypal->submit_paypal_post('full'); 
    }
    ?>
    <style>
        .rabbit-integrator-paypal-btn {
        <?php
            echo empty($button_text_size) ? '' : 'font-size:'.$button_text_size.'px !important;';
            echo empty($button_width) ? '' : 'width:'.$button_width.'px !important;';
            echo empty($button_height) ? '' : 'height:'.$button_height.'px !important;';
            echo empty($button_text_color) ? '' : 'color:'.$button_text_color.' !important;';
            echo empty($button_color) ? '' : 'background-color:'.$button_color.' !important;';
        ?>
        }
    </style>
    <div class="rabbit-integrator-paypal-btn-wrap">
        <?php if($paypal_flag) { ?>
        <form method="post" id="rabbit-integrator-submit-form">
            <button class="rabbit-integrator-paypal-btn" type="submit" name="rabbit-integrator-submit-btn"><span><?php echo $button_text; ?></span><img src="<?php echo RI_PLUGIN_URL; ?>assets/images/paypal.png"></button>
        </form>
        <?php
            if($rabbit_integrator_atts['id'] == '') {
        ?>
        <div class="rabbit-integrator-paypal-btn-error">
            The Rabbit Integrator shortcode is experiencing an issue; it requires an additional parameter.
        </div>
        <?php 
            }
        } else {
        ?>
        <div class="rabbit-integrator-paypal-btn-error">
            The Rabbit Integrator shortcode is encountering an error and needs an extra parameter or proper configuration within your plugin to function correctly.
        </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
    
}
add_shortcode( 'rabbit_integrator', 'rabbit_integrator_shortcode' );
function rabbit_integrator_ipn_shortcode( $atts ) {
    global $wpdb;
    $rabbit_integrator_atts = shortcode_atts( array(
        'id' => '',
    ), $atts );

    $id = $rabbit_integrator_atts['id'];
    $purchase_id = 0;
    $item_number = '';
    $first_name = '';
    $last_name = '';
    $last_name = '';
    $payment_type = '';
    $txn_id = '';
    $payer_email = '';
    $receiver_email = '';
    $protection_eligibility = '';
    $verify_sign = '';
    $txn_type = '';
    $payment_date = '';
    $payment_status = '';
    $business = '';
    $charset = '';
    $ipn_track_id = '';
    $notify_version = '';
    $mc_currency = '';
    $mc_fee = '';
    $mc_gross = '';
    $payer_status = '';
    $quantity = '';
    $payment_fee = '';
    $shipping_discount = '';
    $receiver_id = '';
    $insurance_amount = '';
    $item_name = '';
    $discount = '';
    $residence_country = '';
    $test_ipn = '';
    $shipping_method = '';
    $transaction_subject = '';
    $payment_gross = '';
    $payer_id = '';

    include('class.paypal.php');



    if($paypal->validate_ipn())
    {
        $purchase_id                = $paypal->ipn_data['custom'];
        $item_number                = $paypal->ipn_data['item_number'];
        $first_name                 = $paypal->ipn_data['first_name'];
        $last_name                  = $paypal->ipn_data['last_name'];
        $payment_type               = $paypal->ipn_data['payment_type'];
        $txn_id                     = $paypal->ipn_data['txn_id'];
        $payer_email                = $paypal->ipn_data['payer_email'];
        $receiver_email             = $paypal->ipn_data['receiver_email'];
        $protection_eligibility     = $paypal->ipn_data['protection_eligibility'];
        $verify_sign                = $paypal->ipn_data['verify_sign'];
        $txn_type                   = $paypal->ipn_data['txn_type'];
        $payment_date               = $paypal->ipn_data['payment_date'];
        $payment_status             = $paypal->ipn_data['payment_status'];
        $business                   = $paypal->ipn_data['business'];
        $charset                    = $paypal->ipn_data['charset'];
        $ipn_track_id               = $paypal->ipn_data['ipn_track_id'];
        $notify_version             = $paypal->ipn_data['notify_version'];
        $mc_currency                = $paypal->ipn_data['mc_currency'];
        $mc_fee                     = $paypal->ipn_data['mc_fee'];
        $mc_gross                   = $paypal->ipn_data['mc_gross'];
        $payer_status               = $paypal->ipn_data['payer_status'];
        $quantity                   = $paypal->ipn_data['quantity'];
        $payment_fee                = $paypal->ipn_data['payment_fee'];
        $shipping_discount          = $paypal->ipn_data['shipping_discount'];
        $receiver_id                = $paypal->ipn_data['receiver_id'];
        $insurance_amount           = $paypal->ipn_data['insurance_amount'];
        $item_name                  = $paypal->ipn_data['item_name'];
        $discount                   = $paypal->ipn_data['discount'];
        $residence_country          = $paypal->ipn_data['residence_country'];
        $test_ipn                   = $paypal->ipn_data['test_ipn'];
        $shipping_method            = $paypal->ipn_data['shipping_method'];
        $transaction_subject        = $paypal->ipn_data['transaction_subject'];
        $payment_gross              = $paypal->ipn_data['payment_gross'];
        $payer_id                   = $paypal->ipn_data['payer_id'];

        $data = array();
        $data_format = array();

        $data['item_number'] = $wpdb->prepare('%s', $item_number);
        $data_format[] = '%s';

        $data['payer_first_name'] = $wpdb->prepare('%s', $first_name);
        $data_format[] = '%s';

        $data['payer_last_name'] = $wpdb->prepare('%s', $last_name);
        $data_format[] = '%s';

        $data['payment_type'] = $wpdb->prepare('%s', $payment_type);
        $data_format[] = '%s';

        $data['txn_id'] = $wpdb->prepare('%s', $txn_id);
        $data_format[] = '%s';

        $data['payer_email'] = $wpdb->prepare('%s', $payer_email);
        $data_format[] = '%s';

        $data['receiver_email'] = $wpdb->prepare('%s', $receiver_email);
        $data_format[] = '%s';

        $data['protection_eligibility'] = $wpdb->prepare('%s', $protection_eligibility);
        $data_format[] = '%s';

        $data['verify_sign'] = $wpdb->prepare('%s', $verify_sign);
        $data_format[] = '%s';

        $data['txn_type'] = $wpdb->prepare('%s', $txn_type);
        $data_format[] = '%s';

        $data['payment_date'] = $wpdb->prepare('%s', date('Y-m-d H:i:s', strtotime($payment_date)));
        $data_format[] = '%s';

        $data['payer_payment_status'] = $wpdb->prepare('%s', $payment_status);
        $data_format[] = '%s';

        $data['business'] = $wpdb->prepare('%s', $business);
        $data_format[] = '%s';

        $data['charset'] = $wpdb->prepare('%s', $charset);
        $data_format[] = '%s';

        $data['ipn_track_id'] = $wpdb->prepare('%s', $ipn_track_id);
        $data_format[] = '%s';

        $data['notify_version'] = $wpdb->prepare('%s', $notify_version);
        $data_format[] = '%s';

        $data['mc_currency'] = $wpdb->prepare('%s', $mc_currency);
        $data_format[] = '%s';

        $data['mc_fee'] = $wpdb->prepare('%s', $mc_fee);
        $data_format[] = '%s';

        $data['mc_gross'] = $wpdb->prepare('%s', $mc_gross);
        $data_format[] = '%s';

        $data['payer_status'] = $wpdb->prepare('%s', $payer_status);
        $data_format[] = '%s';

        $data['quantity'] = $wpdb->prepare('%s', $quantity);
        $data_format[] = '%s';

        $data['payment_fee'] = $wpdb->prepare('%s', $payment_fee);
        $data_format[] = '%s';

        $data['shipping_discount'] = $wpdb->prepare('%s', $shipping_discount);
        $data_format[] = '%s';

        $data['receiver_id'] = $wpdb->prepare('%s', $receiver_id);
        $data_format[] = '%s';

        $data['insurance_amount'] = $wpdb->prepare('%s', $insurance_amount);
        $data_format[] = '%s';

        $data['item_name'] = $wpdb->prepare('%s', $item_name);
        $data_format[] = '%s';

        $data['discount'] = $wpdb->prepare('%s', $discount);
        $data_format[] = '%s';

        $data['residence_country'] = $wpdb->prepare('%s', $residence_country);
        $data_format[] = '%s';

        $data['test_ipn'] = $wpdb->prepare('%s', $test_ipn);
        $data_format[] = '%s';

        $data['shipping_method'] = $wpdb->prepare('%s', $shipping_method);
        $data_format[] = '%s';

        $data['transaction_subject'] = $wpdb->prepare('%s', $transaction_subject);
        $data_format[] = '%s';

        $data['payment_gross'] = $wpdb->prepare('%s', $payment_gross);
        $data_format[] = '%s';

        $data['payer_id'] = $wpdb->prepare('%s', $payer_id);
        $data_format[] = '%s';

        $table_name = $wpdb->prefix . 'rabbit_integrator_transaction_history';
        $wpdb->insert($table_name, $data, $data_format);

        $content = $query;
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText-1.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
    }

    $content = date('d-m-Y H:i:s');
    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
    fwrite($fp,$content);
    fclose($fp);
}
add_shortcode( 'rabbit_integrator_ipn', 'rabbit_integrator_ipn_shortcode' );