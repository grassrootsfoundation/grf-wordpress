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
define( 'AUTH_KEY',          '+BrwQ;gW[jk;P_m?CFQgJNa{T}N.Hj<~jp0w^%NSCgAMp/Y$3mQ@`+#vDl-w?r4J' );
define( 'SECURE_AUTH_KEY',   'E_}};VH8r_L5yD(hPJo<3Jt+iy;ujWV%A$bqr/0s;z@R&lXJ#gJ3JJ#%>!0<oKPI' );
define( 'LOGGED_IN_KEY',     '@)greP@af6M~/$q:$[mx:w2,Mo7pjb[|^VU5St6>JR9wpj_{-!zD`B>~F2 LztJI' );
define( 'NONCE_KEY',         '[CUJQedh{ RA9-_hR~P)BQ.WAMnV3* Yop04/-D(dK`PaV#k$|K^16LpH1F1b+82' );
define( 'AUTH_SALT',         'h:2.:Pf#!5ZhRKFhrMqv|VK|(}]qd 1d~g5KwMk,BF&p]=5>/gfkeAMg&Gl&vQen' );
define( 'SECURE_AUTH_SALT',  '|I)}#eB&vtl[PNKQwI>4PliwvuK^J]Nt,y8t2[58b.1N #]T:N$@Tw>Lj~0;)$c8' );
define( 'LOGGED_IN_SALT',    '*2~2= )n9FZu zI#RQ7j6H4(*Ym3q!88ait0F}bblS:@c47b_RRu(0@Vrj5tSD5T' );
define( 'NONCE_SALT',        '3Y2.*opi>G~oB8=~OcoZMJRbL *wQze*{26N2Fkz}}i Nb#xS9^ ]B&qvH5Zxeb#' );
define( 'WP_CACHE_KEY_SALT', 'dsSU{$-+/B60qZi|f[B1(iM$$N-uR647KipqwHDBu2<<pBO#r@`z4P<4wb;`9@I!' );


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
