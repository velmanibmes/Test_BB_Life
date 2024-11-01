<?php
namespace um_ext\um_terms_conditions\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Terms_Conditions_Public
 * @package um_ext\um_terms_conditions\core
 */
class Terms_Conditions_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'um_after_form_fields', array( &$this, 'display_option' ) );

		add_action( 'um_submit_form_register', array( &$this, 'agreement_validation' ), 9, 2 );
		add_filter( 'um_whitelisted_metakeys', array( &$this, 'extend_whitelisted' ), 10, 2 );

		add_filter( 'um_before_save_filter_submitted', array( &$this, 'add_agreement_date' ) );
		add_filter( 'um_email_registration_data', array( &$this, 'email_registration_data' ) );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$suffix = UM()->frontend()->enqueue()::get_suffix();
		wp_register_script( 'um-terms-conditions', um_terms_conditions_url . 'assets/js/um-terms-conditions-public' . $suffix . '.js', array( 'jquery', 'wp-hooks' ), um_terms_conditions_version, false );
		wp_register_style( 'um-terms-conditions', um_terms_conditions_url . 'assets/css/um-terms-conditions' . $suffix . '.css', array( 'um_styles' ), um_terms_conditions_version );
	}

	/**
	 * @param $args
	 */
	public function display_option( $args ) {
		if ( ! empty( $args['use_terms_conditions'] ) ) {
			$args['args'] = $args;
			UM()->get_template( 'um-terms-conditions-public-display.php', um_terms_conditions_plugin, $args, true );
			wp_enqueue_script( 'um-terms-conditions' );
		}
	}

	/**
	 * @param array $submitted_data
	 * @param array $form_data
	 */
	public function agreement_validation( $submitted_data, $form_data ) {
		$terms_conditions                = get_post_meta( $form_data['form_id'], '_um_register_use_terms_conditions', true );
		$use_terms_conditions_error_text = get_post_meta( $form_data['form_id'], '_um_register_use_terms_conditions_error_text', true );
		$use_terms_conditions_error_text = ! empty( $use_terms_conditions_error_text ) ? $use_terms_conditions_error_text : __( 'Please agree terms & conditions.', 'um-terms-conditions' );

		if ( $terms_conditions && ! isset( $submitted_data['submitted']['use_terms_conditions_agreement'] ) ) {
			UM()->form()->add_error( 'use_terms_conditions_agreement', $use_terms_conditions_error_text );
		}
	}

	/**
	 * @param array $metakeys
	 * @param array $form_data
	 */
	public function extend_whitelisted( $metakeys, $form_data ) {
		$gdpr_enabled = get_post_meta( $form_data['form_id'], '_um_register_use_terms_conditions', true );
		if ( ! empty( $gdpr_enabled ) ) {
			$metakeys[] = 'use_terms_conditions_agreement';
		}
		return $metakeys;
	}

	/**
	 * @param array $submitted
	 *
	 * @return array
	 */
	public function add_agreement_date( $submitted ) {
		if ( isset( $submitted['use_terms_conditions_agreement'] ) ) {
			$submitted['use_terms_conditions_agreement'] = time();
		}

		return $submitted;
	}

	/**
	 * @param $submitted
	 *
	 * @return mixed
	 */
	public function email_registration_data( $submitted ) {
		if ( ! empty( $submitted['use_terms_conditions_agreement'] ) ) {
			$timestamp = ! empty( $submitted['timestamp'] ) ? $submitted['timestamp'] : $submitted['use_terms_conditions_agreement'];

			$submitted['Terms&Conditions Applied'] = wp_date( get_option( 'date_format', 'Y-m-d' ) . ' ' . get_option( 'time_format', 'H:i:s' ), $timestamp );
			unset( $submitted['use_terms_conditions_agreement'] );
		}

		return $submitted;
	}
}
