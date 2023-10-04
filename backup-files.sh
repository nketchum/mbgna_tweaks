printf "Files backup starting...\n\n"

# Check for two arguments.
if [[ $# -lt 1  ]] ; then
    printf "Error. the website project folder name must be given, e.g. \"my_website\"\n\n"
    exit 0
fi

# $1 project folder name
tar -cvzf $1.public_files.tar.gz $1/web/sites/default/files $1.private_files.tar.gz $1/web/sites/default/files

printf "Complete.\n\n"
