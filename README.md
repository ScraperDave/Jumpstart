# Laravel Jumpstart
## Functionality
With Laravel 5.1.x release removing many of the views that got a Laravel project up and running out of the box, we are
left to implement these details ourselves.

This package addresses those chores necessary to get a Laravel project running, as well as other tasks that are often
performed for each new project -- and thus give you a _jumpstart_ on development. ;-)

### Missing Laravel 5.0.x Views
The following views are added:
- /resources/views/app.blade.php
- /resources/views/home.blade.php
- /resources/views/welcome.blade.php
- /resources/views/auth/login.blade.php
- /resources/views/auth/password.blade.php
- /resources/views/auth/register.blade.php
- /resources/views/auth/reset.blade.php

### jQuery 2.1.4
jQuery is implemented locally to allow development without an internet connection, as well as supporting the local
installation of Bootstrap:
- /public/js/jquery-2.1.4.min.js
- /public/js/jquery-2.1.4.min.map

### Bootstrap 3.3.5
Bootstrap has been implemented locally, as CDN references don't work when developing without an internet connection:
- /public/css/bootstrap-3.3.5.min.css
- /public/css/bootstrap-3.3.5.css.map
- /public/css/bootstrap-theme.min.css
- /public/css/bootstrap-theme.css.map
- /public/fonts/glyphicons-halflings-regular.eot
- /public/fonts/glyphicons-halflings-regular.svg
- /public/fonts/glyphicons-halflings-regular.ttf
- /public/fonts/glyphicons-halflings-regular.woff
- /public/fonts/glyphicons-halflings-regular.woff2
- /public/js/bootstrap-3.3.5.min.js

### First/Last Name Migration for `users` Table
This is an option to add `first_name` and `last_name` fields to the users table:

### SoftDeletes Migration for `users` Table
This is an option to add softdelete functionality to the users table.

## Installation
Add the composer package to `composer.json`:
```yml
"require-dev": {
  "genealabs/jumpstart": "~0.1.0"
}
```
Or install it via the composer command: `composer require genealabs/jumpstart ~0.1.0 --dev`.

Next you need to add the ServiceProvider to `\config\app.php`:
```php
//    'providers' => [
//        ...
        GeneaLabs\Jumpstart\JumpstartServiceProvider::class,
//    ]
```
  
## Application
Running this package will respect your customized namespace, and will make backup copies before applying changes.

1. Run `php artisan app:jumpstart`.
2. Decide if you want to have it overwrite or make backups of existing files.
3. Decide if you want to run migrations.
