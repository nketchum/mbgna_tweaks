drush --exclude-paths=sites/default/files:themes/custom/mbgna_dxpr/node_modules:sites/default/settings.php:sites/default/settings.stage.php rsync -y @stage:/var/www/m-sandbox-01/ @self:/app
drush sql:sync -y @stage @self
drush cache:rebuild --uri=https://m-sandbox-01.lndo.site
drush rsync -y @stage:%files @self:%files
