# Compile theme assets with Grunt on Lando.
#
# This simplifies using Grunt to compile theme assets by grouping tasks
# into css-related tasks and js-related tasks.
#
# Usage:		$ ./grunt.sh <TASK optional> <THEME_NAME optional> <THEME_DIR optional>
# Compile All:	$ ./grunt.sh all
# Compile CSS:	$ ./grunt.sh js (runs babel task and terser task)
# Compile JS:	$ ./grunt.sh css (runs sass task)

theme_name='mbgna_dxpr' # folder name without slashes
theme_dir='/app/web/themes/custom' # absolute path with leading slash but without trailing slash.

if [[ $# -eq 2 ]] ; then
	theme_name=$2
fi

if [[ $# -eq 3 ]] ; then
	theme_dir=$3
fi

# Check for an argument. If none, then just watch.
if [[ $# -lt 1  || $1 == 'watch' ]] ; then
    lando ssh -s node -c "cd $theme_dir/$theme_name && grunt"
    exit 0
fi

if [[ $1 == 'js' || $1 == 'css' || $1 == 'all' ]] ; then
	if [[ $1 == 'js' || $1 == 'all' ]] ; then
		lando ssh -s node -c "cd $theme_dir/$theme_name && grunt babel"
		lando ssh -s node -c "cd $theme_dir/$theme_name && grunt terser"
	fi
	if [[ $1 == 'css' || $1 == 'all' ]] ; then
		lando ssh -s node -c "cd $theme_dir/$theme_name && grunt sass"
	fi
	exit 0
fi
