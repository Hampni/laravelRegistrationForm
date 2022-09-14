Create `.env` file by `.env.example` 


Run commands:
1. `composer install`
2. `./vendor/bin/sail up -d`

Go to `http://localhost:8080/` and create database named `laravelRegistrationForm`

Run commands: 

1. `docker exec -it laravelregistrationform-laravel.test-1 bash`
2. `php artisan migrate`
3. `php artisan db:seed` - test data (not mandatory)
4. `php artisan db:seed CountriesSeeder` - to make country picker work (mandatory)
5. `npm install`
6. `npm run prod`

For authorisation to admin panel. Email: admin@gmail.com Password: 248163264
