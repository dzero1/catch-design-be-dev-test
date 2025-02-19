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


# import customer csv

use following command to import customers.csv

```
cd api
php artisan import:customer ../customers.csv
```

Also you can run unit test to test the import. (*to run in a testing database, use --env argument.*)

```
php artisan test --env=testing
```
