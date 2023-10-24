printf "Code backup starting...\n\n"

read -p "Project directory name [app]:" dirname
dirname=${dirname:-app}

current_dir=$PWD
cd /
tar -cvzf /app/$dirname.code.tar.gz --exclude='./web/sites/default/files' --exclude='./private' --exclude='./web/sites/default/settings*.php' --exclude='./web/sites/default/services*.yml' $dirname
cd $current_dir

printf "Complete.\n\n"
