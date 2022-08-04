<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              catchplugins.com
 * @since             1.0.0
 * @package           Catch_Sticky_Menu
 *
 * @wordpress-plugin
 * Plugin Name:       Catch Sticky Menu
 * Plugin URI:        catchplugins.com/plugins/catch-sticky-menu
 * Description:       Catch Sticky Menu is a lightweight, simple yet feature-rich free WordPress plugin for sticky menu that allows you to lock the menu (or any other element) on your website. Prevent your menu from disappearing when users scroll down the page!
 * Version:           1.7.1
 * Author:            Catch Plugins
 * Author URI:        catchplugins.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       catch-sticky-menu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CATCH_STICKY_MENU_VERSION', '1.7.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-catch-sticky-menu-activator.php
 */
// The URL of the directory that contains the plugin
if ( ! defined( 'CATCH_STICKY_MENU_URL' ) ) {
	define( 'CATCH_STICKY_MENU_URL', plugin_dir_url( __FILE__ ) );
}


// The absolute path of the directory that contains the file
if ( ! defined( 'CATCH_STICKY_MENU_PATH' ) ) {
	define( 'CATCH_STICKY_MENU_PATH', plugin_dir_path( __FILE__ ) );
}


// Gets the path to a plugin file or directory, relative to the plugins directory, without the leading and trailing slashes.
if ( ! defined( 'CATCH_STICKY_MENU_BASENAME' ) ) {
	define( 'CATCH_STICKY_MENU_BASENAME', plugin_basename( __FILE__ ) );
}

function activate_catch_sticky_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-sticky-menu-activator.php';
	Catch_Sticky_Menu_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-catch-sticky-menu-deactivator.php
 */
function deactivate_catch_sticky_menu() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-catch-sticky-menu-deactivator.php';
	Catch_Sticky_Menu_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_catch_sticky_menu' );
register_deactivation_hook( __FILE__, 'deactivate_catch_sticky_menu' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-catch-sticky-menu.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function sticky_menu_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

if ( ! function_exists( 'catch_sticky_menu_get_options' ) ) :
	function catch_sticky_menu_get_options() {
		$defaults = catch_sticky_menu_default_options();
		$options  = get_option( 'catch_sticky_menu_options', $defaults );
		return wp_parse_args( $options, $defaults );
	}
endif;


if ( ! function_exists( 'catch_sticky_menu_default_options' ) ) :
	/**
	 * Return array of default options
	 *
	 * @since     1.0
	 * @return    array    default options.
	 */
	function catch_sticky_menu_default_options( $option = null ) {
		$default_options = array(
			'sticky_desktop_menu_selector' => '#primary-menu',
			'sticky_mobile_menu_selector'  => '#primary-menu',
			'sticky_background_color'      => '',
			'sticky_text_color'            => '',
			'sticky_z_index'               => '199',
			'sticky_opacity'               => '1',
			'sticky_desktop_font_size'     => '',
			'sticky_mobile_font_size'      => '',
			'enable_only_on_home'          => 0,
		);

		if ( current_theme_supports( 'catch-sticky-menu' ) ) {
			$catch_sticky_menu_support = get_theme_support( 'catch-sticky-menu' );

			$default_options['sticky_desktop_menu_selector'] = isset( $catch_sticky_menu_support[0]['sticky_desktop_menu_selector'] ) ? $catch_sticky_menu_support[0]['sticky_desktop_menu_selector'] : '';
			$default_options['sticky_mobile_menu_selector']  = isset( $catch_sticky_menu_support[0]['sticky_mobile_menu_selector'] ) ? $catch_sticky_menu_support[0]['sticky_mobile_menu_selector'] : '';
			$default_options['sticky_background_color']      = isset( $catch_sticky_menu_support[0]['sticky_background_color'] ) ? $catch_sticky_menu_support[0]['sticky_background_color'] : '';
			$default_options['sticky_text_color']            = isset( $catch_sticky_menu_support[0]['sticky_text_color'] ) ? $catch_sticky_menu_support[0]['sticky_text_color'] : '';

		}

		if ( null == $option ) {
			return apply_filters( 'catch_sticky_menu_options', $default_options );
		} else {
			return $default_options[ $option ];
		}
	}
endif; // sticky_menu_default_options

function run_catch_sticky_menu() {

	$plugin = new Catch_Sticky_Menu();
	$plugin->run();

}
run_catch_sticky_menu();
/* CTP tabs removal options */
require plugin_dir_path( __FILE__ ) . '/includes/ctp-tabs-removal.php';

 $ctp_options = ctp_get_options();
if ( 1 == $ctp_options['theme_plugin_tabs'] ) {
	/* Adds Catch Themes tab in Add theme page and Themes by Catch Themes in Customizer's change theme option. */
	if ( ! class_exists( 'CatchThemesThemePlugin' ) && ! function_exists( 'add_our_plugins_tab' ) ) {
		require plugin_dir_path( __FILE__ ) . '/includes/CatchThemesThemePlugin.php';
	}
}
