<?php
namespace um_ext\um_terms_conditions\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class required to the first setup.
 *
 * @package um_ext\um_terms_conditions\core
 * @since 2.1.6
 */
class Setup {

	/**
	 * @var array
	 */
	public $settings_defaults;

	/**
	 * Setup constructor.
	 */
	public function __construct() {
		// Settings defaults.
		$this->settings_defaults = array(
			'terms_conditions_account_tab'   => 0,
			'terms_conditions_agreement_on'  => 1,
			'terms_conditions_agreement_sub' => __( '{site_name} - Terms & Conditions', 'um-terms-conditions' ),
		);
	}

	/**
	 * Set default settings function
	 */
	public function set_default_settings() {
		$options = get_option( 'um_options', array() );

		foreach ( $this->settings_defaults as $key => $value ) {
			//set new options to default
			if ( ! isset( $options[ $key ] ) ) {
				$options[ $key ] = $value;
			}
		}

		update_option( 'um_options', $options );
	}

	/**
	 * Run Terms&Conditions Setup
	 */
	public function run_setup() {
		$this->set_default_settings();
	}
}
