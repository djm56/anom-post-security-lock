<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://anomalous.co.za
 * @since      1.0.0
 *
 * @package    Anom_Post_Security_Lock
 * @subpackage Anom_Post_Security_Lock/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Anom_Post_Security_Lock
 * @subpackage Anom_Post_Security_Lock/includes
 * @author     Donovan Maidens <donovan@anomalous.co.za>
 */
class Anom_Post_Security_Lock_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'anom-post-security-lock',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
