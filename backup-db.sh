printf "Database backup starting...\n\n"

# Check for two arguments.
if [[ $# -lt 2  ]] ; then
    printf "Error. the website project folder name and port number must be given. Use \\$ \"lando info\" to get the db port number."
    exit 0
fi

mysqldump -udrupal9 -pdrupal9 -h127.0.0.1 drupal9 --port=$2 > $1.db.sql
tar -cvzf $1.db.tar.gz $1.db.sql
rm $1.db.sql

printf "Complete.\n\n"
