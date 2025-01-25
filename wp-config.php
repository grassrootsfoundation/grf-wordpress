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

//Using environment variables for memory limits
$wp_memory_limit = (getenv('WP_MEMORY_LIMIT') && preg_match("/^[0-9]+M$/", getenv('WP_MEMORY_LIMIT'))) ? getenv('WP_MEMORY_LIMIT') : '128M';
$wp_max_memory_limit = (getenv('WP_MAX_MEMORY_LIMIT') && preg_match("/^[0-9]+M$/", getenv('WP_MAX_MEMORY_LIMIT'))) ? getenv('WP_MAX_MEMORY_LIMIT') : '256M';

/** General WordPress memory limit for PHP scripts*/
define('WP_MEMORY_LIMIT', $wp_memory_limit);

/** WordPress memory limit for Admin panel scripts */
define('WP_MAX_MEMORY_LIMIT', $wp_max_memory_limit);


//Using environment variables for DB connection information

// ** Database settings - You can get this info from your web host ** //
$connectstr_dbhost = getenv('DATABASE_HOST');
$connectstr_dbname = getenv('DATABASE_NAME');
$connectstr_dbusername = getenv('DATABASE_USERNAME');
$connectstr_dbpassword = getenv('DATABASE_PASSWORD');

// Using managed identity to fetch MySQL access token
if (strtolower(getenv('ENABLE_MYSQL_MANAGED_IDENTITY')) === 'true') {
	try {
		require_once(ABSPATH . 'class_entra_database_token_utility.php');
		if (strtolower(getenv('CACHE_MYSQL_ACCESS_TOKEN')) !== 'true') {
			$connectstr_dbpassword = EntraID_Database_Token_Utilities::getAccessToken();
		} else {
			$connectstr_dbpassword = EntraID_Database_Token_Utilities::getOrUpdateAccessTokenFromCache();
		}
	} catch (RuntimeException $e) {
		$connectstr_dbpassword = '';
		error_log($e->getMessage());
	}
}

/** The name of the database for WordPress */
define('DB_NAME', $connectstr_dbname);

/** MySQL database username */
define('DB_USER', $connectstr_dbusername);

/** MySQL database password */
define('DB_PASSWORD', $connectstr_dbpassword);

/** MySQL hostname */
define('DB_HOST', $connectstr_dbhost);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** Enabling support for connecting external MYSQL over SSL*/
$mysql_sslconnect = (getenv('DB_SSL_CONNECTION')) ? getenv('DB_SSL_CONNECTION') : 'true';
if (strtolower($mysql_sslconnect) != 'false' && !is_numeric(strpos($connectstr_dbhost, "127.0.0.1")) && !is_numeric(strpos(strtolower($connectstr_dbhost), "localhost"))) {
	define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL);
}


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'hVDB/X{+rKnRsBj1OKq5N4J&OF/cI>]pp(&Dy/Hy[7B]D+H^,Qi7P 9wbDQw UJK');
define('SECURE_AUTH_KEY',  'fiVu7aq:2gUKcT%Kc?fR.[`=`Wc(=`4r95S;>?-1|bPRB{D,K2((|>TSRGYT:m)l');
define('LOGGED_IN_KEY',    'a6.h:lMD0I370_JC5 .q+aUxW1?}ww: gjT004[=;PHy2-e[W$cOX.N@WH>~fb!2');
define('NONCE_KEY',        '4a^N-?!{S74~Ln+%zb,6>I&T{QxFaLn^qyg22&CM80Ykn~dI!}u~<y2$0Q]_i})X');
define('AUTH_SALT',        '0g[s/yF]?B|}/^vI>`]r:E#zRxUbo2NS6g{`nAdlTa%;h~>%7JwW8k7{ec;JcJ~t');
define('SECURE_AUTH_SALT', '[n5rhDgP/ts+)a|^7o=3fOu:r.xJWeM3Wj.@<h4:iI:7c#Je{T}wITuI8p?~B%*,');
define('LOGGED_IN_SALT',   'n3-za#/qI|j@lu>D</ UP;<0C[JaPZ;J7G)6R])$:rAd!&x_}l<q>HF b^ep` ^.');
define('NONCE_SALT',       ')fHpgg~KDkE3TJb|wuw:H=(Y%sxY3]tdrWl/7OPrqXZZ0e{ yi<zY$<v86[;.T58');

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy blogging. */
/**https://developer.wordpress.org/reference/functions/is_ssl/ */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	$_SERVER['HTTPS'] = 'on';

$http_protocol = 'http://';
if (!preg_match("/^localhost(:[0-9])*/", $_SERVER['HTTP_HOST']) && !preg_match("/^127\.0\.0\.1(:[0-9])*/", $_SERVER['HTTP_HOST'])) {
	$http_protocol = 'https://';
}

//Relative URLs for swapping across app service deployment slots
define('WP_HOME', $http_protocol . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', $http_protocol . $_SERVER['HTTP_HOST']);
define('WP_CONTENT_URL', '/wp-content');
define('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']);


/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
