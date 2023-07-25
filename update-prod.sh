drush --exclude-paths=sites/default/files:themes/custom/mbgna_dxpr/node_modules:sites/default/settings.php:sites/default/settings.stage.php:sites/default/settings.local.php rsync -y @self:/app/ @prod:/var/www/mbgna
drush sql:sync -y @self @prod
drush cache:rebuild --uri=https://mbgna.umich.edu
drush rsync -y @self:%files @prod:%files
