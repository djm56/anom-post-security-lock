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

	/**
	 * Register the plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function options_update() {

		register_setting(
			$this->plugin_name,
			$this->plugin_name,
			array(
				'sanitize_callback' => array( $this, 'validate' ),
			)
		);
	}

	/**
	 * Add meta box for locking posts.
	 *
	 * @since    1.0.0
	 */
	public function add_lock_post_meta_box() {
		$select_locked_post_types = $this->get_locked_post_types();
		foreach (get_post_types( array( 'public' => true ), 'names' ) as $post_type) {
			if ( ! in_array( $post_type, $select_locked_post_types )) {
				continue;
			}
			add_meta_box(
				'lock_post_meta_box',
				__( 'Lock Post', $this->plugin_name ),
				array( $this, 'render_lock_post_meta_box' ),
				$post_type,
				'side',
				'high'
			);
		}
	}

	/**
	 * Render the lock post meta box.
	 *
	 * @param WP_Post $post The post object.
	 * @since    1.0.0
	 */
	public function render_lock_post_meta_box( $post ) {
		$select_locked_post_types = $this->get_locked_post_types();
		foreach ($select_locked_post_types as $post_type) {
			$current_post_type = get_post_type( $post->ID );
			if ($current_post_type !== $post_type) {
				continue;
			}
			$value = get_post_meta( $post->ID, '_lock_post', true );
			?>
		<label><input type="radio" name="lock_post" value="true" <?php checked( $value, 'true' ); ?>> <?php _e( 'Locked', $this->plugin_name ); ?></label><br>
		<label><input type="radio" name="lock_post" value="false" <?php checked( $value, 'false' ); ?>> <?php _e( 'Unlocked', $this->plugin_name ); ?></label>
			<?php
		}
	}

	/**
	 * Save the lock post meta data.
	 *
	 * @param int $post_id The post ID.
	 * @since    1.0.0
	 */
	public function save_lock_post_meta( $post_id ) {
		if (isset( $_POST['lock_post'] )) {
			update_post_meta( $post_id, '_lock_post', sanitize_text_field( $_POST['lock_post'] ) );
		}
	}

	/**
	 * Add lockdown functionality to admin.
	 *
	 * @since    1.0.0
	 */
	public function add_lockdown_admin() {
		$select_locked_post_types = $this->get_locked_post_types();
		foreach ($select_locked_post_types as $post_type) {
			$post_type = sanitize_key( $post_type );

			add_filter( "manage_{$post_type}_posts_columns", array( $this, 'add_lockdown_column' ) );

			add_action(
				"manage_{$post_type}_posts_custom_column",
				array( $this, 'show_lockdown_column' ),
				10,
				2
			);

			add_filter(
				"manage_edit-{$post_type}_sortable_columns",
				array( $this, 'make_lockdown_sortable' )
			);

			add_filter(
				"bulk_actions-edit-{$post_type}",
				array( $this, 'add_lockdown_bulk_actions' )
			);
			add_filter(
				"handle_bulk_actions-edit-{$post_type}",
				array( $this, 'handle_lockdown_bulk_actions' ),
				10,
				3
			);
		}
	}

	/**
	 * Get the locked post types from options.
	 *
	 * @return array Array of locked post types.
	 * @since    1.0.0
	 */
	public function get_locked_post_types() {
		$options = $this->get_plugin_options();
		return isset( $options['select_locked_post_types'] ) ? $options['select_locked_post_types'] : array();
	}

	/**
	 * Adds a 'Lockdown Status' column to the posts list table for specified post types.
	 *
	 * @param array $columns Existing columns.
	 * @return array Modified columns.
	 */
	public function add_lockdown_column( $columns ) {
		$columns['lockdown_post'] = __( '🔒 Lock Status', 'airfleet' );
		return $columns;
	}

	/**
	 * Displays the lockdown status in the custom column.
	 *
	 * @param string $column  The name of the column.
	 * @param int    $post_id The ID of the current post.
	 * @return void
	 */
	public function show_lockdown_column( $column, $post_id ) {
		if ( 'lockdown_post' === $column ) {
			$locked = get_post_meta( $post_id, '_lock_post', true );
			echo $locked ? '🔒 Locked' : '✏️ Editable';
		}
	}

	/**
	 * Makes the 'Lockdown Status' column sortable.
	 *
	 * @param array $columns Sortable columns.
	 * @return array Modified sortable columns.
	 */
	function make_lockdown_sortable( $columns ) {
		$columns['lockdown_post'] = 'lockdown_post';
		return $columns;
	}

	/**
	 * Adds 'Lock Posts' and 'Unlock Posts' to bulk actions.
	 *
	 * @param array $bulk_actions Existing bulk actions.
	 * @return array Modified bulk actions.
	 */
	function add_lockdown_bulk_actions( $bulk_actions ) {
		$bulk_actions['lock_posts']   = __( 'Lock Selected Content', 'airfleet' );
		$bulk_actions['unlock_posts'] = __( 'Unlock Selected Content', 'airfleet' );

		return $bulk_actions;
	}

	/**
	 * Handles the lockdown bulk actions for locking or unlocking posts.
	 *
	 * @param string $redirect_url The URL to redirect to after processing.
	 * @param string $action       The bulk action being performed.
	 * @param array  $post_ids     An array of post IDs selected for the action.
	 * @return string The redirect URL.
	 */
	function handle_lockdown_bulk_actions( $redirect_url, $action, $post_ids ) {
		if ( 'unlock_posts' === $action && ! check_allowed_unlock_admins() ) {
			set_transient(
				'lockdown_error_' . get_current_user_id(),
				__( 'Permission denied: You do not have the required permissions to unlock content. Please contact a unlock administrator who has unlock permissions.', 'airfleet' ),
				60,
			);
			return $redirect_url;
		}

		if ( ! in_array( $action, array( 'lock_posts', 'unlock_posts' ) ) ) {
			return $redirect_url;
		}

		$value = ( 'lock_posts' === $action ) ? 1 : 0;

		foreach ( $post_ids as $post_id ) {
			if ( current_user_can( 'edit_post', $post_id ) ) {
				update_field( 'lockdown_post', $value, $post_id );
			}
		}

		$redirect_url = add_query_arg( 'bulk_lockdown_processed', count( $post_ids ), $redirect_url );

		return $redirect_url;
	}

	/**
	 * Get the plugin options.
	 *
	 * @return array Plugin options.
	 * @since    1.0.0
	 */
	private function get_plugin_options() {
		return get_option( $this->plugin_name );
	}
}
