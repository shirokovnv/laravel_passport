# Laravel Passport Application

Contains some examples of using Laravel Passport.

Uses authentication via passport personal tokens API.

## Starter

- Laravel v12.x
- PHP v8.3.x
- PostgreSQL v16.x

# Requirements
- Stable version of [Docker](https://docs.docker.com/engine/install/)
- Compatible version of [Docker Compose](https://docs.docker.com/compose/install/#install-compose)

# How To Deploy

## For first time only !
- `cd [PATH TO PROJECT]`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/storage/logs`
- `chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/storage/logs`
- `composer setup`

## From the second time onwards
- `docker compose up -d`

## Passport init

- `php artisan passport:keys`
- `php artisan passport:client --personal`

### API
- http://localhost/api/v1/auth/...
- http://localhost/api/v1/tokens/...
