<?php
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
define('DB_NAME', 'innovabe');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         '|_i1QWs2BbW>h;Wu-;l3]Q=r19.$&&.%8v5gf~X{Pj]u<ZP(YGq+d[l{+lTXg /h');
define('SECURE_AUTH_KEY',  '%](Uiq$7gEXN2XfZVu[s{pnN>@0JG8Nb-4xk+RU`2h.C-d+iEYsbO%qc1w?7*+Q$');
define('LOGGED_IN_KEY',    'p7Kl,o:tUo65N`En^Hv*d1]1FUb`dp1unm;WsipB~7|GkjS}FJd-#!&%}j[pG&0v');
define('NONCE_KEY',        '<ah9$L{W<fK)A[U)kM}!Q26&~^|Y~M^v$sQnm4AKL905n&uVDNjH$],q|uW+s~mx');
define('AUTH_SALT',        '?PpA>Ve:EOLOPlK*nks;&n!~]&k:mK[|+wqB(hz_ZD%^a3t,Y-f@|~U+_dsZP/@w');
define('SECURE_AUTH_SALT', 'XTQ[z8^8r|!3A^H<-L+ldJ?|O-ZGDW]|0S]d>~)j_uz5tmPw`#!EVs-mE7Q{G2f.');
define('LOGGED_IN_SALT',   'pxnX~*TDIB+HGzi2]E3M||nC@2_g YK3HVd&%02U;v*S!uy9!AU pe+-PNC(L]x+');
define('NONCE_SALT',       '9Zi)Gxxe{Ts[RL#E*w{e4>1ZzG={.v$G|_%nLcz=T`pra_&Q>GD3f`Lv3~$OUCJz');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
