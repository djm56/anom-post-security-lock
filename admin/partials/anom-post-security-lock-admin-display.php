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
if ( ! defined( 'WPINC' ) ) die;
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>Plugin Name <?php esc_attr_e('Options', 'plugin_name' ); ?></h2>

    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
    <?php
        //Grab all options
        $options = get_option( $this->plugin_name );

        $example_select = ( isset( $options['example_select'] ) && ! empty( $options['example_select'] ) ) ? $options['example_select'] : array();
        if ( ! is_array( $example_select ) ) {
            $example_select = array( $example_select );
        }
        $saved = $example_select; // Create $saved variable for compatibility with your option syntax
        $example_text = ( isset( $options['example_text'] ) && ! empty( $options['example_text'] ) ) ? esc_attr( $options['example_text'] ) : 'default';
        $example_textarea = ( isset( $options['example_textarea'] ) && ! empty( $options['example_textarea'] ) ) ? sanitize_textarea_field( $options['example_textarea'] ) : 'default';
        $example_checkbox = ( isset( $options['example_checkbox'] ) && ! empty( $options['example_checkbox'] ) ) ? 1 : 0;

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);

    ?>

    <table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Example Multi-Select', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Example Multi-Select', $this->plugin_name ); ?></span>
						</legend>
						<p class="description"><?php esc_attr_e( 'Select one or more options from the list below.', $this->plugin_name ); ?></p>
						<select name="<?php echo $this->plugin_name; ?>[example_select][]" id="<?php echo $this->plugin_name; ?>-example_select" multiple="multiple">
							<option value="location" <?php echo (in_array('location', $saved) ? 'selected' : ''); ?>>Location</option>
							<option value="role" <?php echo (in_array('role', $saved) ? 'selected' : ''); ?>>Role</option>
							<option value="functional" <?php echo (in_array('functional', $saved) ? 'selected' : ''); ?>>Functional Area</option>
							<option value="industry" <?php echo (in_array('industry', $saved) ? 'selected' : ''); ?>>Industry</option>
						</select>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_attr_e( 'Example Text.', $this->plugin_name ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text">
							<span><?php esc_attr_e( 'Example Text', $this->plugin_name ); ?></span>
						</legend>
						<input type="text" class="example_text" id="<?php echo $this->plugin_name; ?>-example_text" name="<?php echo $this->plugin_name; ?>[example_text]" value="<?php if( ! empty( $example_text ) ) echo $example_text; else echo 'default'; ?>"/>
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
						<textarea class="example_textarea" id="<?php echo $this->plugin_name; ?>-example_textarea" name="<?php echo $this->plugin_name; ?>[example_textarea]" rows="4" cols="50"><?php if( ! empty( $example_textarea ) ) echo $example_textarea; else echo 'default'; ?></textarea>
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
							<span><?php esc_attr_e('Example Checkbox', $this->plugin_name ); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
    <?php submit_button( __( 'Save all changes', 'plugin_name' ), 'primary','submit', TRUE ); ?>
    </form>
</div>
