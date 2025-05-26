#!/bin/bash
# until nc -z mysql 3306; do
#   echo "Waiting for MySQL..."
#   sleep 2
# done
composer install --no-interaction --prefer-dist

php artisan key:generate
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan config:cache


php artisan serve --host=0.0.0.0 --port=8000
exec php-fpm
