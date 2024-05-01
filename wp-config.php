<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tiendaujap' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ZDG _q&C|}iT[C}HW@AuUo[H!Gy{_<?sf)-r_~sfH9])bu@H..d/!+_`HAwmbv$5' );
define( 'SECURE_AUTH_KEY',  'hz[hp)}E1^rzBKtxQPr0%e&mG*o%FP#8mf!i[4D}8/CA!zExl[rf:B|1Gtc$!W{~' );
define( 'LOGGED_IN_KEY',    'm>S79Rs+<T]u>3l`5+_:B[wG: z*Cy5)bI?ih/|mJ>Hncx#kVfUg|_uzARG4hbT0' );
define( 'NONCE_KEY',        'qo}ScJL6V6>wtHnE1inLIQB{kvm1H/4op=O[:Z6&bG$/m-r:Cep)w=b[ DtGJnwR' );
define( 'AUTH_SALT',        'JG|vzw|E[5kU]~4>7mK1 >g/!{&VgC% iFUX4D!Xm0{S3ij#XM4fC1e&^,Y:H=t]' );
define( 'SECURE_AUTH_SALT', 'vr496GN;ZIseRi_E!25|nid-w~_5QCtayBDA_=qp*X!#^mlP~g!U-P2+,]]JgV(`' );
define( 'LOGGED_IN_SALT',   'Kq9*n*@jukq(%-^lJ[FW`=&`VVn_^LP99}+22Dn`r4V]UU`ZBcE?eS^^C4Ir,}05' );
define( 'NONCE_SALT',       '@OA,K6Zj`Bf}Y~uj>QH+oP2#A$PL}C}(RE[lLw:(NhTj-7?Fa`Q~~DQ~7v<s7/it' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
