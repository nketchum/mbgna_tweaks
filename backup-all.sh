printf "Website backup starting...\n\n"

# Check for two arguments. First arg: folder name, Second arg: db port number
if [[ $# -lt 2  ]] ; then
    printf "Error. the website project folder name and port number must be given. Use \\$ \"lando info\" to get the db port number."
    exit 0
fi

$1/backup-code.sh $1
$1/backup-db.sh $1 $2
$1/backup-files.sh $1

printf "Complete.\n\n"
