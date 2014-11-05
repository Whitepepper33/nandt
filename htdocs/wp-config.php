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
define('AUTH_KEY',         'UN_zRC32|}I%U4ywu.n@r:-*6YN]s_lHbQ86}+era2IP)JtAw@<0bok{U;|fi=L]');
define('SECURE_AUTH_KEY',  'o/>7i9:RXc1Y_{IPkncjv#W>-st(53S*c]rujo5Ot]xEZ*ruf%bmt?8fP7;-!H98');
define('LOGGED_IN_KEY',    'W&IoGJ{}`.)nc`LjMx/Xq&SryyHv!-b}TC;`|I4 |0z|<LF+hk`?4V52;b7!E@zi');
define('NONCE_KEY',        'NnQYl_1yY.=TTHmcdyWe)k:1)a1!i0nWh.j,7_fS_N-V$v8CWwJ56_=E6Y=|L7V<');
define('AUTH_SALT',        'J0!_8cW0OGx?XwX*Wec$`%i=LG=O+]-}|gCy3-f+K3=+8(WT)MsoNF`>Z#eb@DEe');
define('SECURE_AUTH_SALT', 'IP1`)sc,fYohMrD7_-<d9#[cM1< ]w.GJW%.vmXDV0h=Pk#8OxF9Uqrf=(OXsi~:');
define('LOGGED_IN_SALT',   '*Z+}Ri)9hk|hiZKanRpUdHhA(FZp#I^Tz$G;~_:P[xd4,B!1)^7ND}Go>2vF$-Og');
define('NONCE_SALT',       '^ $-9D|!xdnunU+clS%LOm`HKsWG9;;]i,nXZNK%-)b7aZ;rPmYXve3b+XjX/1$j');

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
