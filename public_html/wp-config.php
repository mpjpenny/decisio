<?php

define('FORCE_SSL_ADMIN', true);
define('WP_HOME', 'https://decisio.co.uk');
define('WP_SITEURL', 'https://decisio.co.uk');

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL


// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i7805167_wp1' );

/** MySQL database username */
define( 'DB_USER', 'i7805167_wp1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'K.lpGKUNKxqLg6BV0mR18' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'pkHFzzwG5260WHFc8KwO6YpH3UR375PEz38XdPCBm1Hcsz1rFrdn4OjA8JSaclEk');
define('SECURE_AUTH_KEY',  '3w6r1hzmWAEWx7zcBXMAxhc9g8W75qfIs2ly1SaxMkSVmX3rLEhaIgnpG7NB2mh4');
define('LOGGED_IN_KEY',    'q4B7cNyHF8DWl8uJ2gvmUIAXq1kRN6bJNsl7dk0UqPfU4HN6Ih2uwp4yZ3AYF7K6');
define('NONCE_KEY',        '7gd3xQ5uTH38tySsiGJNWeexUGEf2BC6b6YtcBcCM45P5Q66IFWp28H1SNDkaV8y');
define('AUTH_SALT',        'UTsGSQQsGCM8YsBNLxZWPaUM9ASG9WCaPLEH8cpScwQWJxaxepGLdNPApMQvcGSN');
define('SECURE_AUTH_SALT', 'E9zYwSZSn2TMzmRgwnbqo6HX0bOgO6qTlYK8sioAsh1RGku98Ditj9dGsBrnJd0A');
define('LOGGED_IN_SALT',   'lNPPi2U9ltRfexGROF2fCMRt9NmNzNlthLcm3iJ1SiKR1rfsttJazYE89o7GUuNN');
define('NONCE_SALT',       'FsZJTwQYYeB1JqalYuzU57AiAIw8xwQB6LCY5rjx53cHaUd590U4GSdjve7oqsZw');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
