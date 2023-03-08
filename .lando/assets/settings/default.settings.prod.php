<?php

// Set a default private files directory outside of the docroot.
$settings['file_private_path'] = '../private';

// Set a default config sync directory outside of the docroot.
// This is defined inside the read-only "config" directory, deployed via Git.
$settings['config_sync_directory'] = '../config/sync';

// Logging
$config['system.logging']['error_level'] = 'hide';

// Preprocessing
$config['system.performance']['css']['preprocess'] = TRUE;
$config['system.performance']['js']['preprocess'] = TRUE;

// Caching
// $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
// $settings['cache']['bins']['render'] = 'cache.backend.null';

// Security
$settings['hash_salt'] = 'DEVELOPMENT';
$settings['rebuild_access'] = FALSE;
$settings['skip_permissions_hardening'] = FALSE;

// Services
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.prod.yml';
$settings['hash_salt'] = '';

// Misc
$settings['extension_discovery_scan_tests'] = FALSE;

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
