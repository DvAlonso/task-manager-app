# Task Management App

## Requirements

## Installation

Clone the repository

```sh
git clone git@github.com:DvAlonso/task-manager-app.git
cd task-manager-app
```

Create the docker-compose.yml file

```sh
cp docker-compose.template.yml docker-compose.yml
```

Replace the following value with the current user name. You can replace the default container names and network names, but you may continue with the default ones.

```yml
services:
    app:
        build:
            args:
                user: [user_name]
```

Create the .env file

```sh
cp .env.example .env
```

Update the following values inside the .env file

```sh
DB_HOST=[db-container-name] *
DB_PORT=3306
DB_DATABASE=[your_desired_db_name]
DB_USERNAME=[your_desired_db_username]
DB_PASSWORD=[your_desired_db_password]
```

\* If docker-compose.yml was not modified, db-container-name should be replaced with task-manager-db

Build the docker image

```sh
docker-compose build app
```

Start apllication

```sh
docker-compose build -d
```

Run the database migrations. If you changed the container name in the docker-compose.yml file, replace task-manager-app with your container name.

```sh
docker exec -it task-manager-app php artisan migrate:fresh --seed
```

## Docs

## Testing

Run the tests. If you changed the container name in the docker-compose.yml file, replace task-manager-app with your container name.

```sh
docker exec -it task-manager-app php artisan test
```
