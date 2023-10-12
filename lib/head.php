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
    $templateResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_template WHERE template_id = '$id'", ARRAY_A);
    if($templateResults)
    {
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
            echo empty($button_text_size) ? '' : 'font-size:'.$button_text_size.'px;';
            echo empty($button_width) ? '' : 'width:'.$button_width.'px;';
            echo empty($button_height) ? '' : 'height:'.$button_height.'px;';
            echo empty($button_text_color) ? '' : 'color:'.$button_text_color.';';
            echo empty($button_color) ? '' : 'background-color:'.$button_color.';';
        ?>
        }
    </style>
    <div class="rabbit-integrator-paypal-btn-wrap">
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
        ?>
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

        $query = "UPDATE `icoes_co_purchase_certificate` SET ";
        $query .= " `item_number` = '".$item_number."',";
        $query .= " `payer_first_name` = '".$first_name."',";
        $query .= " `payer_last_name` = '". $last_name."',";
        $query .= " `payment_type` = '". $payment_type."',";
        $query .= " `txn_id` = '". $txn_id."',";
        $query .= " `payer_email` = '". $payer_email."',";
        $query .= " `receiver_email` = '". $receiver_email."',";
        $query .= " `protection_eligibility` = '". $protection_eligibility."',";
        $query .= " `verify_sign` = '". $verify_sign."',";
        $query .= " `txn_type` = '". $txn_type."',";
        $query .= " `payment_date` = '". $payment_date."',";
        $query .= " `payer_payment_status` = '". $payment_status."',"; 
        $query .= " `business` = '". $business."',";
        $query .= " `charset` = '". $charset."',";
        $query .= " `ipn_track_id` = '". $ipn_track_id."',";
        $query .= " `notify_version` = '". $notify_version."',";
        $query .= " `mc_currency` = '". $mc_currency."',";
        $query .= " `mc_fee` = '". $mc_fee."',";
        $query .= " `mc_gross` = '". $mc_gross."',";
        $query .= " `payer_status` = '". $payer_status."',";
        $query .= " `quantity` = '". $quantity."',";
        $query .= " `payment_fee` = '". $payment_fee."',";
        $query .= " `shipping_discount` = '". $shipping_discount."',";
        $query .= " `receiver_id` = '". $receiver_id."',";
        $query .= " `insurance_amount` = '". $insurance_amount."',";
        $query .= " `item_name` = '". $item_name."',";
        $query .= " `discount` = '". $discount."',";
        $query .= " `residence_country` = '". $residence_country."',";
        $query .= " `test_ipn` = '". $test_ipn."',";
        $query .= " `shipping_method` = '". $shipping_method."',";
        $query .= " `transaction_subject` = '". $transaction_subject."',";
        $query .= " `payment_gross` = '". $payment_gross."',";
        $query .= " `payer_id` = '". $payer_id."' ";
        
        $query .= " WHERE `purchase_id` = " . $purchase_id;

        $content = $query;
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
    }

    // ob_start(); // Start output buffering
    echo "ipn";
    $content = 'ipn';
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
    // return ob_get_clean(); // Return the buffered content
}
add_shortcode( 'rabbit_integrator_ipn', 'rabbit_integrator_ipn_shortcode' );