drush --exclude-paths=sites/default/files:themes/custom/mbgna_dxpr/node_modules:sites/default/settings.php:sites/default/settings.stage.php:sites/default/settings.local.php rsync -y @self:/app/ @stage:/var/www/m-sandbox-01
drush sql:sync -y @self @stage
drush rsync -y @self:%files @stage:%files
drush cache:rebuild --uri=https://m-sandbox-01.nketchum.com