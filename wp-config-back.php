<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_USER', 'zcl');

/** MySQL database password */
define('DB_PASSWORD', '123456');

/** MySQL hostname */
define('DB_HOST', '172.20.5.24');

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
define('AUTH_KEY',         '1%h7Ld?34_lB1x|KU.{m1VD-?%@AW<<ct|`t9mnLDw*H_Ii_?p?v`QPG$Nl2fr~w');
define('SECURE_AUTH_KEY',  'a[-9Z-`!vYNb+voJ?|HV/~vrxuwI$UcH(qxVxO]SxI;V?_/qa/IH~2?yBsJMN-lZ');
define('LOGGED_IN_KEY',    '(9MF /@-{+FaJyKWH}0FCO?wWd;:*L_~-k+]zsV[f>+8^rWHsFk|RC&2lI1VMJp|');
define('NONCE_KEY',        '}X[%(%48<- ;dEt{tI|QCBFi/dG-397o3ZXmOG`z%VX.EY}{rnK{LC~#oHq~6Rvr');
define('AUTH_SALT',        's(1Nt<)}?xX.0Ne0Sz/I*Jq|94MQQQd{j4{fV q(P6Hw-=NkGjBD?9|S@{f-Syc!');
define('SECURE_AUTH_SALT', '+P$<b$(6@pCNxQf#$e9`W}]T)j}A<:w]6_Ms#AL^3YPr[eG5I]mOuMl~N)({~I-6');
define('LOGGED_IN_SALT',   '*^K8>d*iB/>l0/fGtd/-p9bti#++K$<D~~=BB!Z4Bj3#<m|aB`$+>&?bL0b%CdIc');
define('NONCE_SALT',       ']Z+^o7|[n6#R3vj1G:?wlsYw,.aDq90b9N4@pieDd%H^$W<xt;5B3$@Yo92[7U=t');

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
