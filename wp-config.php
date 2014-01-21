<?php
define('COOKIE_DOMAIN', 'social-galaxy.com'); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/var/www/clients/client2/web1/web/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'c2socialgalaxy');

/** MySQL database username */
define('DB_USER', 'c2socialgalaxy');

/** MySQL database password */
define('DB_PASSWORD', 'WaffleKingd0m');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Db^|-3Jqg|(-_~+6.>N;8KF*U-Bz.-eejN0i,^fYyqq?*$.|sB|R^gEvem<LLzfR');
define('SECURE_AUTH_KEY',  ' @-X%2%p >+}|FY<*cI[YStTG{X_VTtD`5j+:FYVaG}qYQ|4n[) -(`8D,BDPZW9');
define('LOGGED_IN_KEY',    'k,XE_hj+kZ~g[iC  XCNxiW&*dDv+J&<Wlel3AiGc-P-U!G(6$|zE0#-7dhpf#1)');
define('NONCE_KEY',        '`b[LMr, ^,sL[i>ay-l<Js1_XqI#pqS0p9JpK#NsG~yYdqlhlA$c2O:?ECu4MbL ');
define('AUTH_SALT',        '.M2QCa&->QBxB[a0.99aph%]+Nu?:cQ` PC~&y/d=Hin8|EOMNt@10NP8kuJ;:?|');
define('SECURE_AUTH_SALT', 'Sc(V9BMg|80h-nACX>>-:0 v6wmZn&JY,KL-T)0@<vK*H0{%F+~uh|-Lb[#|5Iru');
define('LOGGED_IN_SALT',   'jLwRhB,rYpPWVJ=lC#u5`&Y62@yF-#x9+=#_a}BO9{l=yY+tpAr*HXa5iTd/Im#M');
define('NONCE_SALT',       '`y#j,TcOaQZb$fp|&Vn.l*3u^9n?U>d&V+:8~L[Zz.|BUT<{|-Fg*vIpc.0UN2pD');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('MY_HOME','http://social-galaxy.com');
define('BLOG_NAME','Social Galaxy');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
