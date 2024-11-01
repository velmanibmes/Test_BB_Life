<?php //phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Metabox for Subscription Info Content
 *
 * @package YITH WooCommerce Subscription
 * @since   1.0.0
 * @author  YITH <plugins@yithemes.com>
 *
 * @var YWSBS_Subscription $subscription Current subscription.
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'YITH_YWSBS_VERSION' ) ) {
	exit; // Exit if accessed directly.
}

$subscription_id  = $subscription->get_id();
$billing_address  = $subscription->get_address_fields( 'billing', true );
$shipping_address = $subscription->get_address_fields( 'shipping', true );

$billing_fields  = ywsbs_get_order_fields_to_edit( 'billing' );
$shipping_fields = ywsbs_get_order_fields_to_edit( 'shipping' );

$subscription_status_list = ywsbs_get_status();
$status                   = $subscription->get_status(); //phpcs:ignore
$subscription_status      = $subscription_status_list[ $status ];
?>

<div id="subscription-data" class="panel">

	<h2>
		<?php
		// translators: Placeholder: subscription id.
		printf( esc_html_x( 'Subscription %s details', 'Placeholder: subscription id', 'yith-woocommerce-subscription' ), esc_html( $subscription->get_number() ) );
		?>
		<span
			class="status <?php echo esc_attr( $status ); ?>"><?php echo esc_html( $subscription_status ); ?></span>
	</h2>
	<p class="subscription_name"> <?php echo esc_html( $subscription->get( 'product_name' ) ); ?> </p>
	<p class="subscription_number"> <?php echo YWSBS_Subscription_Helper()->get_formatted_recurring( $subscription, '', true, true ); // phpcs:ignore ?> </p>

	<div class="subscription_data_column_container">
		<div class="subscription_data_column">
			<h3><?php esc_html_e( 'General Details', 'yith-woocommerce-subscription' ); ?></h3>

			<div class="subscription-date-info">
				<?php if ( ! empty( $subscription->start_date ) ) : ?>
					<span class="subscription-date-info-element">
					<label><?php esc_html_e( 'Started date:', 'yith-woocommerce-subscription' ); ?></label>
					<?php echo esc_html( date_i18n( wc_date_format(), $subscription->start_date ) . ' ' . date_i18n( __( wc_time_format() ), $subscription->start_date ) ); // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>
				</span>
				<?php endif ?>
				<?php if ( ! empty( $subscription->expired_date ) ) : ?>
					<span class="subscription-date-info-element">
					<label><?php esc_html_e( 'Expired date:', 'yith-woocommerce-subscription' ); ?></label>
					<?php echo esc_html( date_i18n( wc_date_format(), $subscription->expired_date ) . ' ' . date_i18n( __( wc_time_format() ), $subscription->expired_date ) ); // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>
				</span>
				<?php endif ?>
				<?php if ( ! empty( $subscription->payment_due_date ) ) : ?>
					<span class="subscription-date-info-element">
					<label><?php esc_html_e( 'Payment due date:', 'yith-woocommerce-subscription' ); ?></label>
					<?php echo esc_html( date_i18n( wc_date_format(), $subscription->payment_due_date ) . ' ' . date_i18n( __( wc_time_format() ), $subscription->payment_due_date ) ); //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>
				</span>
				<?php endif ?>
				<?php if ( ! empty( $subscription->cancelled_date ) ) : ?>
					<span class="subscription-date-info-element">
						<label><?php esc_html_e( 'Cancelled date:', 'yith-woocommerce-subscription' ); ?></label>
						<?php echo esc_html( date_i18n( wc_date_format(), $subscription->cancelled_date ) . ' ' . date_i18n( __( wc_time_format() ), $subscription->cancelled_date ) ); //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>
					</span>
				<?php endif ?>
				<?php if ( ! empty( $subscription->end_date ) ) : ?>
					<span class="subscription-date-info-element">
						<label><?php esc_html_e( 'End date:', 'yith-woocommerce-subscription' ); ?></label>
						<?php echo esc_html( date_i18n( wc_date_format(), $subscription->end_date ) . ' ' . date_i18n( __( wc_time_format() ), $subscription->end_date ) ); //phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText ?>
					</span>
				<?php endif ?>
			</div>
			<p class="form-field form-field-wide">
				<label><?php esc_html_e( 'Payment Method:', 'yith-woocommerce-subscription' ); ?></label>
				<?php echo esc_html( $subscription->payment_method_title ); ?>
			</p>
			<?php if ( ! empty( $subscription->transaction_id ) ) : ?>
				<p class="form-field form-field-wide">
					<label><?php esc_html_e( 'Transaction ID:', 'yith-woocommerce-subscription' ); ?></label>
					<?php echo esc_html( $subscription->transaction_id ); ?>
				</p>
			<?php endif ?>
			<p class="form-field form-field-wide ywsbs-customer">
				<label><?php esc_html_e( 'Customer:', 'yith-woocommerce-subscription' ); ?></label>
				<?php
				$user_string = '';
				$user_id     = $subscription->get_user_id();
				if ( $user_id ) {
					$user = get_user_by( 'id', $user_id );
					/* translators: 1: user display name 2: user ID 3: user email */
					$user_string = sprintf( esc_html( '%1$s (#%2$s &ndash; %3$s)' ), $user->display_name, absint( $user->ID ), $user->user_email );
				}

				?>
				<?php echo wp_kses_post( $user_string ); ?>
				<input type="hidden" value="<?php echo esc_attr( $user_id ); ?>" id="user_id" />
			</p>
		</div>
		<div class="subscription_data_column">
			<h3>
				<?php esc_html_e( 'Billing', 'yith-woocommerce-subscription' ); ?>
			</h3>

			<div class="address">
				<?php

				$formatted_address = WC()->countries->get_formatted_address( $billing_address );
				if ( $formatted_address ) {
					echo '<p>' . wp_kses( $formatted_address, array( 'br' => array() ) ) . '</p>'; // phpcs:ignore
				} else {
					echo '<p class="none_set"><strong>' . esc_html__( 'Address:', 'yith-woocommerce-subscription' ) . '</strong> ' . esc_html__( 'No billing address set.', 'yith-woocommerce-subscriptions' ) . '</p>';
				}

				foreach ( $billing_fields as $key => $field ) {
					if ( isset( $field['show'] ) && false === $field['show'] ) {
						continue;
					}

					$field_name  = 'billing_' . $key;
					$field_value = isset( $billing_address[ $key ] ) ? $billing_address[ $key ] : '';

					if ( 'billing_phone' === $field_name ) {
						$field_value = wc_make_phone_clickable( $field_value );
					} else {
						$field_value = make_clickable( esc_html( $field_value ) );
					}

					echo '<p><strong>' . esc_html( $field['label'] ) . ':</strong> ' . wp_kses_post( $field_value ) . '</p>'; // phpcs:ignore
				}
				?>

			</div>

			<?php
			do_action( 'ywcsb_admin_subscription_data_after_billing_address', $subscription )
			?>

		</div>

		<div class="subscription_data_column">
			<h3>
				<?php esc_html_e( 'Shipping', 'yith-woocommerce-subscription' ); ?>

			</h3>
			<div class="address">
				<?php

				$formatted_address = WC()->countries->get_formatted_address( $shipping_address );
				if ( $formatted_address ) {
					echo '<p>' . wp_kses( $formatted_address, array( 'br' => array() ) ) . '</p>'; // phpcs:ignore
				} else {
					echo '<p class="none_set"><strong>' . __( 'Address:', 'yith-woocommerce-subscription' ) . '</strong> ' . __( 'No shipping address set.', 'yith-woocommerce-subscriptions' ) . '</p>'; // phpcs:ignore
				}

				foreach ( $shipping_fields as $key => $field ) {
					if ( isset( $field['show'] ) && false === $field['show'] ) {
						continue;
					}

					$field_name  = 'shipping_' . $key;
					$field_value = $shipping_address[ $key ];

					echo '<p><strong>' . esc_html( $field['label'] ) . ':</strong> ' . make_clickable( esc_html( $field_value ) ) . '</p>'; // phpcs:ignore
				}


				?>

			</div>


			<?php
			do_action( 'ywcsb_admin_subscription_data_after_shipping_address', $subscription )
			?>
		</div>
	</div>
	<div class="clear"></div>
</div>
