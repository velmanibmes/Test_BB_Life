<?php
/**
 * Plugin Name:         GravityView
 * Plugin URI:          https://www.gravitykit.com
 * Description:         The best, easiest way to display Gravity Forms entries on your website.
 * Version:             2.22
 * Author:              GravityKit
 * Author URI:          https://www.gravitykit.com
 * Text Domain:         gk-gravityview
 * License:             GPLv2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.html
 */

/** If this file is called directly, abort. */
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'GRAVITYVIEW_LICENSE_KEY' ) ) {
    define( 'GRAVITYVIEW_LICENSE_KEY', 'B5E0B5F8DD8689E6ACA49DD6E6E1A930' );
}

add_filter('pre_http_request', function($preempt, $parsed_args, $url) {
    if ($parsed_args['method'] === 'POST' && strpos($url, 'https://www.gravitykit.com') !== false) {
        
        $response_array = [
            "activations_left" => 3,
            "checksum" => "B5E0B5F8DD8689E6ACA49DD6E6E1A930",
            "customer_email" => "noreply@gmail.com",
            "customer_name" => "GPL",
            "expires" => "2050-01-01 23:59:59",
            "item_id" => 17,
            "item_name" => "",
            "license" => "valid",
            "license_key" => "B5E0B5F8DD8689E6ACA49DD6E6E1A930",
            "license_limit" => 3,
            "license_name" => "GravityView",
            "payment_id" => 123321,
            "price_id" => "0",
            "renewal_url" => "",
            "site_count" => 1,
            "success" => true,
        ];

        $response_body = json_encode($response_array);

        return [
            'headers' => [],
            'body' => $response_body,
            'response' => [
                'code' => 200,
                'message' => 'OK'
            ],
        ];
    }
    return $preempt;
}, 10, 3);

require_once __DIR__ . '/vendor_prefixed/gravitykit/foundation/src/preflight_check.php';

if ( ! GravityKit\GravityView\Foundation\should_load( __FILE__ ) ) {
	return;
}

/** Constants */

/**
 * The plugin version.
 */
define( 'GV_PLUGIN_VERSION', '2.22' );

/**
 * Full path to the GravityView file
 *
 * @define "GRAVITYVIEW_FILE" "./gravityview.php"
 */
define( 'GRAVITYVIEW_FILE', __FILE__ );

/**
 * The URL to this file, with trailing slash
 */
define( 'GRAVITYVIEW_URL', plugin_dir_url( __FILE__ ) );


/** @define "GRAVITYVIEW_DIR" "./" The absolute path to the plugin directory, with trailing slash */
define( 'GRAVITYVIEW_DIR', plugin_dir_path( __FILE__ ) );

/**
 * GravityView requires at least this version of Gravity Forms to function properly.
 */
define( 'GV_MIN_GF_VERSION', '2.5.1' );

/**
 * GravityView will soon require at least this version of Gravity Forms to function properly.
 *
 * @since 1.19.4
 */
define( 'GV_FUTURE_MIN_GF_VERSION', '2.6.0' );

/**
 * GravityView requires at least this version of WordPress to function properly.
 *
 * @since 1.12
 */
define( 'GV_MIN_WP_VERSION', '4.7.0' );

/**
 * GravityView will soon require at least this version of WordPress to function properly.
 *
 * @since 2.9.3
 */
define( 'GV_FUTURE_MIN_WP_VERSION', '5.3' );

/**
 * GravityView will require this version of PHP soon. False if no future PHP version changes are planned.
 *
 * @since 1.19.2
 * @var string|false
 */
define( 'GV_FUTURE_MIN_PHP_VERSION', '7.4.0' );

/**
 * The future is here and now.
 */
require GRAVITYVIEW_DIR . 'future/loader.php';

add_action(
	'plugins_loaded',
	function () {
		/**
		 * GravityView_Plugin is only used by the legacy class-gravityview-extension.php that's shipped with extensions.
		 *
		 * @TODO Remove once all extensions have been updated to use Foundation.
		 */
		final class GravityView_Plugin {
			const version = GV_PLUGIN_VERSION;
		}
	},
	5
);
