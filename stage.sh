drush --exclude-paths=sites/default/files:themes/custom/mbgna_dxpr/node_modules:sites/default/settings.php:sites/default/settings.stage.php:sites/default/settings.local.php rsync @self:/app/ @stage:/var/www/m-sandbox-01
drush sql:sync @self @stage
drush rsync @self:%files @stage:%files
drush cache:rebuild --uri=https://m-sandbox.nketchum.com