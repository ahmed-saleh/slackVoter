#!/bin/bash

set -e
set -x

echo ">> starting container as "

# navigate to app path
cd api

cp .env.example .env

VENDOR_DIR="/var/www/app/api/vendor"


# Run composer install in case it was not installed
if [[ ! -d $VENDOR_DIR ]]
then
    mkdir $VENDOR_DIR
    composer install;
fi

# this is for development env Only
php artisan clear-compiled
composer dump-autoload
php artisan optimize
php artisan migrate
#php artisan key:generate #TODO: ensure correct permissions inside container before updating .env
php artisan config:cache

php artisan serve --host 0.0.0.0 --port 9000

exec sudo "$@"
