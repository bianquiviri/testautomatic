#!/usr/bin/env bash
echo "Running  Composer"
composer install;
cp  .env.example .env;
echo "Activando .env"
./vendor/bin/sail up -d;
echo "Migrations"
./vendor/bin/sail php artisan migrate:refresh;
echo "Test"
./vendor/bin/sail php artisan test;

