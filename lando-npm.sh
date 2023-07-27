# Install node_modules in theme folder on Lando.
#
# This simplifies using node/npm to install theme assets by keeping the
# appropriate command documented in this file.
#
# Usage:			$ ./lando-npm.sh <THEME_NAME optional> <THEME_DIR optional>
# Default:			$ ./lando-npm.sh
# Specified theme:	$ ./lando-npm.sh mbgna_dxpr
# Specified theme 
# and directory:	$ ./lando-npm.sh mbgna_dxpr /app/web/themes/custom

theme_name='mbgna_dxpr' # folder name without slashes
theme_dir='/app/web/themes/custom' # absolute path with leading slash but without trailing slash.

if [[ $# -eq 2 ]] ; then
	theme_name=$1
fi

if [[ $# -eq 3 ]] ; then
	theme_dir=$2
fi

lando npm install --prefix $theme_dir/$theme_name
