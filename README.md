## About this test 
    
    This system was created with laravel 8 and laravel sail. To install it
    
    1) Install composer
    2) Install docker
    3) composer install
    4) cp .env.example .env 
    4) ./vendor/bin/sail up -d 
    5) ./vendor/bin/sail php artisan migrate:refresh
    6) ./vendor/bin/sail php artisan test
    7) to stop the container ./vendor/sail stop
