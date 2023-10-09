<?php
function rabbit_integrator_shortcode( $atts ) {
    $rabbit_integrator_atts = shortcode_atts( array(
        'id' => '',
    ), $atts );
    if(count($rabbit_integrator_atts) == 0)
    {
        echo "Shortcode needs one parameter";
    }
    var_dump($rabbit_integrator_atts);
    echo "hello";
	// $id = $icoes_certificate_digital_atts['id'];
	// global $wpdb;
	// require dirname( __FILE__ ) . '/digital-ipn-certificate.php';
}
add_shortcode( 'rabbit_integrator', 'rabbit_integrator_shortcode' );
