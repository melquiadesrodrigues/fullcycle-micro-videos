#!/bin/bash

>&2 echo "=================================================================="
>&2 echo "Updating dependencies"

composer install
php artisan key:generate
php artisan config:cache

>&2 echo "Updated dependencies"
>&2 echo "=================================================================="

php artisan migrate

>&2 echo "Migrations Finished"
>&2 echo "=================================================================="

php-fpm
