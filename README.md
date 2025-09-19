## Notes

This app will allow you to manage characters and items in your game and provide token based authentication for the game.

## Installation

Run with Docker Desktop for local testing with your UE5 game.

1. copy .env.example to .env
2. composer install && bash ./vendor/laravel/sail/bin/sail up
3. docker exec -it <container_id> bash
   1. php artisan key:generate && php artisan key:generate --env=testing
   2. php artisan mig:f --seed && php artisan mig:f --env=testing
   3. php artisan test


you can now view the website in your browser http://localhost/

## API Auto documentation - locked to local env only
http://localhost/docs/api

## default admin account after seeding

email: admin@game.com

password: password
