<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sunset');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '^(9{V:%>sg6:okAi(S)lCMd!}R!|6]IGQnQ|XqX Piv`sYB&6~Ikh}_%[R8}20(E');
define('SECURE_AUTH_KEY',  'Oh6)h]w3.OWvNZu</~j_kBw74[bRQ=)8n&-:m*[)BtFWRDEgGrq9xEyTT>xyR^/c');
define('LOGGED_IN_KEY',    'Vg)$1!P];!#8zDhM<g?H%hU&6)a7(Regqn8a28A.r1:IRiA1L[IG[=S{t0FDc..S');
define('NONCE_KEY',        '(i2kgJKGL2?l4Znprhhb)9(_jTFPD8jigyHee2],Qwhvyn|oTj#CT0EUsTvo3C t');
define('AUTH_SALT',        'DsevN*:+o-x|?hnjDk~)tvDFHRHx:RD;.!. C9KSF _(,An3JxGy]!j.9>&a2ZFi');
define('SECURE_AUTH_SALT', '~!(0&cs|^yM7oAD4FghLoV`78J7:1U{*:Bn4vP6Jx%;$7rvhyl*3ZJ1f;^&Lq`zj');
define('LOGGED_IN_SALT',   'vW,f{i.L`Pok!a174WY}3N(Ewix|S[2r6ZoTJ-nB41q{<(=76[ h!m~yaK-5? (;');
define('NONCE_SALT',       '[O>rb6hco[p}h%FBri-X/i)4YYSZ]7jXN(/bku43a;TkGKo}}*f-X; r%exC4P& ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
