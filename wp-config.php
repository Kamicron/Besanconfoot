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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_besanconfoot' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '<_(!Qo]6=aE4wn<f{HlYYvgE6uRqwdtu]qF^*]9o~ HmZS-EgzuC[R*X+ojhJ;-^' );
define( 'SECURE_AUTH_KEY',  'M_NQsE9A8TRi/< Y8Z$!G#tv4N;O=sY&F?N:Z--@(!TXn@*pyo=dG1&@0{;ZsR`o' );
define( 'LOGGED_IN_KEY',    '1E/.i(v4EO~Uc0|M^rLIa({XUpQCxMPuib4(uR_FC5UN>_L9IT/IT0bJ/^&q RKt' );
define( 'NONCE_KEY',        'U(8yD8Sw8]=_m*ra(iO c# 4C|uMidMfTzKYS^5Yc!l{H%c[vx+zORgd.nwm;#G/' );
define( 'AUTH_SALT',        'i_/K#Fmq?/A|`|woG@n7hUtZ,oR/&NyJKjG28BPP)Ux_F|7b3IaRPY+1o4!@5X&X' );
define( 'SECURE_AUTH_SALT', '> k;q;I6*G1DD1X_fypQyYRWgdI;f33w9u6JsxZ:V BC=CFo^#>z2H=x)Ug^aPt$' );
define( 'LOGGED_IN_SALT',   'rzA/dFNhlS,>AJMB.qwo30Eqac10;C7um|9;!g.6{no/LQMQ2>oQ3{~d/(#J.K>_' );
define( 'NONCE_SALT',       'ipZUW]|q*g)xNXNcq: m|>!>u3<L0_][.n#]g2Fp|SkWYU?0keaulF]o}1b8ij,T' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
