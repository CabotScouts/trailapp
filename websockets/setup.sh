#!/bin/bash
source .env
composer install

if [[ -z "${APP_KEY}" ]]; then
  php artisan key:generate
fi

php artisan config:cache
