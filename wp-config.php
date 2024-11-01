<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '>aMr):(pt`QDgMS<SpKH-O01(o8I)cbH3VI3(m=`.YyHn[3| Q51M<Ks8lWk}G!~' );
define( 'SECURE_AUTH_KEY',   'Y$Tz7**X6pY,jOWKn>t lkYk_^q_nIj,lo|Fe09%eh^eQ8Pz0<eRdECUH.9D(rwd' );
define( 'LOGGED_IN_KEY',     'EUP9CPWf?l_I/rA9%=9p7Y_pNoGP7>1` e(>QH4p84#P2=];cE9iT+)<|POA2fEg' );
define( 'NONCE_KEY',         '8z!M5JN;BCvzOI>t<.MM=g|IZ@V!i1!t`}ry[-F_;nLXGBcAPmM+_9i=];m<|4I5' );
define( 'AUTH_SALT',         '.3xD+_Z_om:I^NY_Jd=8_ye2[tqGrKtGw_h#3cDr;bIPCzl@xh%Q1tC_o0^IoT) ' );
define( 'SECURE_AUTH_SALT',  'CH=+^VxmGh>>n#vB=H]H9e5v]*K)gY5J~*Tbm#oD*C$J}P2Z5c<6F5i_Y/h+[Nej' );
define( 'LOGGED_IN_SALT',    ']<(q(~oh{<7wSZ+w=XU3$RAhN)GFkS$*`??0/G8:C4mCd3~6BAs?g@Zf&sC)b;}^' );
define( 'NONCE_SALT',        'CS?[IUBOU$ZY;L^8RG9.h~?oEycURaZ~d<f}_4C9>FqS+=18~[cFq,YC2TR?e*d$' );
define( 'WP_CACHE_KEY_SALT', ';H#*&jU/ 4pDa_^(Zjc2<Q{u(uYnGi2b968%GDsHxa+u?B6zv5T2`eu:>z@A_$(Q' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
