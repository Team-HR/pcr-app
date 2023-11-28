

## Requirements
1. Docker Engine >v4
   
## Development Setup
1. Clone repo and open terminal inside the project folder:
2. Create `.env` file from `.env.example`
3. Run the following commands in the terminal:
4. ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs```
5. Run `sail npm install` to install front-end dependencies.
6. Run `sail artisan key:generate` to generate env security key.
7. Run `sail artisan migrate` to create application database.
8. Run `sail artisan db:seed` this will create a `sys_admin` user with default password `sys_admin`.
9. Run `sail npm run dev` while coding.

## What's in the Dev Environment
Containers for Laravel10, php82, phpmyadmin, mariadb, etc. see composer.json and package.json for more information.
