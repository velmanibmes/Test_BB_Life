<?php
/**
 * WooCommerce Product Bundles
 * By WooCommerce
 */

namespace FKCart\Compatibilities;
class WooCommerceProductBundles {

	public function __construct() {
		add_filter( 'fkcart_is_child_item', [ $this, 'is_child_product' ], 10, 2 );
		add_filter( 'fkcart_item_hide_you_saved_text', [ $this, 'is_hide_you_saved_text' ], 10, 2 );
		add_action( 'fkcart_before_cart_items', [ $this, 'remove_actions' ] );

	}

	public function is_enable() {
		return class_exists( '\WC_Bundles' );
	}

	public function is_child_product( $status, $cart_item ) {
		if ( isset( $cart_item['bundled_by'] ) ) {
			$bundle_item_id = $cart_item['bundled_item_id'];
			if ( ! ( isset( $cart_item['stamp'] ) && isset( $cart_item['stamp'][ $bundle_item_id ] ) && isset( $cart_item['stamp'][ $bundle_item_id ]['optional_selected'] ) && 'yes' === $cart_item['stamp'][ $bundle_item_id ]['optional_selected'] ) ) {
				$status = true;// do not consider optional item as child product
			}
		}

		return $status;
	}

	public function is_hide_you_saved_text( $status, $cart_item ) {
		if ( isset( $cart_item['bundled_by'] ) ) {
			$status = true;// Hide you saved text for child item including optional item
		}

		return $status;
	}

	public function remove_actions() {
		if ( class_exists( '\WC_PB_Display' ) ) {
			remove_filter( 'woocommerce_cart_item_name', array( \WC_PB_Display::instance(), 'cart_item_title' ),10 );
		}
	}
}

Compatibility::register( new WooCommerceProductBundles(), 'woocommerce-product-bundles' );
