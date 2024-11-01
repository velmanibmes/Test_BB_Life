<?php
namespace um_ext\um_terms_conditions\admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that extends Ultimate Member settings.
 *
 * @usage UM()->classes['um_terms_conditions_settings']
 * @usage UM()->Terms_Conditions()->settings()
 *
 * @package um_ext\um_terms_conditions\admin
 * @since 2.1.6
 */
class Settings {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_filter( 'um_settings_structure', array( &$this, 'extend_settings' ), 10, 1 );
		add_filter( 'um_settings_map', array( &$this, 'extend_settings_map' ), 10, 1 );
	}


	/**
	 * Add section "Terms & Conditions" to the "Extensions" tab.
	 *
	 * @param  array $settings UM Settings.
	 * @return array
	 */
	public function extend_settings( $settings ) {

		$settings['extensions']['sections']['terms-conditions'] = array(
			'title'	 => __( 'Terms & Conditions', 'um-terms-conditions' ),
			'fields' => array(
				array(
					'id'      => 'terms_conditions_account_tab',
					'type'    => 'checkbox',
					'label'   => __( 'Terms & Conditions account tab', 'um-terms-conditions' ),
					'tooltip' => __( 'Enable/disable the Terms & Conditions account tab in account page', 'um-terms-conditions' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_hide',
					'type'        => 'checkbox',
					'label'       => __( 'Hide the tab after agreement', 'um-terms-conditions' ),
					'tooltip'     => __( 'Hide the Terms & Conditions account tab after agreement', 'um-terms-conditions' ),
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_content_id',
					'type'        => 'select',
					'label'       => __( 'Content', 'um-terms-conditions' ),
					'options'     => UM()->query()->wp_pages(),
					'placeholder' => __( 'Choose a page...', 'ultimate-member' ),
					'compiler'    => true,
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_toggle_show',
					'type'        => 'text',
					'label'       => __( 'Toggle Show text', 'um-terms-conditions' ),
					'placeholder' => __( 'Show Terms', 'um-terms-conditions' ),
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_toggle_hide',
					'type'        => 'text',
					'label'       => __( 'Toggle Hide text', 'um-terms-conditions' ),
					'placeholder' => __( 'Hide Terms', 'um-terms-conditions' ),
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_agreement',
					'type'        => 'text',
					'label'       => __( 'Checkbox agreement description', 'um-terms-conditions' ),
					'placeholder' => __( 'I agree to these terms and conditions', 'um-terms-conditions' ),
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
				array(
					'id'          => 'terms_conditions_account_tab_error_text',
					'type'        => 'text',
					'label'       => __( 'Error text', 'um-terms-conditions' ),
					'placeholder' => __( 'You must agree to our terms & conditions', 'um-terms-conditions' ),
					'conditional' => array( 'terms_conditions_account_tab', '=', '1' ),
				),
			),
		);

		return $settings;
	}


	/**
	 * A map for the settings in the "Terms & Conditions" section.
	 *
	 * @param  array $settings_map UM settings map for sanitize.
	 * @return array
	 */
	public function extend_settings_map( $settings_map ) {
		return array_merge(
			$settings_map,
			array(
				'terms_conditions_account_tab'             => array(
					'sanitize' => 'bool',
				),
				'terms_conditions_account_tab_hide'        => array(
					'sanitize' => 'bool',
				),
				'terms_conditions_account_tab_content_id'  => array(
					'sanitize' => 'absint',
				),
				'terms_conditions_account_tab_toggle_show' => array(
					'sanitize' => 'text',
				),
				'terms_conditions_account_tab_toggle_hide' => array(
					'sanitize' => 'text',
				),
				'terms_conditions_account_tab_agreement'   => array(
					'sanitize' => 'text',
				),
				'terms_conditions_account_tab_error_text'  => array(
					'sanitize' => 'text',
				),
			)
		);
	}

}
