<?php
namespace um_ext\um_terms_conditions\admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that extends Emails.
 *
 * @usage UM()->classes['um_terms_conditions_email']
 * @usage UM()->Terms_Conditions()->email()
 *
 * @package um_ext\um_terms_conditions\admin
 * @since 2.1.6
 */
class Email {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_filter( 'um_email_notifications', array( $this, 'email_notifications' ) );
		add_filter( 'um_admin_settings_email_section_fields', array( $this, 'email_placeholders' ), 20, 2 );
		add_filter( 'um_email_templates_path_by_slug', array( $this, 'email_templates_path' ) );
	}

	/**
	 * Extend email notifications
	 *
	 * @param  array $notifications UM email notifications.
	 * @return array
	 */
	public function email_notifications( $notifications ) {
		$notifications['terms_conditions_agreement'] = array(
			'key'            => 'terms_conditions_agreement',
			'title'          => __( 'Terms & Conditions - Agreement request', 'um-terms-conditions' ),
			'description'    => __( 'Send a notification requesting confirmation of terms and conditions.', 'um-terms-conditions' ),
			'subject'        => __( '{site_name} - Terms & Conditions', 'um-terms-conditions' ),
			'body'           => __( 'Please confirm terms and conditions on the site {site_name}', 'um-terms-conditions' ),
			'recipient'      => 'user',
			'default_active' => true,
		);

		return $notifications;
	}

	/**
	 * Extend email templates path
	 *
	 * @param  array $paths Template paths.
	 * @return array
	 */
	public function email_templates_path( $paths ) {
		$paths['terms_conditions_agreement'] = um_terms_conditions_path . 'templates/email/';
		return $paths;
	}

	/**
	 * Extend email notification settings.
	 * Show available placeholders.
	 *
	 * @param  array  $settings  Email settings.
	 * @param  string $email_key Email key.
	 * @return array
	 */
	public function email_placeholders( $settings, $email_key = '' ) {
		if ( 'terms_conditions_agreement' === $email_key ) {
			$settings[] = array(
				'id'          => 'um_info_text',
				'type'        => 'info_text',
				'value'       => __( 'Placeholders:', 'um-terms-conditions' )
				. ' {account_terms_conditions_link}'
				. ' {login_url}'
				. ' {site_name}'
				. ' {site_url}',
				'conditional' => array( $email_key . '_on', '=', 1 ),
			);
		}
		return $settings;
	}

	/**
	 * Send email "Terms & Conditions - Agreement request"
	 *
	 * @param string|array $emails Email address or an array of email addresses.
	 */
	public function send_agreement_email( $emails ) {
		if ( is_string( $emails ) ) {
			$emails = array( $emails );
		}

		$args = array(
			'path'         => um_terms_conditions_path . 'templates/email/',
			'tags'         => array(
				'{account_terms_conditions_link}',
			),
			'tags_replace' => array(
				UM()->account()->tab_link( 'terms-conditions' ),
			),
		);

		foreach ( $emails as $email_address ) {
			UM()->mail()->send( $email_address, 'terms_conditions_agreement', $args );
		}
	}
}
