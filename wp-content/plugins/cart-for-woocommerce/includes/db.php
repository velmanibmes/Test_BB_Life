<?php

namespace FKCart\Includes;

use FKCart\Includes\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Admin
 */
class DB {

	use Instance;

	public function __construct() {
		add_action( 'init', [ $this, 'db_update' ], 12 );
	}

	/**
	 * Perform DB update
	 *
	 * @return void
	 */
	public function db_update() {
		$db_changes = array(
			'0.9.0' => '0_9_0',
			'1.0.3' => '1_0_3',
		);
		$db_options = get_option( 'fkcart_db_options', [] );
		$db_version = isset( $db_options['db_version'] ) ? $db_options['db_version'] : '0.1';
		foreach ( $db_changes as $version_key => $version_value ) {
			if ( version_compare( $db_version, $version_key, '<' ) ) {
				$function_name = 'db_update_' . $version_value;
				$this->$function_name( $version_key );
			}
		}
	}

	/**
	 * @param $version_key
	 *
	 * @return void
	 */
	protected function db_update_0_9_0( $version_key ) {
		if ( ! class_exists( '\FKCart\Pro\Upsells' ) ) {
			$this->update_db_version( $version_key );

			return;
		}

		/** FB Pro min version 2.11.0 required */
		if ( false === fkcart_fb_pro_min_version_verified( '2.11.0' ) ) {
			$this->update_db_version( $version_key );

			return;
		}

		/** Create table */
		$ins = \FKCart\Pro\Upsells::getInstance();
		if ( true === Data::is_upsells_enabled() ) {
			$ins->create_table();
		}

		$this->update_db_version( $version_key );
	}

	/**
	 * Update db option key with version
	 *
	 * @param $version
	 *
	 * @return void
	 */
	private function update_db_version( $version ) {
		$db_options               = get_option( 'fkcart_db_options', [] );
		$db_options['db_version'] = $version;

		/** Updating version */
		update_option( 'fkcart_db_options', $db_options, true );
	}

	protected function db_update_1_0_3( $version_key ) {
		$settings = Data::get_db_settings();
		if ( ! isset( $settings['saving_text'] ) || empty( $settings['saving_text'] ) ) {
			$this->update_db_version( $version_key );

			return;
		}

		if ( strpos( $settings['saving_text'], '{{saving_percentage}}' ) !== false ) {
			$this->update_db_version( $version_key );

			return;
		}

		$settings['saving_text'] .= " {{saving_percentage}}";

		Data::save_settings( $settings );

		$this->update_db_version( $version_key );
	}
}
