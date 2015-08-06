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
//define('DB_HOST', '192.168.0.103');
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
define('AUTH_KEY',         'S4xL|5LPfyWI8IUy=~k uDJ~8n,yiufljo-{XW1Szx4oJFi-Ed}7C xJ%hQMXiy{');
define('SECURE_AUTH_KEY',  '>O L<bjCS^{|wT1(5Y@Nq%H{:*w!@&C{7tEc,KXjoJ8)vPL9C^+}UiSsboITv@kh');
define('LOGGED_IN_KEY',    'o9AhRiMh{:V|COlRzChOG;:Mfln|[{8Ld5(PI9,OHw9m|nDX^BN7+_jh|SA/KK12');
define('NONCE_KEY',        '=&oX/ydKa{qjC`ene.5fu$n^DT4dd^~qN:vQ(s[h=EjIUoG[$SY_gTv~i1unHPeM');
define('AUTH_SALT',        '-yt0D[(8&7OC5W+<L_c+n]O +zAPYsT3t{|}A^be|&{F;T,JYujY2rf/>#MF}k@`');
define('SECURE_AUTH_SALT', '7%K=;t?4{F}rh`MA>&0eP.~&kOIr4iaOJ=(d#EQir2mbN/|?DcLQC+Z5;u(]tcnZ');
define('LOGGED_IN_SALT',   'q(&hl+rcCWzg[[TxO;0z%dp@)x9ALoG<b*5--+b@pCa1[Y5~sP};?-W-Xj8(.Ui#');
define('NONCE_SALT',       'G|?R,kQBe0c+lJ7RtzK4$|k/,kNazVgc LJd][c%&YymT0J~+`ZP6[$^7E[i:=J-');

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
