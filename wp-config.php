<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ')q~j,q/P&T12$&Kqj6G8+,7 Xd#ITvzfm-G&+vu>M*,~)!.hc3,zT|>CjfF*imMb');
define('SECURE_AUTH_KEY',  '@lU,uKw5LQ8lNURQaW8+u3Z.P`+T&ORZ<98|F5nQ:mZm-?Rx3~ISx|/W[zh~Lg~=');
define('LOGGED_IN_KEY',    'gM(++?3VXy$1zQ#A=QYsb<$BwVGBl+0ZeCwj+S0aU>sHVjkxXF+`5F$C}i^8Qj?^');
define('NONCE_KEY',        'TX73u93N5MC3b}V9;~@sX@g<)L?^ax_p`5[qaylaq=$<ZJ{CGX3z#9t^tbR)817F');
define('AUTH_SALT',        ')@^iyr4]:GEdEYpgOB5.DW/sh}hSm%FD[f=$|<_b|pqK|G`wMo6e|q}f`?6{e2ZO');
define('SECURE_AUTH_SALT', 'qhfCo-0i&OC,l8K-V#^a-[}L_>h*Ue,[3xg*z7 rA.>Eu>Pf3DrM%*`b~A|_6:Gw');
define('LOGGED_IN_SALT',   'Mh4Ne26hXPu`+}et g^7U=!F.EG|(9X;VGpJCzQa}H-s7G_6P3.3/uRz<A@`l>Qe');
define('NONCE_SALT',       '{qp.VAJ`yw|3hUZcgU0^paj:b<_5wE%uO2!)v`(Xv+@(NKde{t*yurF.Q$bbk-0w');
define('FS_METHOD', 'direct');
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
