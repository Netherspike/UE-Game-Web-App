## Notes

This app will allow you to manage characters and items in your game

## Installation

Ran with Docker Desktop

1. copy .env.example to .env
2. composer install && bash ./vendor/laravel/sail/bin/sail up
3. docker exec -it <container_id> bash
   1. php artisan mig:f --seed
   2. php artisan test


you can now view the website in your browser http://localhost/

login with:

email: admin@game.com

password: password

## Upcoming Changes

Moving away from service classes as they are becoming big, move to separate actions and DTO's for type safety where nessecery.
