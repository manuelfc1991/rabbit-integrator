<?php  
/* 
Plugin Name: Rabbit Integrator: PayPal integration plugin
Plugin URI: http://www.rabbitcreators.com/
Description: The Rabbit Integrator is a versatile PayPal integration plugin designed to seamlessly connect PayPal payment processing capabilities to various online platforms and e-commerce websites. With its user-friendly features, it simplifies the process of accepting payments, making it a valuable tool for businesses seeking secure and efficient online transactions.
Version: 1.0 
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Rabbit Team
Author URI: http://www.rabbitcreators.com/rabbit-team/
License: GPLv2 or later
Text Domain: Rabbit Integrator
*/

/*
Copyright 2023 Rabbit Creator. 
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

define('RI_VERSION', '1.0');
define('RI_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('RI_SITE_URL', get_bloginfo('url').'/');
define('RI_MINIMUM_WP_VERSION', '5.8' );
define('RI_PLUGIN_BASE_DIR', plugin_dir_path( __FILE__ ));

register_activation_hook( __FILE__, array( 'RabbitIn', 'rabbitIn_activation' ) );
register_uninstall_hook(__FILE__, array('RabbitIn', 'rabbitIn_uninstall'));
require_once( RI_PLUGIN_BASE_DIR . 'lib/class.rabbitIn.php' );

add_action( 'init', array( 'RabbitIn', 'rabbitIn_init' ) );
