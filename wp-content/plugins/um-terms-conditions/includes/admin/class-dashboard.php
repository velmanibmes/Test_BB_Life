<?php
namespace um_ext\um_terms_conditions\admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class that extends Ultimate Member dashboard.
 *
 * @usage UM()->classes['um_terms_conditions_dashboard']
 * @usage UM()->Terms_Conditions()->dashboard()
 *
 * @package um_ext\um_terms_conditions\admin
 * @since 2.1.6
 */
class Dashboard {

	/**
	 * A number of emails sent per iteration.
	 *
	 * @var int
	 */
	protected $emails_per_once = 7;

	/**
	 * Error message
	 *
	 * @var string
	 */
	public static $error;

	/**
	 * Success message
	 *
	 * @var string
	 */
	public static $success;

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'prepare_metabox' ), 20 );
		add_action( 'um_admin_do_action__terms_conditions_agreement_email', array( &$this, 'do_agreement_email' ) );
		add_action( 'um_admin_do_action__terms_conditions_reset', array( &$this, 'do_reset' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'wp_ajax_terms_conditions_agreement_email', array( &$this, 'ajax_do_agreement_email' ) );
			add_action( 'wp_ajax_terms_conditions_agreement_email_stop', array( &$this, 'ajax_do_agreement_email_stop' ) );
		}
	}

	/**
	 * AJAX action. Send agreement notification.
	 */
	public function ajax_do_agreement_email() {
		check_ajax_referer( 'terms_conditions_agreement_email' );

		$tcae = $this->do_agreement_email();
		if ( is_array( $tcae ) && array_key_exists( 'users', $tcae ) ) {
			unset( $tcae['users'] );
			wp_send_json_success( $tcae );
		} elseif ( self::$error ) {
			wp_send_json_success( self::$error );
		}
	}

	/**
	 * AJAX action. Stop sending agreement notification.
	 */
	public function ajax_do_agreement_email_stop() {
		check_ajax_referer( 'terms_conditions_agreement_email' );
		delete_option( 'um_terms_conditions_agreement_email' );
		wp_send_json_success( true );
	}

	/**
	 * Action. Send agreement notification.
	 *
	 * @return array|string
	 */
	public function do_agreement_email() {
		check_admin_referer( 'terms_conditions_agreement_email' );

		$tcae = get_option( 'um_terms_conditions_agreement_email' );
		if ( empty( $tcae ) ) {
			$tcae = $this->get_tcae_def();
			$role = empty( $_REQUEST['user_role'] ) ? '' : sanitize_key( wp_unslash( $_REQUEST['user_role'] ) );
			$args = array(
				'fields'     => 'id',
				'role'       => $role,
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key'     => 'use_terms_conditions_agreement',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => 'use_terms_conditions_agreement',
						'value'   => '',
						'compare' => '=',
					),
				),
			);

			$users = get_users( $args );

			if ( empty( $users ) ) {
				$tcae['error'] = __( 'There are no members who match criteria.', 'um-terms-conditions' );
				$tcae['state'] = 'error';
			} else {
				$tcae['role']  = $role;
				$tcae['total'] = count( $users );
				$tcae['users'] = $users;
			}
		}

		if ( $tcae['users'] ) {
			$email_address_args = array(
				'fields'  => 'user_email',
				'include' => array_slice( $tcae['users'], $tcae['sent'], $this->emails_per_once ),
			);

			$email_address = get_users( $email_address_args );
			if ( empty( $email_address ) ) {
				$tcae['error'] = __( 'Can not get email address.', 'um-terms-conditions' );
				$tcae['state'] = 'error';
			} else {

				UM()->Terms_Conditions()->email()->send_agreement_email( $email_address );

				$tcae['sent'] += count( $email_address );
				$tcae['done']  = ceil( 100 * $tcae['sent'] / $tcae['total'] ) . '%';
				$tcae['state'] = $tcae['sent'] < $tcae['total'] ? 'run' : 'done';

				if ( 'done' === $tcae['state'] ) {
					$tcae['success'] = __( 'DONE. ', 'um-terms-conditions' );
					// translators: %1$d - total count of users for getting email
					$tcae['success'] .= sprintf( _n( 'Email has been sent to %1$d member.', 'Email has been sent to %1$d members.', $tcae['total'], 'um-terms-conditions' ), $tcae['total'] );
					delete_option( 'um_terms_conditions_agreement_email' );
				} else {
					$tcae['success'] = __( 'Emails are sending. Progress ', 'um-terms-conditions' ) . $tcae['done'];
					// translators: %1$d - process count of users for getting email, %2$d - total count of users for getting email
					$tcae['success'] .= sprintf( _n( 'Email has been sent to %1$d of %2$d member.', 'Email has been sent to %1$d of %2$d members.', $tcae['total'], 'um-terms-conditions' ), $tcae['sent'], $tcae['total'] );
					update_option( 'um_terms_conditions_agreement_email', $tcae );
				}
			}
		}

		return $tcae;
	}

	/**
	 * Action. Remove information about Terms & Conditions agreement.
	 *
	 * @global \wpdb $wpdb
	 */
	public function do_reset() {
		check_admin_referer( 'terms_conditions_reset' );

		$role = empty( $_REQUEST['user_role'] ) ? '' : sanitize_key( wp_unslash( $_REQUEST['user_role'] ) );
		$args = array(
			'fields'       => 'ID',
			'meta_key'     => 'use_terms_conditions_agreement',
			'meta_compare' => 'EXISTS',
			'role'         => $role,
		);

		$users = get_users( $args );

		if ( empty( $users ) ) {
			self::$error = __( 'There are no members who match criteria.', 'um-terms-conditions' );
		} else {
			global $wpdb;

			$count = $wpdb->query(
				"DELETE
				FROM {$wpdb->usermeta}
				WHERE meta_key='use_terms_conditions_agreement' AND
					  user_id IN ('" . implode( "','", $users ) . "')"
			);
			if ( $count ) {
				// translators: %d - a number of users.
				self::$success = sprintf( _n( 'Information about Terms & Conditions agreement removed for %d member.', 'Information about Terms & Conditions agreement removed for %d members.', $count, 'um-terms-conditions' ), $count );
			}
		}
	}

	/**
	 * Get default data for the "Send agreement notification" dashboard tool.
	 *
	 * @return array
	 */
	public function get_tcae_def() {
		return array(
			'done'    => '0%',
			'error'   => '',
			'role'    => '',
			'sent'    => 0,
			'state'   => '',
			'success' => '',
			'total'   => 0,
			'users'   => array(),
		);
	}

	/**
	 * Load metabox
	 */
	public function load_metabox() {
		add_meta_box( 'um-metaboxes-terms-conditions', __( 'Terms & Conditions', 'um-terms-conditions' ), array( &$this, 'metabox_content' ), 'toplevel_page_ultimatemember', 'normal', 'default' );
	}

	/**
	 * Render metabox
	 */
	public function metabox_content() {
		$template = wp_normalize_path( um_terms_conditions_path . 'includes/admin/templates/dashboard.php' );
		if ( file_exists( $template ) ) {
			$error   = self::$error;
			$success = self::$success;

			if ( UM()->options()->get( 'terms_conditions_agreement_on' ) ) {
				$tcae = get_option( 'um_terms_conditions_agreement_email' );
				if ( empty( $tcae ) ) {
					$tcae = $this->get_tcae_def();
				}
			}

			include $template;
		}
	}

	/**
	 * Add metabox
	 */
	public function prepare_metabox() {
		add_action( 'load-toplevel_page_ultimatemember', array( &$this, 'load_metabox' ) );
	}
}
