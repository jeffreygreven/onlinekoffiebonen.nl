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
define( 'DB_NAME', 'ownfinan_koffieboon' );

/** MySQL database username */
define( 'DB_USER', 'ownfinan_koffie' );

/** MySQL database password */
define( 'DB_PASSWORD', 'VXxM4frB5m9rUa6Z' );

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
define( 'AUTH_KEY',         '~Jh*~IA*dKc`,&8P;@P/;[v@Qt IV8(9Rka;Ovd$oF=tO(OfQ[S2nx1=K]e`Zy&n' );
define( 'SECURE_AUTH_KEY',  'HT}7kQBb.Y4@)Ec-!W:4s)Uc{/0kX0x:c@)Jh&=vid6Lo-i!A/yf<4nz#n1SBOhP' );
define( 'LOGGED_IN_KEY',    '%1eb0)mzm_Um=T7{i{RKG5?$tM(;@RFvU&{c)`u&=V^}u;rC!r;Gh$LoM<`x_;(8' );
define( 'NONCE_KEY',        ']z^y<fpTi)l(W(hU{6R$a|ealMk2W9zp,xMmTO8_qcpr*.R.B[6Vdt)?h5c=_Qup' );
define( 'AUTH_SALT',        'i)!,6&!vH^fg4gCm1Ae!@j]p&N8=kw`d0-i+6RoUgFU30yeLyfgAKP0L/JW,gHA$' );
define( 'SECURE_AUTH_SALT', '~)+*8^^A~RzVMGy4?g^,yI7MlUXTFI8c}kr}STXPCB!{wdnbO.{lKt{SC0m/r2Pt' );
define( 'LOGGED_IN_SALT',   ' s*:)BqI-!7}{&-ZVE#*_@4L7`Ra:q;ZLL9*Ae$|G w-X{:$f}9lfLR8fP|ex!C9' );
define( 'NONCE_SALT',       '`%`k9fze>;Ot=!VVa_ZVVQyS-|{[^eXQHe#u:0L*Iw,}.3RF&R:3>,LLUu=ZY (;' );

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
