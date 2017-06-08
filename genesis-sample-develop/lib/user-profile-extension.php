<?php
/**
 * Genesis Sample.
 *
 * This file adds additional address fields to the user profile.
 *
 * @package Genesis Sample
 * @author  Christoph Herr
 * @license GPL-2.0+
 * @link	https://www.christophherr.com
 */

add_action( 'show_user_profile', 'ch_add_address_fields_to_user_profiles' );
add_action( 'edit_user_profile', 'ch_add_address_fields_to_user_profiles' );

/**
 * Adds address fields to the user profile
 *
 * @param WP_User $user WP User object.
 * @return void
 */
function ch_add_address_fields_to_user_profiles( $user ) {
	?>
	<h3 id="address-information"><?php esc_html_e( 'Address Information', 'genesis-sample' ); ?></h3>
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="street"><?php esc_html_e( 'Street', 'genesis-sample' ); ?></label></th>

				<td>
					<input type="text" name="street" id="street" value="<?php echo esc_attr( get_the_author_meta( 'street', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">
						<?php esc_html_e( 'Please enter your street.', 'genesis-sample' );?>
					</span>
				</td>
			</tr>

			<tr>
				<th><label for="city"><?php esc_html_e( 'City', 'genesis-sample' ); ?></label></th>

				<td>
					<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">
						<?php esc_html_e( 'Please enter your city.', 'genesis-sample' );?>
					</span>
				</td>
			</tr>

			<tr>
				<th><label for="state"><?php esc_html_e( 'State', 'genesis-sample' ); ?></label></th>

				<td>
					<input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">
						<?php esc_html_e( 'Please enter your state.', 'genesis-sample' );?>
					</span>
				</td>
			</tr>

			<tr>
				<th><label for="zip"><?php esc_html_e( 'Zip code', 'genesis-sample' ); ?></label></th>

				<td>
					<input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">
						<?php esc_html_e( 'Please enter your zip code.', 'genesis-sample' );?>
					</span>
				</td>
			</tr>

			<tr>
				<th><label for="country"><?php esc_html_e( 'Country', 'genesis-sample' ); ?></label></th>

				<td>
					<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" /><br />
					<span class="description">
						<?php esc_html_e( 'Please enter your country.', 'genesis-sample' );?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
<?php }

add_action( 'personal_options_update', 'ch_save_address_fields_from_user_profiles' );
add_action( 'edit_user_profile_update', 'ch_save_address_fields_from_user_profiles' );
/**
 * Saves input from the address fields on the user profile.
 *
 * @param int $user_id User Id.
 * @return bool
 */
function ch_save_address_fields_from_user_profiles( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_user_meta( $user_id, 'street', $_POST['street'] );
	update_user_meta( $user_id, 'city', $_POST['city'] );
	update_user_meta( $user_id, 'state', $_POST['state'] );
	update_user_meta( $user_id, 'zip', $_POST['zip'] );
	update_user_meta( $user_id, 'country', $_POST['country'] );
}
