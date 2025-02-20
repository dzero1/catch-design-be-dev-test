# Setup the application

# Pre-requisite
You need to install PHP, MySQL, composer.

## Setup API

In "api" directory, make copy of .env.example to .env and update the mysql db settings

*To run unit tests, you can do same to .env.testing file*

```
DB_HOST = {YOUR_DB_HOST}
DB_PORT = {YOUR_DB_PORT}
DB_DATABASE = {YOUR_DB_NAME}
DB_USERNAME = {YOUR_DB_USER}
DB_PASSWORD = {YOUR_DB_PASSWORD}
```

# DB migration

First fo the db migration to create required tables

```
php artisan migrate
```


# import customer csv

use following command to import customers.csv

```
cd api
php artisan import:customer ../customers.csv
```


# DB Seeding

then you can seed the db. There are two seeders.
```
php artisan db:seed
```

If you want to run seeders separately, do the following.

1. UserSeeder. This user required to test apis
    ```
    php artisan db:seed UserSeeder
    ```
2. CustomerSeeder. This will seed sample customers. (not CSV importing)
    ```
    php artisan db:seed CustomerSeeder
    ```

# Test

To test all related functions you can run following command. (*to run in a testing database, use --env argument.*)

```
php artisan test --env=testing
```