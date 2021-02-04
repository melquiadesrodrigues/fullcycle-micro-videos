#!/bin/bash

>&2 echo "=================================================================="
>&2 echo "Updating dependencies"

#composer install
#php artisan key:generate
#php artisan config:cache

>&2 echo "Updated dependencies"
>&2 echo "=================================================================="
>&2 echo "Waiting for mysql to be ready"

until mysql -h"$MYSQL_HOST" -P"$MYSQL_PORT" -u"$MYSQL_USERNAME" -p"$MYSQL_PASSWORD" --database="$MYSQL_DATABASE" --execute="SELECT count(table_name) > 0 FROM information_schema.tables;" --skip-column-names -B; do
    sleep 10
done

>&2 echo "Connected to mysql"
>&2 echo "=================================================================="
>&2 echo "Executing migrations"

#php artisan migrate

>&2 echo "Migrations Finished"
>&2 echo "=================================================================="

php-fpm
