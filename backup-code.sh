printf "Code backup starting...\n\n"

# Check for two arguments.
if [[ $# -lt 1  ]] ; then
    printf "Error. the website project folder name must be given, e.g. \"my_website\"\n\n"
    exit 0
fi

# $1 project folder name
tar -cvzf $1.code.tar.gz --exclude='./web/sites/default/files' --exclude='./private' --exclude='./web/sites/default/settings*.php' --exclude='./web/sites/default/services*.yml' $1

printf "Complete.\n\n"
