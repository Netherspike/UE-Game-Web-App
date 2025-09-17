## Notes

This app will allow you to manage characters and items in your game

## Installation

Ran with Docker Desktop

1. copy .env.example to .env
2. composer install && bash ./vendor/laravel/sail/bin/sail up
3. docker exec -it <container_id> bash
   1. php artisan key:generate && php artisan key:generate --env=testing
   2. php artisan mig:f --seed && php artisan mig:f --env=testing
   3. php artisan test


you can now view the website in your browser http://localhost/

login with default admin account:

email: admin@game.com

password: password

## Upcoming Changes

Moving away from service classes as they are becoming big, move to separate actions and DTO's for type safety where nessecery.
