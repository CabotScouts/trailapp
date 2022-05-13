#!/bin/bash
source .env
composer install

if [[ -z "${APP_KEY}" ]]; then
  php artisan key:generate
fi

php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
