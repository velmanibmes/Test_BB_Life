<?php
namespace um_ext\um_terms_conditions\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Terms_Conditions_Admin
 * @package um_ext\um_terms_conditions\admin
 */
class Terms_Conditions_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_action( 'um_admin_custom_register_metaboxes', array( &$this, 'add_metabox_register' ) );
		add_filter( 'um_override_templates_scan_files', array( &$this, 'um_terms_conditions_extend_scan_files' ), 10, 1 );
		add_filter( 'um_override_templates_get_template_path__um-terms-conditions', array( &$this, 'um_terms_conditions_get_path_template' ), 10, 2 );
	}

	/**
	 * @param $action
	 */
	public function add_metabox_register( $action ) {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		add_meta_box(
			'um-admin-form-register_terms-conditions{' . um_terms_conditions_path . '}',
			__( 'Terms & Conditions', 'um-terms-conditions' ),
			array( UM()->metabox(), 'load_metabox_form' ),
			'um_form',
			'side',
			'default'
		);
	}

	/**
	 * Register wp-admin scripts and styles
	 *
	 * @since 2.1.6
	 */
	public function enqueue_scripts() {
		$suffix = UM()->admin()->enqueue()::get_suffix();
		wp_register_script( 'um-terms-conditions-admin', um_terms_conditions_url . 'assets/js/um-terms-conditions-admin' . $suffix . '.js', array( 'jquery', 'wp-hooks' ), um_terms_conditions_version, false );
		wp_register_style( 'um-terms-conditions-admin', um_terms_conditions_url . 'assets/css/um-terms-conditions-admin' . $suffix . '.css', array(), um_terms_conditions_version );
	}

	/**
	 * Scan templates from extension
	 *
	 * @param $scan_files
	 *
	 * @return array
	 */
	public function um_terms_conditions_extend_scan_files( $scan_files ) {
		$extension_files['um-terms-conditions'] = UM()->admin_settings()->scan_template_files( um_terms_conditions_path . '/templates/' );
		$scan_files                             = array_merge( $scan_files, $extension_files );

		return $scan_files;
	}

	/**
	 * Get template paths
	 *
	 * @param $located
	 * @param $file
	 *
	 * @return array
	 */
	public function um_terms_conditions_get_path_template( $located, $file ) {
		if ( file_exists( get_stylesheet_directory() . '/ultimate-member/um-terms-conditions/' . $file ) ) {
			$located = array(
				'theme' => get_stylesheet_directory() . '/ultimate-member/um-terms-conditions/' . $file,
				'core'  => um_terms_conditions_path . 'templates/' . $file,
			);
		}

		return $located;
	}
}
