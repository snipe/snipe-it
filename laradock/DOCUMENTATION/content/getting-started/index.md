---
title: Getting Started
type: index
weight: 2
---

## Requirements

- [Git](https://git-scm.com/downloads)
- [Docker](https://www.docker.com/products/docker/) `>= 1.12`







## Installation

Choose the setup the best suits your needs.

- [A) Setup for Single Project](#A)
	- [A.1) Already have a PHP project](#A1)
 	- [A.2) Don't have a PHP project yet](#A2)
- [B) Setup for Multiple Projects](#B)


<a name="A"></a>
### A) Setup for Single Project
> (Follow these steps if you want a separate Docker environment for each project)


<a name="A1"></a>
### A.1) Already have a PHP project:

1 - Clone laradock on your project root directory:

```bash
git submodule add https://github.com/Laradock/laradock.git
```

Note: If you are not using Git yet for your project, you can use `git clone` instead of `git submodule `.

*To keep track of your Laradock changes, between your projects and also keep Laradock updated [check these docs](/documentation/#keep-track-of-your-laradock-changes)*


Your folder structure should look like this:

```
+ project-a
  + laradock-a
+ project-b
  + laradock-b
```

*(It's important to rename the laradock folders to unique name in each project, if you want to run laradock per project).*

> **Now jump to the [Usage](#Usage) section.**

<a name="A2"></a>
### A.2) Don't have a PHP project yet:

1 - Clone this repository anywhere on your machine:

```bash
git clone https://github.com/laradock/laradock.git
```

Your folder structure should look like this:

```
+ laradock
+ project-z
```

2 - Edit your web server sites configuration.

We'll need to do step 1 of the [Usage](#Usage) section now to make this happen.

```
cp env-example .env
```

At the top, change the `APPLICATION` variable to your project path.

```
APPLICATION=../project-z/
```

Make sure to replace `project-z` with your project folder name.

> **Now jump to the [Usage](#Usage) section.**


<a name="B"></a>
### B) Setup for Multiple Projects:
> (Follow these steps if you want a single Docker environment for all your project)

1 - Clone this repository anywhere on your machine (similar to [Steps A.2. from above](#A2)):

```bash
git clone https://github.com/laradock/laradock.git
```

Your folder structure should look like this:

```
+ laradock
+ project-1
+ project-2
```

2 - Go to `nginx/sites` and create config files to point to different project directory when visiting different domains.

Laradock by default includes `project-1.conf` and `project-2.conf` as working samples.

3 - change the default names `project-n`:

You can rename the config files, project folders and domains as you like, just make sure the `root` in the config files, is pointing to the correct project folder name.

4 - Add the domains to the **hosts** files.

```
127.0.0.1  project-1.dev
127.0.0.1  project-2.dev
```

> **Now jump to the [Usage](#Usage) section.**







<a name="Usage"></a>
## Usage

**Read Before starting:**

If you are using **Docker Toolbox** (VM), do one of the following:

- Upgrade to Docker [Native](https://www.docker.com/products/docker) for Mac/Windows (Recommended). Check out [Upgrading Laradock](/documentation/#upgrading-laradock)
- Use Laradock v3.\*. Visit the [Laradock-ToolBox](https://github.com/laradock/laradock/tree/Laradock-ToolBox) branch. *(outdated)*

<br>

We recommend using a Docker version which is newer than 1.13. 

<br>

>**Warning:** If you used an older version of Laradock it's highly recommended to rebuild the containers you need to use [see how you rebuild a container](#Build-Re-build-Containers) in order to prevent as much errors as possible.

<br>

1 - Enter the laradock folder and copy `env-example` to `.env`

```shell
cp env-example .env
```

You can edit the `.env` file to chose which software's you want to be installed in your environment. You can always refer to the `docker-compose.yml` file to see how those variables are been used.


2 - Build the enviroment and run it using `docker-compose`

In this example we'll see how to run NGINX (web server) and MySQL (database engine) to host a PHP Web Scripts:

```bash
docker-compose up -d nginx mysql
```

**Note**: The `workspace` and `php-fpm` will run automatically in most of the cases, so no need to specify them in the `up` command. If you couldn't find them running then you need specify them as follow: `docker-compose up -d nginx php-fpm mysql workspace`.


You can select your own combination of containers form [this list](http://laradock.io/introduction/#supported-software-images).

*(Please note that sometimes we forget to update the docs, so check the `docker-compose.yml` file to see an updated list of all available containers).*


<br>
3 - Enter the Workspace container, to execute commands like (Artisan, Composer, PHPUnit, Gulp, ...)

```bash
docker-compose exec workspace bash
```

*Alternatively, for Windows PowerShell users: execute the following command to enter any running container:*

```bash
docker exec -it {workspace-container-id} bash
```

**Note:** You can add `--user=laradock` to have files created as your host's user. Example: 

```shell
docker-compose exec --user=laradock workspace bash
```

*You can change the PUID (User id) and PGID (group id) variables from the `.env` file)*

<br>
4 - Update your project configurations to use the database host

Open your PHP project's `.env` file or whichever configuration file you are reading from, and set the database host `DB_HOST` to `mysql`:

```env
DB_HOST=mysql
```

*If you want to install Laravel as PHP project, see [How to Install Laravel in a Docker Container](#Install-Laravel).*

<br>
5 - Open your browser and visit your localhost address `http://localhost/`. If you followed the multiple projects setup, you can visit `http://project-1.dev/` and `http://project-2.dev/`.
