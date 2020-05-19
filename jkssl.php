<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpmastery.xyz
 * @since             1.0.0
 * @package           Jkssl
 *
 * @wordpress-plugin
 * Plugin Name:       JK Summit Session Loader
 * Plugin URI:        https://wpmastery.xyz
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jan Koch
 * Author URI:        https://wpmastery.xyz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jkssl
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
define( 'JKSSL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jkssl-activator.php
 */
function activate_jkssl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jkssl-activator.php';
	Jkssl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jkssl-deactivator.php
 */
function deactivate_jkssl() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jkssl-deactivator.php';
	Jkssl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jkssl' );
register_deactivation_hook( __FILE__, 'deactivate_jkssl' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-jkssl.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jkssl() {

	$plugin = new Jkssl();
	$plugin->run();

}
run_jkssl();
