<?php
/**
 * Plugin Name: NdFaq
 * Plugin URI:
 * Description:
 * Version:     0.1.0
 * Author:      10up
 * Author URI:  https://10up.com
 * Text Domain: nd-faq
 * Domain Path: /languages
 *
 * @package PluginScaffold
 */

// Useful global constants
define( 'ND_FAQ_VERSION', '0.1.0' );
define( 'ND_FAQ_URL', plugin_dir_url( __FILE__ ) );
define( 'ND_FAQ_PATH', dirname( __FILE__ ) . '/' );
define( 'ND_FAQ_INC', ND_FAQ_PATH . 'includes/' );

// Include files
require_once ND_FAQ_INC . 'functions/core.php';


// Activation/Deactivation
register_activation_hook( __FILE__, '\NdFaq\Core\activate' );
register_deactivation_hook( __FILE__, '\NdFaq\Core\deactivate' );

// Bootstrap
NdFaq\Core\setup();
