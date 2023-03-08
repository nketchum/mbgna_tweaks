<?php

// Set a default private files directory outside of the docroot.
$settings['file_private_path'] = '../private';

// Set a default config sync directory outside of the docroot.
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Logging
$config['system.logging']['error_level'] = 'verbose';

// Preprocessing
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;

// Caching
// $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
// $settings['cache']['bins']['render'] = 'cache.backend.null';

// Security
$settings['hash_salt'] = 'DEVELOPMENT';
$settings['rebuild_access'] = TRUE;
$settings['skip_permissions_hardening'] = TRUE;

// Services
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.local.yml';
$settings['hash_salt'] = 'DEVELOPMENT';

// Misc
$settings['extension_discovery_scan_tests'] = TRUE;

/**
 * Database settings:
 *
 * The $databases array is normally placed in the sitewide settings.php
 * file. However, it is useful to move the database settings into
 * the environment-specific settings files based on the current
 * environment.
 *
 * After site installation, the installer will place the database array
 * at the bottom of the sitewide settings.php file. If you decide to use
 * different environments that use different database configurations,
 * cut and paste the database array, with modifications, into the
 * environment-specific settings files and activate those settings
 * by deleting the "default." in the filename.
 *
 * Here is a useful reference of how the database array is structured
 * and the information it contains:
 *
 * @code
 * $databases['default']['default'] = [
 *   'database' => 'databasename',
 *   'username' => 'sqlusername',
 *   'password' => 'sqlpassword',
 *   'host' => 'localhost',
 *   'port' => '3306',
 *   'driver' => 'mysql',
 *   'prefix' => '',
 *   'collation' => 'utf8mb4_general_ci',
 * ];
 * @endcode
 */
