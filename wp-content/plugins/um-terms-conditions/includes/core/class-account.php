<?php
namespace um_ext\um_terms_conditions\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that extends the Account page.
 *
 * @usage UM()->classes['um_terms_conditions_account']
 * @usage UM()->Terms_Conditions()->account()
 *
 * @package um_ext\um_terms_conditions\core
 * @since 2.1.6
 */
class Account {

	/**
	 * "Terms & Conditions" agreement field key.
	 *
	 * @var string
	 */
	protected $key = 'use_terms_conditions_agreement';

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'um_after_user_account_updated', array( $this, 'update' ) );
		add_action( 'um_submit_account_terms-conditions_tab_errors_hook', array( $this, 'validate' ), 11 );
		add_filter( 'um_account_page_default_tabs_hook', array( $this, 'add_tabs' ) );
		add_filter( 'um_account_content_hook_terms-conditions', array( $this, 'content' ) );
		add_filter( 'um_custom_success_message_handler', array( $this, 'notice' ), 10, 2 );
	}

	/**
	 * Extend account menu.
	 *
	 * @param  array $tabs Account tabs.
	 * @return array
	 */
	public function add_tabs( $tabs ) {
		if ( ! $this->is_hidden() ) {
			$tabs[999]['terms-conditions'] = array(
				'icon'            => 'um-faicon-info',
				'title'           => __( 'Terms & Conditions', 'um-terms-conditions' ),
				'submit_title'    => __( 'Confirm', 'um-terms-conditions' ),
				'without_setting' => true,
				'custom'          => true,
			);
		}
		return $tabs;
	}

	/**
	 * Get template for the "Terms & Conditions" account tab.
	 *
	 * @param  string $output Tab content.
	 * @return string
	 */
	public function content( $output = '' ) {
		if ( $this->is_hidden() ) {
			return $output;
		}

		$post_id = UM()->options()->get( 'terms_conditions_account_tab_content_id' );

		if ( $post_id && 'publish' === get_post_status( $post_id ) ) {
			$post    = get_post( $post_id );
			$content = apply_filters( 'the_content', $post->post_content, $post_id );

			$error = ( is_array( UM()->form()->errors ) && array_key_exists( $this->key, UM()->form()->errors ) ) ? UM()->form()->errors[ $this->key ] : '';
			$key   = $this->key;
			$value = (bool) get_user_meta( get_current_user_id(), $this->key, true );

			$texts_def = array(
				'text_agreement' => __( 'I agree to these terms and conditions', 'um-terms-conditions' ),
				'text_hide'      => __( 'Hide Terms', 'um-terms-conditions' ),
				'text_show'      => __( 'Show Terms', 'um-terms-conditions' ),
			);

			$texts_options = array(
				'text_agreement' => UM()->options()->get( 'terms_conditions_account_tab_agreement' ),
				'text_hide'      => UM()->options()->get( 'terms_conditions_account_tab_toggle_hide' ),
				'text_show'      => UM()->options()->get( 'terms_conditions_account_tab_toggle_show' ),
			);

			$texts = wp_parse_args( array_filter( $texts_options ), $texts_def );

			$t_args  = array_merge( compact( 'content', 'error', 'key', 'post', 'post_id', 'value' ), $texts );
			$output .= UM()->get_template( 'account.php', um_terms_conditions_plugin, $t_args );
		}

		return $output;
	}

	/**
	 * Check if the "Terms & Conditions" account tab is hidden.
	 *
	 * @return bool
	 */
	public function is_hidden() {
		return empty( UM()->options()->get( 'terms_conditions_account_tab' ) ) || ( UM()->options()->get( 'terms_conditions_account_tab_hide' ) && get_user_meta( get_current_user_id(), $this->key, true ) );
	}

	/**
	 * Custom success message.
	 *
	 * @param  string $success Success message.
	 * @param  string $updated Updated key.
	 * @return string
	 */
	public function notice( $success, $updated ) {
		if ( 'terms_conditions_account' === $updated ) {
			$success = __( 'You have confirmed terms and conditions.', 'um-terms-conditions' );
		}
		return $success;
	}

	/**
	 * Update agreement in account form.
	 *
	 * @param int $user_id User ID.
	 */
	public function update( $user_id ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is already verified here
		if ( isset( $_POST['_um_account'], $_POST['_um_account_tab'] ) && 'terms-conditions' === sanitize_text_field( $_POST['_um_account_tab'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is already verified here
			if ( ! empty( $_POST[ $this->key ] ) && ! UM()->form()->has_error( $this->key ) ) {
				update_user_meta( $user_id, $this->key, time() );

				$url = UM()->options()->get( 'terms_conditions_account_tab_hide' ) ? um_get_core_page( 'account', 'terms_conditions_account' ) : add_query_arg( 'updated', 'terms_conditions_account' );
				wp_safe_redirect( $url );
				exit;
			}
		}
	}

	/**
	 * Validate agreement in account form.
	 */
	public function validate() {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is already verified here
		if ( isset( $_POST['_um_account'], $_POST['_um_account_tab'] ) && 'terms-conditions' === sanitize_text_field( $_POST['_um_account_tab'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- Nonce is already verified here
			if ( empty( $_POST[ $this->key ] ) ) {
				$error_text = UM()->options()->get( 'terms_conditions_account_tab_error_text' );
				if ( empty( $error_text ) ) {
					$error_text = __( 'You must agree to our terms & conditions', 'um-terms-conditions' );
				}
				UM()->form()->add_error( $this->key, $error_text );
			}
		}
	}
}
