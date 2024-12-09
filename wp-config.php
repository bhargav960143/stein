<?php
//Begin Really Simple Security session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple Security cookie settings
//Begin Really Simple Security key
define('RSSSL_KEY', 'ImYOmysvN4aFICsN58qoPw6nQlqXtDmRvtysoS5BB2r0k0Y8DfhxXUjMFvyhqDiP');
//END Really Simple Security key

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'demo_stein' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'C)4N4!I,eo{8y}sGKy[cle.{X,9v7}Conc-u5FO,M6e+jc>kJO>b5j.h?5NB9v%(' );
define( 'SECURE_AUTH_KEY',  'Zqu;z$<V6&`7&-cu[.&%$#<Lp$R<&/N2!vg4e~=AfF3V]&,1+CJ*4aWb9#%d_9z3' );
define( 'LOGGED_IN_KEY',    '*8;;=r$A,4Ebb*|eK^u2z8*f{4]kIG2 _y[Q}C[FzjLE:XnS&bSv7Z4}RIqky:|L' );
define( 'NONCE_KEY',        '# xU~nYk>J?MZR0z(EBY_vK2CS@lth(VYby|%5}{vvQOw$)c6eS@umSi@UBLSG,9' );
define( 'AUTH_SALT',        'KYpnp/fh^3*<PqlZokd]5+YTNIjq/cr{85/GJq3RWLKlNSFf{}Q#lgc;*+1@3mWK' );
define( 'SECURE_AUTH_SALT', '-<-3h6~0b:?LmmM`_R^-]a JIs(qeKCHR`+r-_wnUnhkO-+YH{q@R))gt56, t~#' );
define( 'LOGGED_IN_SALT',   'O6.DIFI[jM+~kK+`V*&1ic//gb Kc01cG.d&<A8~O^^M/:E7;e#Jv}F!Ad&=j/Q.' );
define( 'NONCE_SALT',       '%6LQg%j(c4u<N^39H^1}}PxQ2YJ19~;Q[U#l[JfF@lSMr{C0(;}`+:]M;k=N0Cl/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
