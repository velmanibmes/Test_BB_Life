<?php

namespace FKCart\Compatibilities;
/**
 * This compatibility belongs to Polylang and its addon plugins.
 */
class PolyLang {
	public function __construct() {
		add_filter( 'fkcart_gift_products', [ $this, 'map_gift_products' ] );
		add_filter( 'fkcart_default_upsells', [ $this, 'map_defaults_upsells' ] );
	}

	public function is_enable() {
		return defined( 'POLYLANG_PRO' ) && defined( 'PLLWC_VERSION' );
	}

	public function map_gift_products( $gifts ) {
		$gifts['add']    = array_map( [ $this, 'polylang_map_product' ], $gifts['add'] );
		$gifts['remove'] = array_map( [ $this, 'polylang_map_product' ], $gifts['remove'] );

		return $gifts;
	}

	public function polylang_map_product( $product_id ) {
		$new_post = pll_get_post( $product_id );
		if ( false !== $new_post && intval( $new_post ) > 0 ) {
			return $new_post;
		}

		return $product_id;
	}

	public function map_defaults_upsells( $default_upsells ) {
		return array_map( [ $this, 'polylang_map_product' ], $default_upsells );
	}
}

Compatibility::register( new PolyLang(), 'poly_lang' );
