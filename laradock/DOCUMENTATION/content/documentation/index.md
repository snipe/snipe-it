---
title: Documentation
type: index
weight: 3
---


<a name="List-current-running-Containers"></a>
## List current running Containers
```bash
docker ps
```
You can also use the following command if you want to see only this project containers:

```bash
docker-compose ps
```






<br>
<a name="Close-all-running-Containers"></a>
## Close all running Containers
```bash
docker-compose stop
```

To stop single container do:

```bash
docker-compose stop {container-name}
```






<br>
<a name="Delete-all-existing-Containers"></a>
## Delete all existing Containers
```bash
docker-compose down
```






<br>
<a name="Enter-Container"></a>
## Enter a Container (run commands in a running Container)

1 - First list the current running containers with `docker ps`

2 - Enter any container using:

```bash
docker-compose exec {container-name} bash
```

*Example: enter MySQL container*

```bash
docker-compose exec mysql bash
```

*Example: enter to MySQL prompt within MySQL container*

```bash
docker-compose exec mysql mysql -u homestead -psecret
```

3 - To exit a container, type `exit`.






<br>
<a name="Edit-Container"></a>
## Edit default container configuration
Open the `docker-compose.yml` and change anything you want.

Examples:

Change MySQL Database Name:

```yml
    environment:
        MYSQL_DATABASE: laradock
    ...
```

Change Redis default port to 1111:

```yml
    ports:
        - "1111:6379"
    ...
```






<br>
<a name="Edit-a-Docker-Image"></a>
## Edit a Docker Image

1 - Find the `Dockerfile` of the image you want to edit,
<br>
example for `mysql` it will be `mysql/Dockerfile`.

2 - Edit the file the way you want.

3 - Re-build the container:

```bash
docker-compose build mysql
```
More info on Containers rebuilding [here](#Build-Re-build-Containers).






<br>
<a name="Build-Re-build-Containers"></a>
## Build/Re-build Containers

If you do any change to any `Dockerfile` make sure you run this command, for the changes to take effect:

```bash
docker-compose build
```
Optionally you can specify which container to rebuild (instead of rebuilding all the containers):

```bash
docker-compose build {container-name}
```

You might use the `--no-cache` option if you want full rebuilding (`docker-compose build --no-cache {container-name}`).





<br>
<a name="Docker-Sync"></a>

## Docker-Sync

Docker on the Mac [is slow](https://github.com/docker/for-mac/issues/77), at the time of writing. Especially for larger projects, this can be a problem. The problem is [older than March 2016](https://forums.docker.com/t/file-access-in-mounted-volumes-extremely-slow-cpu-bound/8076) - as it's a such a long-running issue, we're including it in the docs here. 

The problem originates in bind-mount performance on MacOS. Docker for Mac uses osxfs by default. This is not without reason, it has [a lot of advantages](https://docs.docker.com/docker-for-mac/osxfs/).

Solutions to resolve this issue are easily installed however, we're hoping it'll be fixed by Docker themselves over time. They are currently [adding "cached and delegated" options](https://github.com/docker/for-mac/issues/77#issuecomment-283996750), which is partly available for Docker Edge.

Options are [to switch over to NFS](https://github.com/IFSight/d4m-nfs) which is the simplest. The fastest option is [Docker-Sync "native"](https://github.com/EugenMayer/docker-sync) which is still quite easy to install.

Clone [this repo](https://github.com/EugenMayer/docker-sync-boilerplate) to your machine, copy `default/docker-sync.yml` to your Laradock directory and run `docker-sync-stack start`. Be sure to use `docker-sync-stack clean` to stop and `docker-compose build` to rebuild. More information can be found [in the Docker-sync docs](https://github.com/EugenMayer/docker-sync).





<br>
<a name="Add-Docker-Images"></a>

## Add more Software (Docker Images)

To add an image (software), just edit the `docker-compose.yml` and add your container details, to do so you need to be familiar with the [docker compose file syntax](https://docs.docker.com/compose/compose-file/).






<br>
<a name="View-the-Log-files"></a>
## View the Log files
The NGINX Log file is stored in the `logs/nginx` directory.

However to view the logs of all the other containers (MySQL, PHP-FPM,...) you can run this:

```bash
docker logs {container-name}
```

More [options](https://docs.docker.com/compose/reference/logs/)

```bash
docker logs -f {container-name}
```





<br>
<a name="PHP"></a>






<a name="Install-PHP-Extensions"></a>
## Install PHP Extensions

Before installing PHP extensions, you have to decide whether you need for the `FPM` or `CLI` because each lives on a different container, if you need it for both you have to edit both containers.

The PHP-FPM extensions should be installed in `php-fpm/Dockerfile-XX`. *(replace XX with your default PHP version number)*.
<br>
The PHP-CLI extensions should be installed in `workspace/Dockerfile`.






<br>
<a name="Change-the-PHP-FPM-Version"></a>
## Change the (PHP-FPM) Version
By default **PHP-FPM 7.0** is running.

>The PHP-FPM is responsible of serving your application code, you don't have to change the PHP-CLI version if you are planning to run your application on different PHP-FPM version.


### A) Switch from PHP `7.0` to PHP `5.6`

1 - Open the `docker-compose.yml`.

2 - Search for `Dockerfile-70` in the PHP container section.

3 - Change the version number, by replacing `Dockerfile-70` with `Dockerfile-56`, like this:

```yml
    php-fpm:
        build:
            context: ./php-fpm
            dockerfile: Dockerfile-70
    ...
```

4 - Finally rebuild the container

```bash
docker-compose build php-fpm
```

> For more details about the PHP base image, visit the [official PHP docker images](https://hub.docker.com/_/php/).


### B) Switch from PHP `7.0` or `5.6` to PHP `5.5`

We do not natively support PHP 5.5 anymore, but you can get it in few steps:

1 - Clone `https://github.com/laradock/php-fpm`.

3 - Rename `Dockerfile-56` to `Dockerfile-55`.

3 - Edit the file `FROM php:5.6-fpm` to `FROM php:5.5-fpm`.

4 - Build an image from `Dockerfile-55`.

5 - Open the `docker-compose.yml` file.

6 - Point `php-fpm` to your `Dockerfile-55` file.






<br>
<a name="Change-the-PHP-CLI-Version"></a>
## Change the PHP-CLI Version
By default **PHP-CLI 7.0** is running.

>Note: it's not very essential to edit the PHP-CLI version. The PHP-CLI is only used for the Artisan Commands & Composer. It doesn't serve your Application code, this is the PHP-FPM job.

The PHP-CLI is installed in the Workspace container. To change the PHP-CLI version you need to edit the `workspace/Dockerfile`.

Right now you have to manually edit the `Dockerfile` or create a new one like it's done for the PHP-FPM. (consider contributing).






<br>
<a name="Install-xDebug"></a>
## Install xDebug

1 - First install `xDebug` in the Workspace and the PHP-FPM Containers:
<br>
a) open the `docker-compose.yml` file
<br>
b) search for the `INSTALL_XDEBUG` argument under the Workspace Container
<br>
c) set it to `true`
<br>
d) search for the `INSTALL_XDEBUG` argument under the PHP-FPM Container
<br>
e) set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_XDEBUG=true
    ...
    php-fpm:
        build:
            context: ./php-fpm
            args:
                - INSTALL_XDEBUG=true
    ...
```

2 - Re-build the containers `docker-compose build workspace php-fpm`

3 - Open `laradock/workspace/xdebug.ini` and/or `laradock/php-fpm/xdebug.ini` and enable at least the following configurations:

```
xdebug.remote_autostart=1
xdebug.remote_enable=1
xdebug.remote_connect_back=1
```

For information on how to configure xDebug with your IDE and work it out, check this [Repository](https://github.com/LarryEitel/laravel-laradock-phpstorm).






<br>
<a name="Control-xDebug"></a>
## Start/Stop xDebug:

By installing xDebug, you are enabling it to run on startup by default.

To control the behavior of xDebug (in the `php-fpm` Container), you can run the following commands from the Laradock root folder, (at the same prompt where you run docker-compose):

- Stop xDebug from running by default: `.php-fpm/xdebug stop`.
- Start xDebug by default: `.php-fpm/xdebug start`.
- See the status: `.php-fpm/xdebug status`.

Note: If `.php-fpm/xdebug` doesn't execute and gives `Permission Denied` error the problem can be that file `xdebug` doesn't have execution access. This can be fixed by running `chmod` command  with desired access permissions.






<br>
<a name="Install-Deployer"></a>
## Install Deployer (Deployment tool for PHP)

1 - Open the `docker-compose.yml` file
<br>
2 - Search for the `INSTALL_DEPLOYER` argument under the Workspace Container
<br>
3 - Set it to `true`
<br>

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_DEPLOYER=true
    ...
```

4 - Re-build the containers `docker-compose build workspace`

[**Deployer Documentation Here**](https://deployer.org/docs)





<br>
<a name="Production"></a>






<br>
<a name="Laradock-for-Production"></a>
## Prepare Laradock for Production

It's recommended for production to create a custom `docker-compose.yml` file. For that reason, Laradock is shipped with `production-docker-compose.yml` which should contain only the containers you are planning to run on production (usage example: `docker-compose -f production-docker-compose.yml up -d nginx mysql redis ...`).

Note: The Database (MySQL/MariaDB/...) ports should not be forwarded on production, because Docker will automatically publish the port on the host, which is quite insecure, unless specifically told not to. So make sure to remove these lines:

```
ports:
    - "3306:3306"
```

To learn more about how Docker publishes ports, please read [this excellent post on the subject](https://fralef.me/docker-and-iptables.html).






<br>
<a name="Digital-Ocean"></a>
## Setup Laravel and Docker on Digital Ocean

### [Full Guide Here](https://github.com/laradock/laradock/blob/master/_guides/digital_ocean.md)






<br>
<a name="Laravel"></a>






<a name="Install-Laravel"></a>
## Install Laravel from a Docker Container

1 - First you need to enter the Workspace Container.

2 - Install Laravel.

Example using Composer

```bash
composer create-project laravel/laravel my-cool-app "5.2.*"
```

> We recommend using `composer create-project` instead of the Laravel installer, to install Laravel.

For more about the Laravel installation click [here](https://laravel.com/docs/master#installing-laravel).


3 - Edit `docker-compose.yml` to Map the new application path:

By default, Laradock assumes the Laravel application is living in the parent directory of the laradock folder.

Since the new Laravel application is in the `my-cool-app` folder, we need to replace `../:/var/www` with `../my-cool-app/:/var/www`, as follow:

```yaml
    application:
		 image: tianon/true
        volumes:
            - ../my-cool-app/:/var/www
    ...
```
4 - Go to that folder and start working..

```bash
cd my-cool-app
```

5 - Go back to the Laradock installation steps to see how to edit the `.env` file.






<br>
<a name="Run-Artisan-Commands"></a>
## Run Artisan Commands

You can run artisan commands and many other Terminal commands from the Workspace container.

1 - Make sure you have the workspace container running.

```bash
docker-compose up -d workspace // ..and all your other containers
```

2 - Find the Workspace container name:

```bash
docker-compose ps
```

3 - Enter the Workspace container:

```bash
docker-compose exec workspace bash
```

Add `--user=laradock` (example `docker-compose exec --user=laradock workspace bash`) to have files created as your host's user.


4 - Run anything you want :)

```bash
php artisan
```
```bash
Composer update
```
```bash
phpunit
```






<br>
<a name="Run-Laravel-Queue-Worker"></a>
## Run Laravel Queue Worker

1 - First add `php-worker` container. It will be similar as like PHP-FPM Container.
<br>
a) open the `docker-compose.yml` file
<br>
b) add a new service container by simply copy-paste this section below PHP-FPM container

```yaml
    php-worker:
      build:
        context: ./php-fpm
        dockerfile: Dockerfile-70 # or Dockerfile-56, choose your PHP-FPM container setting
      volumes_from:
        - applications
      command: php artisan queue:work
```
2 - Start everything up

```bash
docker-compose up -d php-worker
```





<br>
<a name="Use-Redis"></a>
## Use Redis

1 - First make sure you run the Redis Container (`redis`) with the `docker-compose up` command.

```bash
docker-compose up -d redis
```

2 - Open your Laravel's `.env` file and set the `REDIS_HOST` to `redis`

```env
REDIS_HOST=redis
```

If you don't find the `REDIS_HOST` variable in your `.env` file. Go to the database configuration file `config/database.php` and replace the default `127.0.0.1` IP with `redis` for Redis like this:

```php
'redis' => [
    'cluster' => false,
    'default' => [
        'host'     => 'redis',
        'port'     => 6379,
        'database' => 0,
    ],
],
```

3 - To enable Redis Caching and/or for Sessions Management. Also from the `.env` file set `CACHE_DRIVER` and `SESSION_DRIVER` to `redis` instead of the default `file`.

```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

4 - Finally make sure you have the `predis/predis` package `(~1.0)` installed via Composer:

```bash
composer require predis/predis:^1.0
```

5 - You can manually test it from Laravel with this code:

```php
\Cache::store('redis')->put('Laradock', 'Awesome', 10);
```






<br>
<a name="Use-Mongo"></a>
## Use Mongo

1 - First install `mongo` in the Workspace and the PHP-FPM Containers:
<br>
a) open the `docker-compose.yml` file
<br>
b) search for the `INSTALL_MONGO` argument under the Workspace Container
<br>
c) set it to `true`
<br>
d) search for the `INSTALL_MONGO` argument under the PHP-FPM Container
<br>
e) set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_MONGO=true
    ...
    php-fpm:
        build:
            context: ./php-fpm
            args:
                - INSTALL_MONGO=true
    ...
```

2 - Re-build the containers `docker-compose build workspace php-fpm`



3 - Run the MongoDB Container (`mongo`) with the `docker-compose up` command.

```bash
docker-compose up -d mongo
```


4 - Add the MongoDB configurations to the `config/database.php` configuration file:

```php
'connections' => [

    'mongodb' => [
        'driver'   => 'mongodb',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', 27017),
        'database' => env('DB_DATABASE', 'database'),
        'username' => '',
        'password' => '',
        'options'  => [
            'database' => '',
        ]
    ],

	// ...

],
```

5 - Open your Laravel's `.env` file and update the following variables:

- set the `DB_HOST` to your `mongo`.
- set the `DB_PORT` to `27017`.
- set the `DB_DATABASE` to `database`.


6 - Finally make sure you have the `jenssegers/mongodb` package installed via Composer and its Service Provider is added.

```bash
composer require jenssegers/mongodb
```
More details about this [here](https://github.com/jenssegers/laravel-mongodb#installation).

7 - Test it:

- First let your Models extend from the Mongo Eloquent Model. Check the [documentation](https://github.com/jenssegers/laravel-mongodb#eloquent).
- Enter the Workspace Container.
- Migrate the Database `php artisan migrate`.






<br>
<a name="Use-phpMyAdmin"></a>
## Use PhpMyAdmin

1 - Run the phpMyAdmin Container (`phpmyadmin`) with the `docker-compose up` command. Example:

```bash
# use with mysql
docker-compose up -d mysql phpmyadmin

# use with mariadb
docker-compose up -d mariadb phpmyadmin
```

*Note: To use with MariaDB, open `.env` and set `PMA_DB_ENGINE=mysql` to `PMA_DB_ENGINE=mariadb`.*

2 - Open your browser and visit the localhost on port **8080**:  `http://localhost:8080`






<br>
<a name="Use-Adminer"></a>
## Use Adminer

1 - Run the Adminer Container (`adminer`) with the `docker-compose up` command. Example:

```bash
docker-compose up -d adminer  
```

2 - Open your browser and visit the localhost on port **8080**:  `http://localhost:8080`

**Note:** We've locked Adminer to version 4.3.0 as at the time of writing [it contained a major bug](https://sourceforge.net/p/adminer/bugs-and-features/548/) preventing PostgreSQL users from logging in. If that bug is fixed (or if you're not using PostgreSQL) feel free to set Adminer to the latest version within [the Dockerfile](https://github.com/laradock/laradock/blob/master/adminer/Dockerfile#L1): `FROM adminer:latest`





<br>
<a name="Use-pgAdmin"></a>
## Use PgAdmin

1 - Run the pgAdmin Container (`pgadmin`) with the `docker-compose up` command. Example:

```bash
docker-compose up -d postgres pgadmin
```

2 - Open your browser and visit the localhost on port **5050**:  `http://localhost:5050`






<br>
<a name="Use-Beanstalkd"></a>
## Use Beanstalkd

1 - Run the Beanstalkd Container:

```bash
docker-compose up -d beanstalkd
```

2 - Configure Laravel to connect to that container by editing the `config/queue.php` config file.

a. first set `beanstalkd` as default queue driver
b. set the queue host to beanstalkd : `QUEUE_HOST=beanstalkd`

*beanstalkd is now available on default port `11300`.*

3 - Require the dependency package [pda/pheanstalk](https://github.com/pda/pheanstalk) using composer.


Optionally you can use the Beanstalkd Console Container to manage your Queues from a web interface.

1 - Run the Beanstalkd Console Container:

```bash
docker-compose up -d beanstalkd-console
```

2 - Open your browser and visit `http://localhost:2080/`

3 - Add the server

- Host: beanstalkd
- Port: 11300

4 - Done.






<br>
<a name="Use-ElasticSearch"></a>
## Use ElasticSearch

1 - Run the ElasticSearch Container (`elasticsearch`) with the `docker-compose up` command:

```bash
docker-compose up -d elasticsearch
```

2 - Open your browser and visit the localhost on port **9200**:  `http://localhost:9200`


### Install ElasticSearch Plugin

1 - Install the ElasticSearch plugin like [delete-by-query](https://www.elastic.co/guide/en/elasticsearch/plugins/current/plugins-delete-by-query.html).

```bash
docker exec {container-name} /usr/share/elasticsearch/bin/plugin install delete-by-query
```

2 - Restart elasticsearch container

```bash
docker restart {container-name}
```






<br>
<a name="Use-Selenium"></a>
## Use Selenium

1 - Run the Selenium Container (`selenium`) with the `docker-compose up` command. Example:

```bash
docker-compose up -d selenium
```

2 - Open your browser and visit the localhost on port **4444** at the following URL:  `http://localhost:4444/wd/hub`






<br>
<a name="Use-RethinkDB"></a>
## Use RethinkDB

The RethinkDB is an open-source Database for Real-time Web ([RethinkDB](https://rethinkdb.com/)).
A package ([Laravel RethinkDB](https://github.com/duxet/laravel-rethinkdb)) is being developed and was released a version for Laravel 5.2 (experimental).

1 - Run the RethinkDB Container (`rethinkdb`) with the `docker-compose up` command.

```bash
docker-compose up -d rethinkdb
```

2 - Access the RethinkDB Administration Console [http://localhost:8090/#tables](http://localhost:8090/#tables) for create a database called `database`.

3 - Add the RethinkDB configurations to the `config/database.php` configuration file:

```php
'connections' => [

	'rethinkdb' => [
		'name'      => 'rethinkdb',
		'driver'    => 'rethinkdb',
		'host'      => env('DB_HOST', 'rethinkdb'),
		'port'      => env('DB_PORT', 28015),
		'database'  => env('DB_DATABASE', 'test'),
	]

	// ...

],
```

4 - Open your Laravel's `.env` file and update the following variables:

- set the `DB_CONNECTION` to your `rethinkdb`.
- set the `DB_HOST` to `rethinkdb`.
- set the `DB_PORT` to `28015`.
- set the `DB_DATABASE` to `database`.


<br>
<a name="Use-Minio"></a>
## Use Minio

1 - Configure Minio:
  - On the workspace container, change `INSTALL_MC` to true to get the client
  - Set `MINIO_ACCESS_KEY` and `MINIO_ACCESS_SECRET` if you wish to set proper keys

2 - Run the Minio Container (`minio`) with the `docker-compose up` command. Example:

```bash
docker-compose up -d minio
```

3 - Open your browser and visit the localhost on port **9000** at the following URL:  `http://localhost:9000`

4 - Create a bucket either through the webui or using the mc client:
  ```bash
  mc mb minio/bucket
  ```

5 - When configuring your other clients use the following details:
  ```
  S3_HOST=http://minio
  S3_KEY=access
  S3_SECRET=secretkey
  S3_REGION=us-east-1
  S3_BUCKET=bucket
  ```


<br>
<a name="CodeIgniter"></a>






<br>
<a name="Install-CodeIgniter"></a>
## Install CodeIgniter

To install CodeIgniter 3 on Laradock all you have to do is the following simple steps:

1 - Open the `docker-compose.yml` file.

2 - Change `CODEIGNITER=false` to `CODEIGNITER=true`.

3 - Re-build your PHP-FPM Container `docker-compose build php-fpm`.






<br>
<a name="Misc"></a>
## Miscellaneous






<br>
<a name="Change-the-timezone"></a>
## Change the timezone

To change the timezone for the `workspace` container, modify the `TZ` build argument in the Docker Compose file to one in the [TZ database](https://en.wikipedia.org/wiki/List_of_tz_database_time_zones).

For example, if I want the timezone to be `New York`:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - TZ=America/New_York
    ...
```

We also recommend [setting the timezone in Laravel](http://www.camroncade.com/managing-timezones-with-laravel/).






<br>
<a name="CronJobs"></a>
## Adding cron jobs

You can add your cron jobs to `workspace/crontab/root` after the `php artisan` line.

```
* * * * * php /var/www/artisan schedule:run >> /dev/null 2>&1

# Custom cron
* * * * * root echo "Every Minute" > /var/log/cron.log 2>&1
```

Make sure you [change the timezone](#Change-the-timezone) if you don't want to use the default (UTC).






<br>
<a name="Workspace-ssh"></a>
## Access workspace via ssh

You can access the `workspace` container through `localhost:2222` by setting the `INSTALL_WORKSPACE_SSH` build argument to `true`.

To change the default forwarded port for ssh:

```yml
    workspace:
		ports:
			- "2222:22" # Edit this line
    ...
```






<br>
<a name="MySQL-access-from-host"></a>
## MySQL access from host

You can forward the MySQL/MariaDB port to your host by making sure these lines are added to the `mysql` or `mariadb` section of the `docker-compose.yml` or in your [environment specific Compose](https://docs.docker.com/compose/extends/) file.

```
ports:
    - "3306:3306"
```






<br>
<a name="MySQL-root-access"></a>
## MySQL root access

The default username and password for the root MySQL user are `root` and `root `.

1 - Enter the MySQL container: `docker-compose exec mysql bash`.

2 - Enter mysql: `mysql -uroot -proot` for non root access use `mysql -uhomestead -psecret`.

3 - See all users: `SELECT User FROM mysql.user;`

4 - Run any commands `show databases`, `show tables`, `select * from.....`.






<br>
<a name="Change-MySQL-port"></a>
## Change MySQL port

Modify the `mysql/my.cnf` file to set your port number, `1234` is used as an example.

```
[mysqld]
port=1234
```

If you need <a href="#MySQL-access-from-host">MySQL access from your host</a>, do not forget to change the internal port number (`"3306:3306"` -> `"3306:1234"`) in the docker-compose configuration file.






<br>
<a name="Use-custom-Domain"></a>
## Use custom Domain (instead of the Docker IP)

Assuming your custom domain is `laravel.dev`

1 - Open your `/etc/hosts` file and map your localhost address `127.0.0.1` to the `laravel.dev` domain, by adding the following:

```bash
127.0.0.1    laravel.dev
```

2 - Open your browser and visit `{http://laravel.dev}`


Optionally you can define the server name in the NGINX configuration file, like this:

```conf
server_name laravel.dev;
```






<br>
<a name="Enable-Global-Composer-Build-Install"></a>
## Enable Global Composer Build Install

Enabling Global Composer Install during the build for the container allows you to get your composer requirements installed and available in the container after the build is done.

1 - Open the `docker-compose.yml` file

2 - Search for the `COMPOSER_GLOBAL_INSTALL` argument under the Workspace Container and set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - COMPOSER_GLOBAL_INSTALL=true
    ...
```
3 - Now add your dependencies to `workspace/composer.json`

4 - Re-build the Workspace Container `docker-compose build workspace`






<br>
<a name="Install-Prestissimo"></a>
## Install Prestissimo

[Prestissimo](https://github.com/hirak/prestissimo) is a plugin for composer which enables parallel install functionality.

1 - Enable Running Global Composer Install during the Build:

Click on this [Enable Global Composer Build Install](#Enable-Global-Composer-Build-Install) and do steps 1 and 2 only then continue here.

2 - Add prestissimo as requirement in Composer:

a - Now open the `workspace/composer.json` file

b - Add `"hirak/prestissimo": "^0.3"` as requirement

c - Re-build the Workspace Container `docker-compose build workspace`






<br>
<a name="Install-Node"></a>
## Install Node + NVM

To install NVM and NodeJS in the Workspace container

1 - Open the `docker-compose.yml` file

2 - Search for the `INSTALL_NODE` argument under the Workspace Container and set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_NODE=true
    ...
```

3 - Re-build the container `docker-compose build workspace`






<br>
<a name="Install-Yarn"></a>
## Install Node + YARN

Yarn is a new package manager for JavaScript. It is so faster than npm, which you can find [here](http://yarnpkg.com/en/compare).To install NodeJS and [Yarn](https://yarnpkg.com/) in the Workspace container:

1 - Open the `docker-compose.yml` file

2 - Search for the `INSTALL_NODE` and `INSTALL_YARN` argument under the Workspace Container and set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_NODE=true
                - INSTALL_YARN=true
    ...
```

3 - Re-build the container `docker-compose build workspace`






<br>
<a name="Install-Linuxbrew"></a>
## Install Linuxbrew

Linuxbrew is a package manager for Linux. It is the Linux version of MacOS Homebrew and can be found [here](http://linuxbrew.sh). To install Linuxbrew in the Workspace container:

1 - Open the `docker-compose.yml` file

2 - Search for the `INSTALL_LINUXBREW` argument under the Workspace Container and set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_LINUXBREW=true
    ...
```

3 - Re-build the container `docker-compose build workspace`





<br>
<a name="Common-Aliases"></a>
<br>
## Common Terminal Aliases
When you start your docker container, Laradock will copy the `aliases.sh` file located in the `laradock/workspace` directory and add sourcing to the container `~/.bashrc` file.

You are free to modify the `aliases.sh` as you see fit, adding your own aliases (or function macros) to suit your requirements.





<br>
<a name="Install-Aerospike-Extension"></a>
## Install Aerospike extension

1 - First install `aerospike` in the Workspace and the PHP-FPM Containers:
<br>
a) open the `docker-compose.yml` file
<br>
b) search for the `INSTALL_AEROSPIKE` argument under the Workspace Container
<br>
c) set it to `true`
<br>
d) search for the `INSTALL_AEROSPIKE` argument under the PHP-FPM Container
<br>
e) set it to `true`

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_AEROSPIKE=true
    ...
    php-fpm:
        build:
            context: ./php-fpm
            args:
                - INSTALL_AEROSPIKE=true
    ...
```

2 - Re-build the containers `docker-compose build workspace php-fpm`






<br>
<a name="Install-Laravel-Envoy"></a>
## Install Laravel Envoy (Envoy Task Runner)

1 - Open the `docker-compose.yml` file
<br>
2 - Search for the `INSTALL_LARAVEL_ENVOY` argument under the Workspace Container
<br>
3 - Set it to `true`
<br>

It should be like this:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_LARAVEL_ENVOY=true
    ...
```

4 - Re-build the containers `docker-compose build workspace`

[**Laravel Envoy Documentation Here**](https://laravel.com/docs/5.3/envoy)







<br>
<a name="phpstorm-debugging"></a>
## PHPStorm Debugging Guide
Remote debug Laravel web and phpunit tests.

[**Debugging Guide Here**](https://github.com/laradock/laradock/blob/master/_guides/phpstorm.md)







<br>
<a name="keep-tracking-Laradock"></a>
## Keep track of your Laradock changes

1. Fork the Laradock repository.
2. Use that fork as a submodule.
3. Commit all your changes to your fork.
4. Pull new stuff from the main repository from time to time.







<br>
<a name="upgrading-laradock"></a>
## Upgrading Laradock

Moving from Docker Toolbox (VirtualBox) to Docker Native (for Mac/Windows). Requires upgrading Laradock from v3.* to v4.*:

1. Stop the docker VM `docker-machine stop {default}`
2. Install Docker for [Mac](https://docs.docker.com/docker-for-mac/) or [Windows](https://docs.docker.com/docker-for-windows/).
3. Upgrade Laradock to `v4.*.*` (`git pull origin master`)
4. Use Laradock as you used to do: `docker-compose up -d nginx mysql`.

**Note:** If you face any problem with the last step above: rebuild all your containers
`docker-compose build --no-cache`
"Warning Containers Data might be lost!"









<br>
<a name="Speed-MacOS"></a>
## Improve speed on MacOS

Sharing code into Docker containers with osxfs have very poor performance compared to Linux. Likely there are some workarounds:

### Workaround A: using dinghy

[Dinghy](https://github.com/codekitchen/dinghy) creates its own VM using docker-machine, it will not modify your existing docker-machine VMs.

Quick Setup giude, (we recommend you check their docs)

1) `brew tap codekitchen/dinghy`

2) `brew install dinghy`

3) `dinghy create --provider virtualbox` (must have virtualbox installed, but they support other providers if you prefer)

4) after the above command is done it will display some env variables, copy them to the bash profile or zsh or.. (this will instruct docker to use the server running inside the VM)

5) `docker-compose up ...`




### Workaround B: using d4m-nfs

[D4m-nfs](https://github.com/IFSight/d4m-nfs) automatically mount NFS volume instead of osxfs one.

1) Update the Docker [File Sharing] preferences:

Click on the Docker Icon > Preferences > (remove everything form the list except `/tmp`).

2) Restart Docker.

3) Clone the [d4m-nfs](https://github.com/IFSight/d4m-nfs) repository to your `home` directory.

```bash
git clone https://github.com/IFSight/d4m-nfs ~/d4m-nfs
```

4) Create (or edit) the file `~/d4m-nfs/etc/d4m-nfs-mounts.txt`, and write the follwing configuration in it:

```txt
/Users:/Users
```

5) Create (or edit) the file `/etc/exports`, make sure it exists and is empty. (There may be collisions if you come from Vagrant or if you already executed the `d4m-nfs.sh` script before).


6) Run the `d4m-nfs.sh` script (might need Sudo):

```bash
~/d4m-nfs/d4m-nfs.sh
```

That's it! Run your containers.. Example:

```bash
docker-compose up ...
```

*Note: If you faced any errors, try restarting Docker, and make sure you have no spaces in the `d4m-nfs-mounts.txt` file, and your `/etc/exports` file is clear.*



### Other good workarounds:

- [docker-sync](https://github.com/EugenMayer/docker-sync)
- Add more here..




More details about this issue [here](https://github.com/docker/for-mac/issues/77).











<br>
<a name="Common-Problems"></a>
## Common Problems

*Here's a list of the common problems you might face, and the possible solutions.*







<br>
## I see a blank (white) page instead of the Laravel 'Welcome' page!

Run the following command from the Laravel root directory:

```bash
sudo chmod -R 777 storage bootstrap/cache
```





<br>
## I see "Welcome to nginx" instead of the Laravel App!

Use `http://127.0.0.1` instead of `http://localhost` in your browser.





<br>
## I see an error message containing `address already in use` or `port is already allocated`

Make sure the ports for the services that you are trying to run (22, 80, 443, 3306, etc.) are not being used already by other programs on the host, such as a built in `apache`/`httpd` service or other development tools you have installed.





<br>
## I get NGINX error 404 Not Found on Windows.

1. Go to docker Settings on your Windows machine.
2. Click on the `Shared Drives` tab and check the drive that contains your project files.
3. Enter your windows username and password.
4. Go to the `reset` tab and click restart docker.





<br>
## The time in my services does not match the current time

1. Make sure you've [changed the timezone](#Change-the-timezone).
2. Stop and rebuild the containers (`docker-compose up -d --build <services>`)





<br>
## I get MySQL connection refused

This error sometimes happens because your Laravel application isn't running on the container localhost IP (Which is 127.0.0.1). Steps to fix it:

* Option A
  1. Check your running Laravel application IP by dumping `Request::ip()` variable using `dd(Request::ip())` anywhere on your application. The result is the IP of your Laravel container.
  2. Change the `DB_HOST` variable on env with the IP that you received from previous step.
* Option B
   1. Change the `DB_HOST` value to the same name as the MySQL docker container. The Laradock docker-compose file currently has this as `mysql`
