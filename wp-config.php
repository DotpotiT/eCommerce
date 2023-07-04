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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'eCommerce' );

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
define( 'AUTH_KEY',         'k^1*QL$(>/,cQ^UuEs2W%KeQ;8z_Akz~YZ#d{&-~_?91UL^X{S;_|*id@wwITLjf' );
define( 'SECURE_AUTH_KEY',  'k$74CvmoZA:0#]iCni:(jOBRu`^1R5OAIjE9-t.Tp`3B-,tz?^%{dX|*;d6 %W7l' );
define( 'LOGGED_IN_KEY',    '|kz6}6=jY2Ito(lLGj`t44CN__!N;,a~]9v#xegJ1O:OtMLZ1:Jh)$98mq3,fy6D' );
define( 'NONCE_KEY',        'snqH=n!fOlwSxm[;aV{K(:iYmVo+.6YoX:iFECnG._Q+i/tQR%Cfx(}?;LC?qE=d' );
define( 'AUTH_SALT',        '*q=-LY(,FE7Q1>!r;[)LWr!ihsb5MF(OV9|]]*([i:tcxB,:l*Rqj<l.&R-bDBv=' );
define( 'SECURE_AUTH_SALT', 'a{0~0h8lPv3jp?mV!*=8=,v(R@ZVrQzunr3@ZaCAr S;rZ/n08^(O<JwRDj>@:Jb' );
define( 'LOGGED_IN_SALT',   ';cnNmHJza;YuhAL].u=jjkz2Q97)(r|vkQ`s`NIj.]kA.Wa|guP5T*$/6[v/~,]W' );
define( 'NONCE_SALT',       'ZJvi7yPGsN%Y?z;{zMY]uo3<je0-Zt4.F1|AuhJry2Sg+LB|2!-^;X`W-m+ye<Sr' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
