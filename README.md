## Installation

PHP version 8.2 and higher needed to run the application. Database is Sqlite, so no database configuration needed.

Run:
````
composer install
php artisan migrate
````
For tests run:
````
php artisan test
````
To start application run:
````
php artisan serve
````

After application runs brows base url of the application, you should see registration page.
After the registration new game will be created, and you will be redirected to that game through unique url.
On game page you can play/try, create new game, see history of tries, also deactivate the game.

