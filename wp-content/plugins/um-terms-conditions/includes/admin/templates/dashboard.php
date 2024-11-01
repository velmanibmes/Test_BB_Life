<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $tcae ) ) {
	wp_localize_script( 'um-terms-conditions-admin', 'um_terms_conditions_agreement_email', $tcae );
}
wp_enqueue_script( 'um-terms-conditions-admin' );
wp_enqueue_style( 'um-terms-conditions-admin' );
?>

<form method="post" name="um-tc-reset-form" class="um-tc-form">
	<p class="sub">
		<?php esc_html_e( 'Reset agreement', 'um-terms-conditions' ); ?>
		<span class="um_tooltip dashicons dashicons-editor-help" title="<?php esc_attr_e( 'This tool removes information about Terms & Conditions agreement for members with selected role(s).', 'um-terms-conditions' ); ?>"></span>
	</p>

	<?php if ( $error ) : ?>
		<div class="um-tc-notice um-tc-notice-error">
			<?php echo esc_html( $error ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $success ) : ?>
		<div class="um-tc-notice um-tc-notice-success">
			<?php echo esc_html( $success ); ?>
		</div>
	<?php endif; ?>

	<select name="user_role">
		<option value=""><?php esc_html_e( 'All Roles', 'um-terms-conditions' ); ?></option>
		<?php foreach ( UM()->roles()->get_roles() as $role_id => $role_title ) { ?>
			<option value="<?php echo esc_attr( $role_id ); ?>"><?php echo esc_html( $role_title ); ?></option>
		<?php } ?>
	</select>
	<button class="button" type="submit"><?php esc_html_e( 'Reset', 'um-terms-conditions' ); ?></button>

	<input type="hidden" name="um_adm_action" value="terms_conditions_reset">
	<?php wp_nonce_field( 'terms_conditions_reset' ); ?>
</form>

<?php if ( ! empty( $tcae ) ) { ?>
	<br>
	<form method="post" name="um-tc-agreement-email-form" class="um-tc-form">
		<p class="sub">
			<?php esc_html_e( 'Send agreement notification', 'um-terms-conditions' ); ?>
			<span class="um_tooltip dashicons dashicons-editor-help" title="<?php esc_attr_e( 'This tool sends the `Terms & Conditions - Agreement request` email for members with selected role(s) who have not confirmed terms and conditions yet.', 'um-terms-conditions' ); ?>"></span>
		</p>

		<select id="tcae_role" name="user_role" <?php echo $tcae['state'] ? 'disabled' : ''; ?>>
			<option value=""><?php esc_html_e( 'All Roles', 'um-terms-conditions' ); ?></option>
			<?php foreach ( UM()->roles()->get_roles() as $role_id => $role_title ) { ?>
				<option value="<?php echo esc_attr( $role_id ); ?>" <?php selected( $tcae['role'], $role_id ); ?>><?php echo esc_html( $role_title ); ?></option>
			<?php } ?>
		</select>
		<button id="tcae_start" class="button" type="submit" <?php echo $tcae['state'] ? 'disabled' : ''; ?>>
			<?php esc_html_e( 'Send Emails', 'um-terms-conditions' ); ?>
		</button>
		<span class="spinner"></span>

		<div id="tcae_progress"></div>

		<input type="hidden" name="um_adm_action" value="terms_conditions_agreement_email">
		<?php wp_nonce_field( 'terms_conditions_agreement_email' ); ?>
	</form>

	<script type="text/html" id="tmpl-tcae-progress">
		<div id="tcae_progress">
			<# if( data.error ) { #>
				<div class="um-tc-notice um-tc-notice-error">{{data.error}}</div>
			<# } #>
			<# if( data.success ) { #>
				<div class="um-tc-notice um-tc-notice-success">{{data.success}}</div>
			<# } #>
			<# if( data.total ) { #>
				<div class="um-tc-progress-bar">
					<div class="um-tc-progress-bar-done" style="width:{{data.done}}"></div>
				</div>
				<# if( 'done' !== data.state ) { #>
					<button id="tcae_run" class="button" type="button" <# if( 'run' === data.state ) { print( 'disabled' ) } #>>
						<?php esc_html_e( 'Run', 'um-terms-conditions' ); ?>
					</button>
					<button id="tcae_pause" class="button" type="button" <# if( 'pause' === data.state ) { print( 'disabled' ) } #>>
						<?php esc_html_e( 'Pause', 'um-terms-conditions' ); ?>
					</button>
					<button id="tcae_stop" class="button" type="button">
						<?php esc_html_e( 'Cancel', 'um-terms-conditions' ); ?>
					</button>
				<# } #>
			<# } #>
		</div>
	</script>
<?php } ?>
