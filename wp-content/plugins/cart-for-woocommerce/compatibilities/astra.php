<?php
/**
 * Astra Theme
 */

namespace FKCart\Compatibilities;
class Astra {
	public function __construct() {
		add_action( 'fkcart_quick_before_view_content', [ $this, 'remove_action' ] );
	}

	public function is_enable() {
		return defined( 'ASTRA_THEME_VERSION' );
	}

	public function remove_action() {
		if ( ! class_exists( '\Astra_Woocommerce' ) ) {
			return;
		}
		remove_action( 'woocommerce_single_product_summary', array( \Astra_Woocommerce::get_instance(), 'single_product_content_structure' ), 10 );
		remove_action( 'woocommerce_single_product_summary', array( \Astra_Woocommerce::get_instance(), 'astra_woo_product_in_stock' ), 10 );
		remove_filter( 'woocommerce_get_stock_html', 'astra_woo_product_in_stock', 10 );
	}
}

Compatibility::register( new Astra(), 'astra' );
