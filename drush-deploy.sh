# Deploy a Drupal site.
#
# This script deploys the full Drupal site, including code, database content, and files. Everything
# is duplicated/synchronized except for any settings.php files in the /web/sites/default directory.
#
# Usage:	$ ./deploy <ORIGIN-SITE-ALIAS> <DESTINATION-SITE-ALIAS>
# Example:	$ ./deploy.sh @self @sandbox

# $1 is the origin site alias
# $2 is the destination site alias
printf "Deployment starting...\n\n"

# Check for two arguments.
if [[ $# -lt 2  ]] ; then
    printf "Error. Both site aliases must be given – the source site alias and the destination site alias, e.g. \"@prod @dev\"\n\n"
    exit 0
fi

# Set origin properties.
printf "Assigning origin site properties...\n"
if [[ $1 == '@dev' || $1 == '@self' ]] ; then
	origin_webroot='/app/'
	printf "Origin alias is: $1\nOrigin webroot is $origin_webroot\n"
elif [[ $1 == '@sandbox' ]]; then
	origin_webroot='/var/www/m-sandbox-01'
	printf "Origin alias is: $1\nOrigin webroot is $origin_webroot\n"
elif [[ $1 == '@stage' ]]; then
	origin_webroot='/var/www/m-stage-01'
	printf "Origin alias is: $1\nOrigin webroot is $origin_webroot\n"
else
	printf "Error. Invalid origin site alias.\n\n"
fi

printf "Assigning destination site properties...\n"
# Set destination properties.
if [[ $2 == '@dev' || $2 == '@self' ]] ; then
	destination_webroot='/app/'
	destination_uri='https://m-sandbox-01.lndo.site'
	printf "Destination alias is: $2\nDestination webroot is $destination_webroot\nDestination uri is $destination_uri\n"
elif [[ $2 == '@sandbox' ]]; then
	destination_webroot='/var/www/m-sandbox-01'
	destination_uri='https://m-sandbox-01.nketchum.com'
	printf "Destination alias is: $2\nDestination webroot is $destination_webroot\nDestination uri is $destination_uri\n"
elif [[ $2 == '@stage' ]]; then
	destination_webroot='/var/www/m-stage-01'
	destination_uri='https://m-stage-01.nketchum.com'
	printf "Destination alias is: $2\nDestination webroot is $destination_webroot\nDestination uri is $destination_uri\n"
else
	printf "Error. Invalid destination site alias.\n\n"
fi
# Leave out prod as a destination since prod MUST by
# synced from the prod environment itself.

# Run drush.
printf "Syncing code...\n"
drush --exclude-paths=sites/default/files:sites/default/settings.php:sites/default/settings.prod.php:sites/default/settings.stage.php:sites/default/settings.sandbox.php:sites/default/settings.local.php:node_modules:themes/custom/mbgna_dxpr/node_modules rsync -y $1:$origin_webroot $2:$destination_webroot -- --exclude="._*" --perms --recursive --times
printf "Complete.\n\n"
printf "Syncing database...\n"
drush sql:sync -y $1 $2
printf "Complete.\n\n"
printf "Clearing cache for a moment...\n"
drush cache:rebuild --uri=$destination_uri
printf "Complete.\n\n"
printf "Syncing files...\n"
drush rsync -y $1:%files $2:%files -- --exclude="._*" --perms --recursive --times --chmod=777
printf "Clearing cache one last time...\n"
drush cache:rebuild --uri=$destination_uri
printf "Complete.\n\n"
printf "Deployment finished.\n\n"
