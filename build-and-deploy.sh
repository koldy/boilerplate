#!/bin/bash

# First, do normal build, increase version and anything else
./build.sh

DIR="$(dirname "${BASH_SOURCE[0]}")"

if [[ $# -eq 0 ]]
then
	DEPLOY="$DIR/deploy"
	EXCLUDE="deploy"
else
	DEPLOY=$1
	EXCLUDE="$1"
fi

# Delete any previous deploy folder
rm -rf "$DEPLOY"
mkdir "$DEPLOY"

# Optimize vendor autoloader
php composer.phar install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader

# Copy everything to deploy location
rsync -av --progress \
	--exclude='.*' \
	--exclude='Vagrantfile' \
	--exclude='bin' \
	--exclude='*.sh' \
	--exclude='*.json' \
	--exclude='*.xml' \
	--exclude='*.log' \
	--exclude='readme.md' \
	--exclude='composer.*' \
	--exclude='storage' \
	--exclude='logs' \
	--exclude='tests' \
	--exclude='tools' \
	--exclude="$EXCLUDE" \
	./ \
	"$DEPLOY"

# Take back vendor folder as it was before
php composer.phar install

sed -i 's#=> Koldy\\Application::DEVELOPMENT#=> Koldy\\Application::PRODUCTION#g' deploy/public/index.php

# Deploy folder is now ready, only production files are there. Original boilerplate project in deploy folder should
# be around 1.5MB (du -hs). You need to take care about the configuration files, it depends on your infrastructure.