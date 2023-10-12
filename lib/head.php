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
    $rabbit_integrator_atts = shortcode_atts( array(
        'id' => '',
    ), $atts );

    ob_start(); // Start output buffering
    include('class.paypal.php');
    if(isset($_POST['rabbit-integrator-submit-btn'])){
        $paypal->add_field('return', RI_PLUGIN_URL.'paypal-success/');
        $paypal->add_field('cancel_return', RI_PLUGIN_URL.'paypal-cancelled/');
        $paypal->add_field('notify_url', RI_PLUGIN_URL. 'rabbit-integrator-ipn-listener/');
        $paypal->add_field('item_name', 'test');
        $paypal->add_field('custom', '54');
        $paypal->add_field('amount', 22);
        $paypal->add_field('business', 'manufcorreya@gmail.com');
        $paypal->add_field('cmd', '_xclick');
        $paypal->add_field('currency_code', 'USD'); 
        $paypal->add_field('no_shipping', 1);
        $paypal->add_field('tax_rate', 0);
        echo $paypal_html = $paypal->submit_paypal_post('full'); 
    }
    ?>
    <div class="rabbit-integrator-paypal-btn-wrap">
        <form method="post" id="rabbit-integrator-submit-form">
            <button class="rabbit-integrator-paypal-btn" type="submit" name="rabbit-integrator-submit-btn"><span>Continue With</span><img src="<?php echo RI_PLUGIN_URL; ?>assets/images/paypal.png"></button>
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
