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
define('DB_NAME', 'nandt');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'Bk}+kr141[v=uy;l?t+,%2eTwDvB5p;Ng}`,h+eto+aJk(mXj&W[TZH7s4WXQ!K@');
define('SECURE_AUTH_KEY',  'J407tTIX!<+,.v{9|.wWA$c^Iskc^k|J hc0Tls43vtKjpKGZ@@h$&%C_AR6YXG ');
define('LOGGED_IN_KEY',    '*w,xl!a1MeHEK+Ou:3+8Wdf#zAWmsX6}l-SK.Y_g]_yvtl0ASK6E_wHXFbW`*_Hd');
define('NONCE_KEY',        '/[u.Ph%VVT ZM=HwlL-z|dTul#X,|@s-=]o-$cjL8hHoRa2T:QnpTfckTUJ(D,K$');
define('AUTH_SALT',        'Twwj$|uetoOnqvR[}KQ;7-+S$@S+^nY+T.urbff~ey@qme_|nc9dk9Tb98uqS-0<');
define('SECURE_AUTH_SALT', 'IHF)(/0yXaIFB|1(Ow;~Y<N9e>aI.(Ow^xmY6c_|)^/$he4$=Zi(:s=_v#c+PUUA');
define('LOGGED_IN_SALT',   'u0ZY]d/ze 4!*6JU$t]^(z*DD|j*>[fXlcG|f[z;~OA/P?_lyb=PFHB;YqP9BL%I');
define('NONCE_SALT',       'P_GpFkSIp)KY]-SWR>$d:Q<8Gu!.um~Q688^?u?7?T{Eu?d$I&.@V^$M36({gu5C');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
