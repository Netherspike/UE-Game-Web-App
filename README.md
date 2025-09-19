## Notes

Laravel 12 application to manage game data and provide token based authentication via sanctum.

## Installation

Run with Docker Desktop for local testing with your UE5 game.

1. > `cp .env.example .env`
2. > `composer install && bash ./vendor/laravel/sail/bin/sail up`
3. > `docker exec -it <container_id> bash`
   1. > `php artisan key:generate && php artisan key:generate --env=testing`
   2. > `php artisan mig:f --seed && php artisan mig:f --env=testing`
   3. > `php artisan test`


you can now view the website in your browser http://localhost/

## API Auto documentation - locked to local env only
http://localhost/docs/api

## Default admin credentials after initial seeding

Email: `admin@game.com`

Password: `password`
