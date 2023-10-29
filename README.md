# Product of the day

# This project is build with the following:

* Apache 2.4.56
* MariaDB 10.4.28
* PHP 8.1.17 (VS16 X86 64bit thread safe) + PEAR
* XAMPP Control Panel Version 3.3.0
* Laravel Framework 10.29.0
  * [Laravel starter kit (Breeze and Inertia)](https://laravel.com/docs/10.x/starter-kits#breeze-and-inertia)
* Vue 3.3.7

# What to expect in this project

* Migration and seeder are included


# Commands used in building this project

> upon installation, execute when necessary
```
composer install
npm install
```

> required for fresh DB
```
php artisan migrate
php artisan db:seed --class=WidgetSeeder
php artisan db:seed --class=SlotSeeder
```
