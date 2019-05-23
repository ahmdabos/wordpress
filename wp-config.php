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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '%8]-0CUvI N}bWdDo[c7]qMKI&A}Gr.tZPGVH^<}.e4%#~)]U0|mI43$U$ZT568~' );
define( 'SECURE_AUTH_KEY',  '(?(_oqHY(6+IPV_p2%|?;|(ty vD0)B<gm]NJDEcJC{|lx~4ExjZXYE{e9.wY$2i' );
define( 'LOGGED_IN_KEY',    'v@J!&MbUxV{R^TA(.r^@Mn^`-nukm`p e+<uh85XccfBf0aH<:w^bTN2Y=hX7!}{' );
define( 'NONCE_KEY',        'oGv>+[n4Xc@LqNft*+2/-L?UA$?<7!<M| -q3Kj~l_Q)U6 D q9d>47$b_i:j7qb' );
define( 'AUTH_SALT',        ',T/>b,RD;W):@M>9PLdZV>{/.!fWUU0@yym8&Q%2`7W,NX`Z6-j}A_JE03M]zut<' );
define( 'SECURE_AUTH_SALT', '2=Z*c[t4<?-7M!+^)Mc+*3O%N=;@Ucv7+fT?_zLIgWIh3We)Fs zozJy,G+V!}KP' );
define( 'LOGGED_IN_SALT',   'nImIV9ZHBAU|J$T #4Z~6&|z%Aj{}x=W[r`35|uJrt]>?$J]1<^)H06!4=Mtkj/1' );
define( 'NONCE_SALT',       'v(^ma:PBi+|;<jnXu4,OG^m8u*2N,2~a*oulWr+p~NWoP0$i$jEWb1Zo}XE INo:' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
