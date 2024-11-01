<?php

namespace FKCart\Compatibilities;
class Wpml {
	public function __construct() {
		add_filter( 'fkcart_gift_products', [ $this, 'map_gift_products' ] );
		add_filter( 'fkcart_default_upsells', [ $this, 'map_products' ] );
	}

	public function map_gift_products( $gifts ) {
		$gifts['add']    = array_map( [ $this, 'wpml_map_product' ], $gifts['add'] );
		$gifts['remove'] = array_map( [ $this, 'wpml_map_product' ], $gifts['remove'] );

		return $gifts;
	}

	public function map_products( $products ) {
		if ( empty( $products ) ) {
			return $products;
		}

		return array_map( [ $this, 'wpml_map_product' ], $products );
	}

	public function wpml_map_product( $product_id ) {

		if ( ! class_exists( '\WPML_TM_Records' ) ) {
			return $product_id;
		}

		global $wpdb, $wpml_post_translations, $wpml_term_translations;
		$tm_records = new \WPML_TM_Records( $wpdb, $wpml_post_translations, $wpml_term_translations );

		try {
			$translations = $tm_records->icl_translations_by_element_id_and_type_prefix( $product_id, 'post_product' );
			if ( $translations->language_code() !== ICL_LANGUAGE_CODE ) {
				$element_id = $tm_records->icl_translations_by_trid_and_lang( $translations->trid(), ICL_LANGUAGE_CODE )->element_id();
				$product_id = empty( $element_id ) ? $product_id : $element_id;
			}
		} catch ( \Exception $e ) {
		}


		return $product_id;
	}


	public function is_enable() {
		return class_exists( '\SitePress' );
	}
}

Compatibility::register( new Wpml(), 'wpml' );
