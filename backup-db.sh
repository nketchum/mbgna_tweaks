printf "Database backup starting...\n\n"

read -p "Database name [drupal9]:" dbname
dbname=${dbname:-drupal9}
read -p "Database user [drupal9]:" dbuser
dbuser=${dbuser:-drupal9}
read -p "Database password [drupal9]:" dbpass
dbpass=${dbpass:-drupal9}
read -p "Database host [database]:" dbhost
dbhost=${dbhost:-database}
read -p "Database port [3306]:" dbport
dbport=${dbport:-3306}

current_dir=$PWD
cd /app
mysqldump -u$dbuser -p$dbpass -h$dbhost $dbname --port=$dbport > $dbname.db.sql
tar -cvzf $dbname.db.tar.gz $dbname.db.sql
rm $dbname.db.sql
cd $current_dir

printf "Complete.\n\n"
