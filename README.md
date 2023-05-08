# Survey Savvy

A web-based survey system created with HTML, CSS, JavaScript, and PHP. This project is a refactor of [survey-system](https://github.com/KyleDuBray/survey-system) for security and usability and to run in [docker](https://www.docker.com/) containers.

## Setup

The [default compose file](./docker-compose.yaml) is being adapted to start up a swarm cluster, and is not yet ready. The [development compose file](docker-compose-dev.yaml) can be used to start up the application locally.

Add the following to your .env file at the project root:

```sh
MYSQL_ROOT_PASSWORD=your_mysql_password
```

The compose will inject the variable in the PHP container at build time.

Create a folder called "env" at the project root, and in it, create a file called `mysql-root-password.txt` with only your password string in it (which matches the one in your .env file). This establishes the root password for MySQL.

Run `docker compose -f docker-compose-dev.yaml up` to start up the Nginx, PHP, and MySQL containers locally.

## Docker Image Information

The [Nginx image](https://hub.docker.com/_/nginx) is used for the php webserver, and in the [Dockerfile](./nginx/Dockerfile) the configuration is added.
The [FPM version](https://www.php.net/manual/en/install.fpm.php) of the [PHP image](https://hub.docker.com/_/php) is used, and in the [Dockerfile](./Dockerfile) mysqli is installed for connecting to the database.
The [MySQL image](https://hub.docker.com/_/mysql) is used, built directly from the pulled image.
