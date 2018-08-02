<?php
/**
 * Core plugin functionality.
 *
 * @package ThemeScaffold
 */

namespace NdFaq\Core;
use \WP_Error as WP_Error;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'i18n' ) );
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'styles' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_scripts' ) );
	add_action( 'admin_enqueue_scripts', $n( 'admin_styles' ) );

	// Editor styles. add_editor_style() doesn't work outside of a theme.
	add_filter( 'mce_css', $n( 'mce_css' ) );

	do_action( 'nd_faq_loaded' );
}

/**
 * Registers the default textdomain.
 *
 * @return void
 */
function i18n() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'nd-faq' );
	load_textdomain( 'nd-faq', WP_LANG_DIR . '/nd-faq/nd-faq-' . $locale . '.mo' );
	load_plugin_textdomain( 'nd-faq', false, plugin_basename( ND_FAQ_PATH ) . '/languages/' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'nd_faq_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {

}


/**
 * The list of knows contexts for enqueuing scripts/styles.
 *
 * @return array
 */
function get_enqueue_contexts() {
	return [ 'admin', 'frontend', 'shared' ];
}

/**
 * Generate an URL to a script, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $script Script file name (no .js extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string|WP_Error URL
 */
function script_url( $script, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in NdFaq script loader.' );
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		ND_FAQ_URL . "assets/js/${context}/{$script}.js" :
		ND_FAQ_URL . "dist/js/${context}.min.js";

}

/**
 * Generate an URL to a stylesheet, taking into account whether SCRIPT_DEBUG is enabled.
 *
 * @param string $stylesheet Stylesheet file name (no .css extension)
 * @param string $context Context for the script ('admin', 'frontend', or 'shared')
 *
 * @return string URL
 */
function style_url( $stylesheet, $context ) {

	if ( ! in_array( $context, get_enqueue_contexts(), true ) ) {
		return new WP_Error( 'invalid_enqueue_context', 'Invalid $context specified in NdFaq stylesheet loader.' );
	}

	return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
		ND_FAQ_URL . "assets/css/${context}/{$stylesheet}.css" :
		ND_FAQ_URL . "dist/css/${stylesheet}.min.css";

}

/**
 * Enqueue scripts for front-end.
 *
 * @return void
 */
function scripts() {

	wp_enqueue_script(
		'nd_faq_shared',
		script_url( 'shared', 'shared' ),
		[],
		ND_FAQ_VERSION,
		true
	);

	wp_enqueue_script(
		'nd_faq_frontend',
		script_url( 'frontend', 'frontend' ),
		[],
		ND_FAQ_VERSION,
		true
	);

}

/**
 * Enqueue scripts for admin.
 *
 * @return void
 */
function admin_scripts() {

	wp_enqueue_script(
		'nd_faq_shared',
		script_url( 'shared', 'shared' ),
		[],
		ND_FAQ_VERSION,
		true
	);

	wp_enqueue_script(
		'nd_faq_admin',
		script_url( 'admin', 'admin' ),
		[],
		ND_FAQ_VERSION,
		true
	);

}

/**
 * Enqueue styles for front-end.
 *
 * @return void
 */
function styles() {

	wp_enqueue_style(
		'nd_faq_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		ND_FAQ_VERSION
	);

	if ( is_admin() ) {
		wp_enqueue_script(
			'nd_faq_admin',
			style_url( 'admin-style', 'admin' ),
			[],
			ND_FAQ_VERSION,
			true
		);
	} else {
		wp_enqueue_script(
			'nd_faq_frontend',
			style_url( 'style', 'frontend' ),
			[],
			ND_FAQ_VERSION,
			true
		);
	}

}

/**
 * Enqueue styles for admin.
 *
 * @return void
 */
function admin_styles() {

	wp_enqueue_style(
		'nd_faq_shared',
		style_url( 'shared-style', 'shared' ),
		[],
		ND_FAQ_VERSION
	);

	wp_enqueue_script(
		'nd_faq_admin',
		style_url( 'admin-style', 'admin' ),
		[],
		ND_FAQ_VERSION,
		true
	);

}

/**
 * Enqueue editor styles. Filters the comma-delimited list of stylesheets to load in TinyMCE.
 *
 * @param string $stylesheets Comma-delimited list of stylesheets.
 * @return string
 */
function mce_css( $stylesheets ) {
	if ( ! empty( $stylesheets ) ) {
		$stylesheets .= ',';
	}

	return $stylesheets . ND_FAQ_URL . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ?
			'assets/css/frontend/editor-style.css' :
			'dist/css/editor-style.min.css' );
}
