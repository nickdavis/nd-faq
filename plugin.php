<?php
/**
 * Plugin Name: ND FAQ
 * Plugin URI:
 * Description: WordPress plugin which creates an FAQ custom post type.
 * Version:     0.1.0
 * Author:      Nick Davis
 * Author URI:  http://nickdavis.com
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

// Autoload
$autoloader = __DIR__ . '/vendor/autoload.php';
if ( is_readable( $autoloader ) ) {
	require_once $autoloader;
}

// Include files
require_once ND_FAQ_INC . 'functions/core.php';


// Activation/Deactivation
register_activation_hook( __FILE__, '\NickDavis\FAQ\Core\activate' );
register_deactivation_hook( __FILE__, '\NickDavis\FAQ\Core\deactivate' );

// Bootstrap
NickDavis\FAQ\Core\setup();
