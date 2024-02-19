# Task Management App

## Requirements

-   PHP 8.2 with extensions:
    -   cli
    -   common
    -   mysql
    -   zip
    -   gd
    -   mbstring
    -   curl
    -   xml
    -   bcmatch
    -   intl
    -   sqlite3
-   Composer
-   MySQL (with database and user with privileges)

## Installation

Clone the repository

```sh
git clone git@github.com:DvAlonso/task-manager-app.git
cd task-manager-app
```

Install the dependencies

```sh
composer install
```

Create the .env file

```sh
cp .env.example .env
```

Generate the application key

```sh
php artisan key:generate
```

Update the following values inside the .env file

```sh
DB_DATABASE=[your_db_name]
DB_USERNAME=[your_db_username]
DB_PASSWORD=[your_db_password]
```

Start apllication

```sh
php artisan serve
```

Run the database migrations.

```sh
php artisan migrate:fresh --seed
```

## Docs

## Testing

Run the test suite.

```sh
php artisan test
```
