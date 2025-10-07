<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://anomalous.co.za
 * @since      1.0.0
 *
 * @package    Anom_Post_Security_Lock
 * @subpackage Anom_Post_Security_Lock/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Anom_Post_Security_Lock
 * @subpackage Anom_Post_Security_Lock/admin
 * @author     Donovan Maidens <donovan@anomalous.co.za>
 */
class Anom_Post_Security_Lock_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anom_Post_Security_Lock_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anom_Post_Security_Lock_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/anom-post-security-lock-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2', plugins_url( '../node_modules/select2/dist/css/select2.min.css', __FILE__ ), array(), '4.1.0', 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Anom_Post_Security_Lock_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Anom_Post_Security_Lock_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/anom-post-security-lock-admin.js', array( 'jquery', 'select2' ), $this->version, false );
		wp_enqueue_script( 'select2', plugins_url( '../node_modules/select2/dist/js/select2.min.js', __FILE__ ), array( 'jquery' ), '4.1.0', false );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_submenu_page( 'options-general.php', 'Post Security Lock Settings', 'Post Security Lock', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ) );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		$settings_link = array( '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>' );
		return array_merge( $settings_link, $links );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

		include_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	/**
	 * Validate fields from admin area plugin settings form ('exopite-lazy-load-xt-admin-display.php')
	 *
	 * @param  mixed $input as field form settings form
	 * @return mixed as validated fields
	 */
	public function validate( $input ) {

		$options = get_option( $this->plugin_name );

		$options['example_checkbox'] = ( isset( $input['example_checkbox'] ) && ! empty( $input['example_checkbox'] ) ) ? 1 : 0;
		$options['example_text']     = ( isset( $input['example_text'] ) && ! empty( $input['example_text'] ) ) ? esc_attr( $input['example_text'] ) : 'default';
		$options['example_textarea'] = ( isset( $input['example_textarea'] ) && ! empty( $input['example_textarea'] ) ) ? sanitize_textarea_field( $input['example_textarea'] ) : 'default';

		// Handle multi-select array
		if ( isset( $input['select_locked_post_types'] ) && is_array( $input['select_locked_post_types'] ) ) {
			$options['select_locked_post_types'] = array_map( 'esc_attr', $input['select_locked_post_types'] );
		} else {
			$options['select_locked_post_types'] = array();
		}

		return $options;
	}

	public function options_update() {

		register_setting(
			$this->plugin_name,
			$this->plugin_name,
			array(
				'sanitize_callback' => array( $this, 'validate' ),
			)
		);
	}
}
