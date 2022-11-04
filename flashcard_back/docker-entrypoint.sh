#!/bin/sh

sleep 10

php artisan config:clear

echo "Migrating the database..."
php artisan migrate --seed

echo "Starting the server..."

php artisan key:generate --force
php artisan serve --host 0.0.0.0 --port 8000