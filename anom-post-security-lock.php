<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://anomalous.co.za
 * @since             1.0.0
 * @package           Anom_Post_Security_Lock
 *
 * @wordpress-plugin
 * Plugin Name:       Post Security Lock
 * Plugin URI:        https://anomalous.co.za
 * Description:       Have the ability to lock and unlock post or any other cpt, so it cant be updated.
 * Version:           1.0.0
 * Author:            Donovan Maidens
 * Author URI:        https://anomalous.co.za/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       anom-post-security-lock
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
define( 'ANOM_POST_SECURITY_LOCK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-anom-post-security-lock-activator.php
 */
function activate_anom_post_security_lock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anom-post-security-lock-activator.php';
	Anom_Post_Security_Lock_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-anom-post-security-lock-deactivator.php
 */
function deactivate_anom_post_security_lock() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anom-post-security-lock-deactivator.php';
	Anom_Post_Security_Lock_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_anom_post_security_lock' );
register_deactivation_hook( __FILE__, 'deactivate_anom_post_security_lock' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anom-post-security-lock.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_anom_post_security_lock() {

	$plugin = new Anom_Post_Security_Lock();
	$plugin->run();

}
run_anom_post_security_lock();
