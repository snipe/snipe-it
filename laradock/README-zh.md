# Laradock

[![forthebadge](http://forthebadge.com/images/badges/built-by-developers.svg)](http://zalt.me)

[![Gitter](https://badges.gitter.im/Laradock/laradock.svg)](https://gitter.im/Laradock/laradock?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

Laradock 能够帮你在 **Docker** 上快速搭建 **Laravel** 应用。

就像 Laravel Homestead 一样，但是 Docker 替换了 Vagrant。

> 先在使用 Laradock，然后再学习它们。

## 目录
- [Intro](#Intro)
	- [Features](#features)
	- [Supported Software's](#Supported-Containers)
	- [What is Docker](#what-is-docker)
	- [What is Laravel](#what-is-laravel)
	- [Why Docker not Vagrant](#why-docker-not-vagrant)
	- [Laradock VS Homestead](#laradock-vs-homestead)
- [Demo Video](#Demo)
- [Requirements](#Requirements)
- [Installation](#Installation)
- [Usage](#Usage)
- [Documentation](#Documentation)
	- [Docker](#Docker)
		- [List current running Containers](#List-current-running-Containers)
		- [Close all running Containers](#Close-all-running-Containers)
		- [Delete all existing Containers](#Delete-all-existing-Containers)
		- [Enter a Container (SSH into a running Container)](#Enter-Container)
		- [Edit default container configuration](#Edit-Container)
		- [Edit a Docker Image](#Edit-a-Docker-Image)
		- [Build/Re-build Containers](#Build-Re-build-Containers)
		- [Add more Software's (Docker Images)](#Add-Docker-Images)
		- [View the Log files](#View-the-Log-files)
	- [Laravel](#Laravel):
		- [Install Laravel from a Docker Container](#Install-Laravel)
		- [Run Artisan Commands](#Run-Artisan-Commands)
		- [Use Redis](#Use-Redis)
		- [Use Mongo](#Use-Mongo)
	- [PHP](#PHP)
		- [Install PHP Extensions](#Install-PHP-Extensions)
		- [Change the PHP-FPM Version](#Change-the-PHP-FPM-Version)
		- [Change the PHP-CLI Version](#Change-the-PHP-CLI-Version)
		- [Install xDebug](#Install-xDebug)
	- [Misc](#Misc)
		- [Use custom Domain](#Use-custom-Domain)
		- [Enable Global Composer Build Install](#Enable-Global-Composer-Build-Install)
		- [Install Prestissimo](#Install-Prestissimo)
		- [Install Node + NVM](#Install-Node)
		- [Debugging](#debugging)
		- [Upgrading Laradock](#upgrading-laradock)
- [Help & Questions](#Help)


<a name="Intro"></a>
## 介绍

Laradock 努力简化创建开发环境过程。
它包含预包装 Docker 镜像，提供你一个美妙的开发环境而不需要安装 PHP, NGINX, MySQL 和其他任何软件在你本地机器上。

**使用概览：**

让我们了解使用它安装 `NGINX`, `PHP`, `Composer`, `MySQL` 和 `Redis`，然后运行 `Laravel`

1. 将 Laradock 放到你的 Laravel 项目中：
```bash
git clone https://github.com/laradock/laradock.git
```

2. 进入 Laradock 目录
 ```bash
cp env-example .env
```

3. 运行这些容器。
```bash
docker-compose up -d nginx mysql redis
```

4. 打开你的Laravel 项目的 `.env` 文件，然后设置 `mysql` 的 `DB_HOST` 和  `redis` 的`REDIS_HOST`。

5. 打开浏览器，访问 localhost：

<a name="features"></a>
### 特点

- 在 PHP 版本：7.0，5.6.5.5...之中可以简单切换。
- 可选择你最喜欢的数据库引擎，比如：MySQL, Postgres, MariaDB...
- 可运行自己的软件组合，比如：Memcached, HHVM, Beanstalkd...
- 所有软件运行在不同的容器之中，比如：PHP-FPM, NGINX, PHP-CLI...
- 通过简单的编写 `Dockerfile` 容易定制任何容器。
- 所有镜像继承自一个官方基础镜像（Trusted base Images）
- 可预配置Laravel的Nginx环境
- 容易应用容器中的配置 配置文件（`Dockerfile`）
- 最新的 Docker Compose 版本（`docker-compose`）
- 所有的都是可视化和可编辑的
- 快速的镜像构建
- 每周都会有更新...

<a name="Supported-Containers"></a>
### 支持的软件 (容器)

- **数据库引擎:**
	- MySQL
	- PostgreSQL
	- MariaDB
	- MongoDB
	- Neo4j
- **缓存引擎:**
	- Redis
	- Memcached
- **PHP 服务器:**
	- NGINX
	- Apache2
	- Caddy
- **PHP 编译工具:**
	- PHP-FPM
	- HHVM
- **消息队列系统:**
	- Beanstalkd (+ Beanstalkd Console)
- **工具:**
	- Workspace (PHP7-CLI, Composer, Git, Node, Gulp, SQLite, Vim, Nano, cURL...)

>如果你找不到你需要的软件，构建它然后把它添加到这个列表。你的贡献是受欢迎的。

<a name="what-is-docker"></a>
### Docker 是什么?

[Docker](https://www.docker.com) 是一个开源项目,自动化部署应用程序软件的容器,在 Linux, Mac OS and Windows 提供一个额外的抽象层和自动化的[操作系统级的虚拟化](https://en.wikipedia.org/wiki/Operating-system-level_virtualization)

<a name="what-is-laravel"></a>
### Laravel 是什么?

额，这很认真的!!!

<a name="why-docker-not-vagrant"></a>
### 为什么使用 Docker 而不是 Vagrant!?

[Vagrant](https://www.vagrantup.com) 构建虚拟机需要几分钟然而 Docker 构建虚拟容器只需要几秒钟。
而不是提供一个完整的虚拟机,就像你用 Vagrant, Docker 为您提供**轻量级**虚拟容器,共享相同的内核和允许安全执行独立的进程。

除了速度, Docker 提供大量的 Vagrant 无法实现的功能。

最重要的是 Docker 可以运行在开发和生产(相同环境无处不在)。Vagrant 是专为开发,(所以在生产环境你必须每一次重建您的服务器)。

<a name="laradock-vs-homestead"></a>
### Laradock Homestead 对比

Laradock and [Homestead](https://laravel.com/docs/master/homestead) 给你一个完整的虚拟开发环境。(不需要安装和配置软件在你自己的每一个操作系统)。

Homestead 是一个工具,为你控制虚拟机(使用 Homestead 特殊命令)。Vagrant 可以管理你的管理虚容器。

运行一个虚拟容器比运行一整个虚拟机快多了 **Laradock 比 Homestead 快多了**

<a name="Demo"></a>
## 演示视频
还有什么比**演示视频**好：

- Laradock [v4.0](https://www.youtube.com/watch?v=TQii1jDa96Y)
- Laradock [v2.2](https://www.youtube.com/watch?v=-DamFMczwDA)
- Laradock [v0.3](https://www.youtube.com/watch?v=jGkyO6Is_aI)
- Laradock [v0.1](https://www.youtube.com/watch?v=3YQsHe6oF80)

<a name="Requirements"></a>
## 依赖

- [Git](https://git-scm.com/downloads)       
- [Docker](https://www.docker.com/products/docker/)

<a name="Installation"></a>
## 安装

1 - 克隆 `Laradock` 仓库:

**A)** 如果你已经有一个 Laravel 项目,克隆这个仓库在到 `Laravel` 根目录

```bash
git submodule add https://github.com/laradock/laradock.git
```

>如果你不是使用 Git 管理 Laravel 项目,您可以使用 `git clone` 而不是 `git submodule`。

**B)** 如果你没有一个 Laravel 项目,你想 Docker 安装 Laravel,克隆这个源在您的机器任何地方上:

```bash
git clone https://github.com/laradock/laradock.git
```

<a name="Usage"></a>
## 使用

**请在开始之前阅读:**
如果你正在使用 **Docker Toolbox** (VM)，选择以下任何一个方法：
- 更新到 Docker [Native](https://www.docker.com/products/docker) Mac/Windows 版本 (建议). 查看 [Upgrading Laradock](#upgrading-laradock)
- 使用 Laradock v3.* (访问 `Laradock-ToolBox` [分支](https://github.com/laradock/laradock/tree/Laradock-ToolBox)).
如果您使用的是 **Docker Native**(Mac / Windows 版本)甚至是 Linux 版本,通常可以继续阅读这个文档，Laradock v4 以上版本将仅支持 **Docker Native**。

1 - 运行容器: *(在运行 `docker-compose` 命令之前，确认你在 `laradock` 目录中*

**例子:** 运行 NGINX 和 MySQL:

```bash
docker-compose up -d  nginx mysql
```
你可以从以下列表选择你自己的容器组合：

`nginx`, `hhvm`, `php-fpm`, `mysql`, `redis`, `postgres`, `mariadb`, `neo4j`, `mongo`, `apache2`, `caddy`, `memcached`, `beanstalkd`, `beanstalkd-console`, `workspace`.

**说明**: `workspace` 和 `php-fpm` 将运行在大部分实例中, 所以不需要在 `up` 命令中加上它们.

2 - 进入 Workspace 容器, 执行像 (Artisan, Composer, PHPUnit, Gulp, ...)等命令

```bash
docker-compose exec workspace bash
```

增加 `--user=laradock` (例如 `docker-compose exec --user=laradock workspace bash`) 作为您的主机的用户创建的文件. (你可以从 `docker-compose.yml`修改 PUID (User id) 和 PGID (group id) 值 ).

3 - 编辑 Laravel 的配置.

如果你还没有安装 Laravel 项目，请查看 [How to Install Laravel in a Docker Container](#Install-Laravel).

打开 Laravel 的 `.env` 文件 然后 配置 你的 `mysql` 的 `DB_HOST`:

```env
DB_HOST=mysql
```

4 - 打开浏览器访问 localhost (`http://localhost/`).

**调试**: 如果你碰到任何问题，请查看 [调试](#debugging) 章节
如果你需要特别支持，请联系我，更多细节在[帮助 & 问题](#Help)章节

<a name="Documentation"></a>
## 文档

<a name="Docker"></a>
### [Docker]

<a name="List-current-running-Containers"></a>
### 列出正在运行的容器
```bash
docker ps
```

你也可以使用以下命令查看某项目的容器
```bash
docker-compose ps
```

<a name="Close-all-running-Containers"></a>
### 关闭所有容器
```bash
docker-compose stop
```

停止某个容器:

```bash
docker-compose stop {容器名称}
```

<a name="Delete-all-existing-Containers"></a>
### 删除所有容器
```bash
docker-compose down
```

小心这个命令,因为它也会删除你的数据容器。(如果你想保留你的数据你应该在上述命令后列出容器名称删除每个容器本身):*

<a name="Enter-Container"></a>
### 进入容器 (通过 SSH 进入一个运行中的容器)

1 - 首先使用 `docker ps` 命令查看正在运行的容器

2 - 进入某个容器使用:

```bash
docker-compose exec {container-name} bash
```

*例如: 进入 MySQL 容器*

```bash
docker-compose exec mysql bash
```

3 - 退出容器, 键入 `exit`.


<a name="Edit-Container"></a>
### 编辑默认容器配置
打开 `docker-compose.yml` 然后 按照你想的修改.

例如:

修改 MySQL 数据库名称:

```yml
  environment:
    MYSQL_DATABASE: laradock
```

修改 Redis 默认端口为 1111:

```yml
  ports:
    - "1111:6379"
```

<a name="Edit-a-Docker-Image"></a>
### 编辑 Docker 镜像

1 - 找到你想修改的镜像的 `Dockerfile` ,
<br>
例如： `mysql` 在 `mysql/Dockerfile`.

2 - 按你所要的编辑文件.

3 - 重新构建容器:

```bash
docker-compose build mysql
```

更多信息在容器重建中[点击这里](#Build-Re-build-Containers).

<a name="Build-Re-build-Containers"></a>
### 建立/重建容器

如果你做任何改变 `Dockerfile` 确保你运行这个命令,可以让所有修改更改生效:

```bash
docker-compose build
```

选择你可以指定哪个容器重建(而不是重建所有的容器):

```bash
docker-compose build {container-name}
```

如果你想重建整个容器，你可能需要使用 `--no-cache` 选项  (`docker-compose build --no-cache {container-name}`).

<a name="Add-Docker-Images"></a>
### 增加更多软件 (Docker 镜像)

为了增加镜像（软件）, 编辑 `docker-compose.yml` 添加容器细节， 你需要熟悉 [docker compose 文件语法](https://docs.docker.com/compose/compose-file/).

<a name="View-the-Log-files"></a>
### 查看日志文件
Nginx的日志在 `logs/nginx` 目录

然后查看其它容器日志(MySQL, PHP-FPM,...) 你可以运行:

```bash
docker logs {container-name}
```

<a name="Laravel"></a>
### [Laravel]

<a name="Install-Laravel"></a>
### 从 Docker 镜像安装 Laravel

1 - 首先你需要进入 Workspace 容器.

2 - 安装 Laravel.

例如 使用 Composer

```bash
composer create-project laravel/laravel my-cool-app "5.2.*"
```

> 我们建议使用 `composer create-project` 替换 Laravel 安装器去安装 Laravel.

关于更多 Laravel 安装内容请 [点击这儿](https://laravel.com/docs/master#installing-laravel).


3 - 编辑 `docker-compose.yml` 映射新的应用目录:
系统默认 Laradock 假定 Laravel 应用在 laradock 的父级目录中

更新 Laravel 应用在 `my-cool-app` 目录中, 我们需要用 `../my-cool-app/:/var/www`替换 `../:/var/www` , 如下:

```yaml
    application:
        build: ./application
        volumes:
            - ../my-cool-app/:/var/www
```

4 - 进入目录下继续工作..

```bash
cd my-cool-app
```

5 - 回到 Laradock 安装步骤,看看如何编辑 `.env` 的文件。

<a name="Run-Artisan-Commands"></a>
### 运行 Artisan 命令

你可以从 Workspace 容器运行 artisan 命令和其他终端命令

1 - 确认 Workspace 容器已经运行.

```bash
docker-compose up -d workspace // ..and all your other containers
```

2 - 找到 Workspace 容器名称:

```bash
docker-compose ps
```

3 - 进入 Workspace 容器:

```bash
docker-compose exec workspace bash
```

增加 `--user=laradock` (例如 `docker-compose exec --user=laradock workspace bash`) 作为您的主机的用户创建的文件.

4 - 运行任何你想的 :)

```bash
php artisan
```
```bash
composer update
```
```bash
phpunit
```

<a name="Use-Redis"></a>
### 使用 Redis
1 - 首先务必用 `docker-compose up` 命令运行 (`redis`) 容器.

```bash
docker-compose up -d redis
```

2 - 打开你的Laravel的 `.env` 文件 然后 配置 `redis` 的 `REDIS_HOST`

```env
REDIS_HOST=redis
```

如果在你的 `.env` 文件没有找到 `REDIS_HOST` 变量。打开数据库配置文件 `config/database.php` 然后用 `redis` 替换默认 IP `127.0.0.1`，例如：


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

3 - 启用 Redis 缓存或者开启 Session 管理也在 `.env` 文件中用 `redis` 替换默认 `file` 设置 `CACHE_DRIVER` 和 `SESSION_DRIVER`

```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

4 - 最好务必通过 Composer 安装 `predis/predis` 包 `(~1.0)`:

```bash
composer require predis/predis:^1.0
```

5 - 你可以用以下代码在 Laravel 中手动测试：

```php
\Cache::store('redis')->put('Laradock', 'Awesome', 10);
```

<a name="Use-Mongo"></a>
### 使用 Mongo

1 - 首先在 Workspace 和 PHP-FPM 容器中安装 `mongo`:

    a) 打开 `docker-compose.yml` 文件
    b) 在 Workspace 容器中找到 `INSTALL_MONGO` 选项：
    c) 设置为 `true`
    d) 在 PHP-FPM 容器中找到 `INSTALL_MONGO`
    e) 设置为 `true`

相关配置项如下:

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

2 - 重建 `Workspace、PHP-FPM` 容器

```bash
docker-compose build workspace php-fpm
```

3 - 使用 `docker-compose up` 命令运行 MongoDB 容器 (`mongo`)

```bash
docker-compose up -d mongo
```

4 - 在 `config/database.php` 文件添加 MongoDB 的配置项:

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

5 - 打开 Laravel 的 `.env` 文件然后更新以下字段:

- 设置 `DB_HOST` 为 `mongo` 的主机 IP.
- 设置 `DB_PORT` 为 `27017`.
- 设置 `DB_DATABASE` 为 `database`.


6 - 最后务必通过 Composer 安装 `jenssegers/mongodb` 包，添加服务提供者（Laravel Service Provider）


```bash
composer require jenssegers/mongodb
```

更多细节内容 [点击这儿](https://github.com/jenssegers/laravel-mongodb#installation).

7 - 测试:

- 首先让你的模型继承 Mongo 的 Eloquent Model. 查看 [文档](https://github.com/jenssegers/laravel-mongodb#eloquent).
- 进入 Workspace 容器.
- 迁移数据库 `php artisan migrate`.

<a name="PHP"></a>
### [PHP]

<a name="Install-PHP-Extensions"></a>
### 安装 PHP 拓展

安装 PHP 扩展之前,你必须决定你是否需要 `FPM` 或 `CLI`,因为他们安装在不同的容器上,如果你需要两者,则必须编辑两个容器。

PHP-FPM 拓展务必安装在 `php-fpm/Dockerfile-XX`. *(用你 PHP 版本号替换 XX)*.

PHP-CLI 拓展应该安装到 `workspace/Dockerfile`.

<a name="Change-the-PHP-FPM-Version"></a>
### 修改 PHP-FPM 版本
默认运行 **PHP-FPM 7.0** 版本.

>PHP-FPM 负责服务你的应用代码,如果你是计划运行您的应用程序在不同 PHP-FPM 版本上，则不需要更改 PHP-CLI 版本。

#### A) 切换版本 PHP `7.0` 到 PHP `5.6`

1 - 打开 `docker-compose.yml`。

2 - 在PHP容器的 `Dockerfile-70` 文件。

3 - 修改版本号, 用 `Dockerfile-56` 替换 `Dockerfile-70` , 例如:

```txt
php-fpm:
    build:
        context: ./php-fpm
        dockerfile: Dockerfile-70
```

4 - 最后重建PHP容器

```bash
docker-compose build php
```

> 更多关于PHP基础镜像, 请访问 [PHP Docker官方镜像](https://hub.docker.com/_/php/).


#### B) 切换版本 PHP `7.0` 或 `5.6` 到 PHP `5.5`
我们已不在本地支持 PHP5.5，但是你按照以下步骤获取：

1 - 克隆 `https://github.com/laradock/php-fpm`.

2 - 重命名 `Dockerfile-56` 为 `Dockerfile-55`.

3 - 编辑文件 `FROM php:5.6-fpm` 为 `FROM php:5.5-fpm`.

4 - 从 `Dockerfile-55` 构建镜像.

5 - 打开 `docker-compose.yml` 文件.

6 - 将 `php-fpm` 指向你的 `Dockerfile-55` 文件.


<a name="Change-the-PHP-CLI-Version"></a>
### 修改 PHP-CLI 版本
默认运行 **PHP-CLI 7.0** 版本

>说明: PHP-CLI 只用于执行 Artisan 和 Composer 命令，不服务于你的应用代码，这是 PHP-FPM 的工作，所以编辑 PHP-CLI 的版本不是很重要。
PHP-CLI 安装在 Workspace 容器，改变 PHP-CLI 版本你需要编辑 `workspace/Dockerfile`.
现在你必须手动修改 PHP-FPM 的 `Dockerfile` 或者创建一个新的。 (可以考虑贡献功能).

<a name="Install-xDebug"></a>
### 安装 xDebug

1 - 首先在 Workspace 和 PHP-FPM 容器安装 `xDebug`:

    a) 打开 `docker-compose.yml` 文件
    b) 在 Workspace 容器中找到 `INSTALL_XDEBUG` 选项
    c) 改为 `true`
    d) 在 PHP-FPM 容器中找到 `INSTALL_XDEBUG ` 选项
    e) 改为 `true`

例如:

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

2 - 重建容器 `docker-compose build workspace php-fpm`

<a name="Misc"></a>
### [Misc]

<a name="Use-custom-Domain"></a>
### 使用自定义域名 (替换 Docker 的 IP)

假定你的自定义域名是 `laravel.dev`

1 - 打开 `/etc/hosts` 文件添加以下内容，映射你的 localhost 地址 `127.0.0.1` 为 `laravel.dev` 域名
```bash
127.0.0.1    laravel.dev
```

2 - 打开你的浏览器访问 `{http://laravel.dev}`

你可以在 nginx 配置文件自定义服务器名称,如下:

```conf
server_name laravel.dev;
```

<a name="Enable-Global-Composer-Build-Install"></a>
### 安装全局 Composer 命令

为启用全局 Composer Install 在容器构建中允许你安装 composer 的依赖，然后构建完成后就是可用的。

1 - 打开 `docker-compose.yml` 文件

2 - 在 Workspace 容器找到 `COMPOSER_GLOBAL_INSTALL` 选项并设置为 `true`

例如:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - COMPOSER_GLOBAL_INSTALL=true
    ...
```
3 - 现在特价你的依赖关系到 `workspace/composer.json`

4 - 重建 Workspace 容器 `docker-compose build workspace`

<a name="Install-Prestissimo"></a>
### 安装 Prestissimo

[Prestissimo](https://github.com/hirak/prestissimo) 是一个平行安装功能的 composer 插件。

1 - 在安装期间，使全局 Composer Install 正在运行:

    点击这个 [启用全局 Composer 构建安装](#Enable-Global-Composer-Build-Install) 然后继续步骤1、2.

2 - 添加 prestissimo 依赖到 Composer:

a - 现在打开 `workspace/composer.json` 文件

b - 添加 `"hirak/prestissimo": "^0.3"` 依赖

c - 重建 Workspace 容器 `docker-compose build workspace`


<a name="Install-Node"></a>
### 安装 Node + NVM

在 Workspace 容器安装 NVM 和 NodeJS

1 - 打开 `docker-compose.yml` 文件

2 - 在 Workspace 容器找到 `INSTALL_NODE` 选项设为 `true`

例如:

```yml
    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_NODE=true
    ...
```

3 - 重建容器 `docker-compose build workspace`

<a name="debugging"></a>
### Debugging

*这里是你可能面临的常见问题列表,以及可能的解决方案.*

#### 看到空白页而不是 Laravel 的欢迎页面!

在 Laravel 根目录，运行下列命令:

```bash
sudo chmod -R 777 storage bootstrap/cache
```

#### 看到 "Welcome to nginx" 而不是 Laravel 应用!

在浏览器使用 `http://127.0.0.1` 替换 `http://localhost`.

#### 看到包含 `address already in use` 的错误

确保你想运行的服务端口(80, 3306, etc.)不是已经被其他程序使用，例如 `apache`/`httpd` 服务或其他安装的开发工具

<a name="upgrading-laradock"></a>
### Laradock 升级


从 Docker Toolbox (VirtualBox) 移动到 Docker Native (for Mac/Windows)，需要从 Laradock v3.* 升级到 v4.*:

1. 停止 Docker 虚拟机 `docker-machine stop {default}`
2. 安装 Docker [Mac](https://docs.docker.com/docker-for-mac/) 或 [Windows](https://docs.docker.com/docker-for-windows/).
3. 升级 Laradock 到 `v4.*.*` (`git pull origin master`)
4. 像之前一样使用 Laradock: `docker-compose up -d nginx mysql`.

**说明:** 如果你面临任何上面的问题的最后一步:重建你所有的容器
```bash
docker-compose build --no-cache
```
"警告：容器数据可能会丢失!"


## 贡献
这个小项目是由一个有一个全职工作和很多的职责的人建立的,所以如果你喜欢这个项目,并且发现它需要一个 bug 修复或支持或新软件或升级任何容器,或其他任何. . 你是非常欢迎，欢迎毫不不犹豫地贡献吧:)

#### 阅读我们的 [贡献说明](https://github.com/laradock/laradock/blob/master/CONTRIBUTING.md)

<a name="Help"></a>
## 帮助 & 问题

从聊天室 [Gitter](https://gitter.im/Laradock/laradock) 社区获取帮助和支持.

你也可以打开 Github 上的 [issue](https://github.com/laradock/laradock/issues) (将被贴上问题和答案) 或与大家讨论 [Gitter](https://gitter.im/Laradock/laradock).

Docker 或 Laravel 的特别帮助，你可以在 [Codementor.io](https://www.codementor.io/mahmoudz) 上直接和项目创始人在线沟通

## 关于作者

**创始人:**

- [Mahmoud Zalt](https://github.com/Mahmoudz)  (Twitter [@Mahmoud_Zalt](https://twitter.com/Mahmoud_Zalt))

**优秀的人:**

- [Contributors](https://github.com/laradock/laradock/graphs/contributors)
- [Supporters](https://github.com/laradock/laradock/issues?utf8=%E2%9C%93&q=)


## 许可证

[MIT License](https://github.com/laradock/laradock/blob/master/LICENSE) (MIT)
