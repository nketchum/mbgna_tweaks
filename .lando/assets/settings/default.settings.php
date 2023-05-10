<?php

// Default settings.
$settings['config_sync_directory'] = '../config/sync';
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['entity_update_backup'] = TRUE;
$settings['entity_update_batch_size'] = 50;
$settings['file_scan_ignore_directories'] = ['node_modules', 'bower_components'];
$settings['file_private_path'] = '../private';
$settings['hash_salt'] = '';
$settings['maintenance_theme'] = 'claro';
$settings['migrate_node_migrate_type_classic'] = FALSE;
$settings['trusted_host_patterns'] = ['.*'];
$settings['update_free_access'] = FALSE;

// Production settings. Overrides default.
if (file_exists($app_root . '/' . $site_path . '/settings.prod.php')) {
  include $app_root . '/' . $site_path . '/settings.prod.php';
}

// Stage settings. Overrides default and production.
if (file_exists($app_root . '/' . $site_path . '/settings.stage.php')) {
  include $app_root . '/' . $site_path . '/settings.stage.php';
}

// Local settings. Overrides everything.
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

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
