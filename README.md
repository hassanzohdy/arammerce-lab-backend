# Aramemrce lab-backend

This is the source code of the backend [lab](http://94.237.44.153/lab/en/)

# Participating

Anyone is so welcomed to make a `PR`.

# Installation
- Run `composer install`
- Once all packages are downloaded, rename `.env.example` to `.env` and edit the database info.
- If you don't have phpMyAdmin, you can run the following command to create the database as it will create new database with the database name in the **.env** file.
    - `php artisan db::create`
- Now run `php artisan migrate`

# Laravel Organizer
This package mainly depends on [Laravel Organizer](https://github.com/hassanzohdy/laravel-organizer
), so please read the package documentation to understand how it is done

# Notes
Please make sure to work with same flow for any `resource` ar any `single route`.

# To do
- Tasks (**In progress**)
- Events (**In progress**)
- Blog/Tutorials (**In progress**)
- User rules/permissions
- User email notifications
- Proposals