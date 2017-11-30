#!/bin/bash

mkdir -p storage/{log,cache,tmp,email,session}
chmod -R 0777 storage

curl https://getcomposer.org/installer > composer-setup.php
php composer-setup.php
unlink composer-setup.php

echo "Installing PHP dependencies via Composer..."
php composer.phar install
php composer.phar update

./koldy migrate

echo "Cool, you're DONE!"
echo ""
