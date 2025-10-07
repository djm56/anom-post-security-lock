<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://anomalous.co.za
 * @since      1.0.0
 *
 * @package    Anom_Post_Security_Lock
 * @subpackage Anom_Post_Security_Lock/admin/partials
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h2>Plugin Name <?php esc_attr_e( 'Options', 'plugin_name' ); ?></h2>

	<form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
	<?php
		// Grab all options
		$options = get_option( $this->plugin_name );

		$select_locked_post_types = ( isset( $options['select_locked_post_types'] ) && ! empty( $options['select_locked_post_types'] ) ) ? $options['select_locked_post_types'] : array();
	if ( ! is_array( $select_locked_post_types ) ) {
		$select_locked_post_types = array( $select_locked_post_types );
	}
		$saved            = $select_locked_post_types; // Create $saved variable for compatibility with your option syntax
		$example_text     = ( isset( $options['example_text'] ) && ! empty( $options['example_text'] ) ) ? esc_attr( $options['example_text'] ) : 'default';
		$example_textarea = ( isset( $options['example_textarea'] ) && ! empty( $options['example_textarea'] ) ) ? sanitize_textarea_field( $options['example_textarea'] ) : 'default';
		$example_checkbox = ( isset( $options['example_checkbox'] ) && ! empty( $options['example_checkbox'] ) ) ? 1 : 0;

		settings_fields( $this->plugin_name );
		do_settings_sections( $this->plugin_name );

	?>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Locked Post Types', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Select Locked Post Types', $this->plugin_name ); ?></span>
						</legend>
						<p class="description"><?php esc_attr_e( 'Select the post types that should have security lock features enabled.', $this->plugin_name ); ?></p>
						<select name="<?php echo $this->plugin_name; ?>[select_locked_post_types][]" id="<?php echo $this->plugin_name; ?>-select_locked_post_types" multiple="multiple">
							<?php

							$post_types = get_post_types(
								array(
									'public'   => true,
									'show_ui'  => true,
									'_builtin' => false,
								),
								'objects'
							);

							$builtin_post_types = get_post_types(
								array(
									'public'   => true,
									'show_ui'  => true,
									'_builtin' => true,
								),
								'objects'
							);

							$all_post_types = array_merge( $builtin_post_types, $post_types );

							uasort(
								$all_post_types,
								function ( $a, $b ) {
									return strcmp( $a->label, $b->label );
								}
							);

							foreach ( $all_post_types as $post_type ) {
								if ( $post_type->name === 'attachment' ) {
									continue;
								}

								$selected = in_array( $post_type->name, $saved ) ? 'selected' : '';
								printf(
									'<option value="%s" %s>%s (%s)</option>',
									esc_attr( $post_type->name ),
									$selected,
									esc_html( $post_type->label ),
									esc_html( $post_type->name )
								);
							}
							?>
						</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Unlock Admins.', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Unlock Admins', $this->plugin_name ); ?></span>
						</legend>
						<?php
						$post_security_usernames = unserialize(POST_SECURITY_USERNAMES);
						?>
						<input
							type="text"
							class="example_text"
							id="<?php echo esc_attr($this->plugin_name); ?>-readonly_usernames"
							value="<?php echo esc_attr(implode(',', $post_security_usernames)); ?>"
							readonly
							disabled
						/>
						<p class="description">
							Usernames are set in <code>wp-config.php</code> and cannot be edited here.
						</p>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Example Textarea.', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Example Textarea', $this->plugin_name ); ?></span>
						</legend>
						<textarea class="example_textarea" id="<?php echo $this->plugin_name; ?>-example_textarea" name="<?php echo $this->plugin_name; ?>[example_textarea]" rows="4" cols="50">
						<?php
						if ( ! empty( $example_textarea ) ) {
							echo $example_textarea;
						} else {
							echo 'default';
						}
						?>
						</textarea>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Example Checkbox.', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Example Checkbox', $this->plugin_name ); ?></span>
						</legend>
						<label for="<?php echo $this->plugin_name; ?>-example_checkbox">
							<input type="checkbox" id="<?php echo $this->plugin_name; ?>-example_checkbox" name="<?php echo $this->plugin_name; ?>[example_checkbox]" value="1" <?php checked( $example_checkbox, 1 ); ?> />
							<span><?php esc_attr_e( 'Example Checkbox', $this->plugin_name ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<?php submit_button( __( 'Save all changes', 'plugin_name' ), 'primary', 'submit', true ); ?>
	</form>
</div>
