<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class UM_Terms_Conditions
 */
class UM_Terms_Conditions {

	/**
	 * @var
	 */
	private static $instance;

	/**
	 * @return UM_Terms_Conditions
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Global for backwards compatibility.
		$GLOBALS['um_terms_conditions'] = $this;
		add_filter( 'um_call_object_Terms_Conditions', array( &$this, 'get_this' ) );

		$this->includes();
	}

	/**
	 * @return $this
	 */
	public function get_this() {
		return $this;
	}


	/**
	 * Get instance of the class that extends the Account page.
	 *
	 * @return um_ext\um_terms_conditions\core\Account()
	 */
	public function account() {
		if ( empty( UM()->classes['um_terms_conditions_account'] ) ) {
			UM()->classes['um_terms_conditions_account'] = new um_ext\um_terms_conditions\core\Account();
		}
		return UM()->classes['um_terms_conditions_account'];
	}


	/**
	 * @return um_ext\um_terms_conditions\admin\Terms_Conditions_Admin()
	 */
	public function admin_handlers() {
		if ( empty( UM()->classes['um_terms_conditions_admin'] ) ) {
			UM()->classes['um_terms_conditions_admin'] = new um_ext\um_terms_conditions\admin\Terms_Conditions_Admin();
		}
		return UM()->classes['um_terms_conditions_admin'];
	}


	/**
	 * Get instance of the class that extends Ultimate Member dashboard.
	 *
	 * @return um_ext\um_terms_conditions\admin\Dashboard()
	 */
	public function dashboard() {
		if ( empty( UM()->classes['um_terms_conditions_dashboard'] ) ) {
			UM()->classes['um_terms_conditions_dashboard'] = new um_ext\um_terms_conditions\admin\Dashboard();
		}
		return UM()->classes['um_terms_conditions_dashboard'];
	}


	/**
	 * Get instance of the class that extends Emails.
	 *
	 * @return um_ext\um_terms_conditions\admin\Email()
	 */
	public function email() {
		if ( empty( UM()->classes['um_terms_conditions_email'] ) ) {
			UM()->classes['um_terms_conditions_email'] = new um_ext\um_terms_conditions\admin\Email();
		}
		return UM()->classes['um_terms_conditions_email'];
	}


	/**
	 * @return um_ext\um_terms_conditions\core\Terms_Conditions_Public()
	 */
	public function public_handlers() {
		if ( empty( UM()->classes['um_terms_conditions_public'] ) ) {
			UM()->classes['um_terms_conditions_public'] = new um_ext\um_terms_conditions\core\Terms_Conditions_Public();
		}
		return UM()->classes['um_terms_conditions_public'];
	}


	/**
	 * Get instance of the class that extends Ultimate Member settings.
	 *
	 * @return um_ext\um_terms_conditions\admin\Settings()
	 */
	public function settings() {
		if ( empty( UM()->classes['um_terms_conditions_settings'] ) ) {
			UM()->classes['um_terms_conditions_settings'] = new um_ext\um_terms_conditions\admin\Settings();
		}
		return UM()->classes['um_terms_conditions_settings'];
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function includes() {
		if ( UM()->is_request( 'admin' ) ) {
			$this->admin_handlers();
			$this->dashboard();
			$this->email();
			$this->settings();
		} else {
			$this->account();
		}

		$this->public_handlers();
	}
}

add_action( 'plugins_loaded', 'um_init_terms_conditions', -10, 1 );
function um_init_terms_conditions() {
	if ( function_exists( 'UM' ) ) {
		UM()->set_class( 'Terms_Conditions', true );
	}
}
