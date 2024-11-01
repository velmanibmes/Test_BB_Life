<?php
/**
 * Stripe for WooCommerce by FunnelKit
 */

namespace FKCart\Compatibilities;

class FunnelKitStripe {
	/**
	 * Remove Smart Button when Quick View OPen
	 * @return void
	 */
	public function remove_smart_buttons() {
		$product_page_action   = 'woocommerce_after_add_to_cart_quantity';
		$product_page_priority = 10;
		$instance              = \FKWCS\Gateway\Stripe\SmartButtons::get_instance();
		if ( isset( $instance->local_settings['express_checkout_product_page_position'] ) && ( 'below' === $instance->local_settings['express_checkout_product_page_position'] || 'inline' === $instance->local_settings['express_checkout_product_page_position'] ) ) {
			$product_page_action   = 'woocommerce_after_add_to_cart_button';
			$product_page_priority = 1;
		}
		remove_action( $product_page_action, [ $instance, 'payment_request_button' ], $product_page_priority );
	}

	public function is_enable() {
		return class_exists( '\FKWCS_Gateway_Stripe' );
	}
}

Compatibility::register( new FunnelKitStripe(), 'funnelkit_stripe' );
