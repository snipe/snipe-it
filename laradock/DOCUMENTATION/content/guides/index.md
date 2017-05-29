---
title: Guides
type: index
weight: 4
---



* [Production Setup on Digital Ocean](#Digital-Ocean)
* [PHPStorm XDebug Setup](#PHPStorm-Debugging)



<a name="Digital-Ocean"></a>
# Production Setup on Digital Ocean

## Install Docker

- Visit [DigitalOcean](https://cloud.digitalocean.com/login) and login.
- Click the `Create Droplet` button.
- Open the `One-click apps` tab.
- Select Docker with your preferred version.
- Continue creating the droplet as you normally would.
- If needed, check your e-mail for the droplet root password.

## SSH to your Server

Find the IP address of the droplet in the DigitalOcean interface. Use it to connect to the server.

```
ssh root@ipaddress
```

You may be prompted for a password. Type the one you found within your e-mailbox. It'll then ask you to change the password.

You can now check if Docker is available:

```
$root@server:~# docker
```

## Set Up Your Laravel Project

```
$root@server:~# apt-get install git
$root@server:~# git clone https://github.com/laravel/laravel
$root@server:~# cd laravel
$root@server:~/laravel/ git submodule add https://github.com/Laradock/laradock.git
$root@server:~/laravel/ cd laradock
```

## Install docker-compose command

```
$root@server:~/laravel/laradock# curl -L https://github.com/docker/compose/releases/download/1.8.0/run.sh > /usr/local/bin/docker-compose
$root@server:~/chmod +x /usr/local/bin/docker-compose
```
##  Enter the laradock folder and rename env-example to .env.
```
$root@server:~/laravel/laradock# cp env-example .env
```

## Create Your Laradock Containers

```
$root@server:~/laravel/laradock# docker-compose up -d nginx mysql
```

Note that more containers are available, find them in the [docs](http://laradock.io/introduction/#supported-software-containers) or the `docker-compose.yml` file.

## Go to Your Workspace

```
docker-compose exec workspace bash
```

## Install and configure Laravel

Let's install Laravel's dependencies, add the `.env` file, generate the key and give proper permissions to the cache folder.

```
$ root@workspace:/var/www# composer install
$ root@workspace:/var/www# cp .env.example .env
$ root@workspace:/var/www# php artisan key:generate
$ root@workspace:/var/www# exit
$root@server:~/laravel/laradock# cd ..
$root@server:~/laravel# sudo chmod -R 777 storage bootstrap/cache
```

You can then view your Laravel site by visiting the IP address of your server in your browser. For example:

```
http://192.168.1.1
```

It should show you the Laravel default welcome page.

However, we want it to show up using your custom domain name, as well.

## Using Your Own Domain Name

Login to your DNS provider, such as Godaddy, Namecheap.

Point the Custom Domain Name Server to:

```
ns1.digitalocean.com
ns2.digitalocean.com
ns3.digitalocean.com
```

Within DigitalOcean, you'll need to change some settings, too.

Visit: https://cloud.digitalocean.com/networking/domains

Add your domain name and choose the server IP you'd provision earlier.

## Serving Site With NGINX (HTTP ONLY)

Go back to command line.

```
$root@server:~/laravel/laradock# cd nginx
$root@server:~/laravel/laradock/nginx# vim laravel.conf
```

Remove `default_server`

```
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;
```

And add `server_name` (your custom domain)

```
    listen 80;
    listen [::]:80 ipv6only=on;
    server_name yourdomain.com;
```

## Rebuild Your Nginx

```
$root@server:~/laravel/laradock# docker-compose down
$root@server:~/laravel/laradock# docker-compose build nginx
```

## Re Run Your Containers MYSQL and NGINX

```
$root@server:~/laravel/laradock/nginx# docker-compose up -d nginx mysql
```

**View Your Site with HTTP ONLY (http://yourdomain.com)**

## Run Site on SSL with Let's Encrypt Certificate

**Note: You need to Use Caddy here Instead of Nginx**

To go Caddy Folders and Edit CaddyFile

```
$root@server:~/laravel/laradock# cd caddy
$root@server:~/laravel/laradock/caddy# vim Caddyfile
```

Remove 0.0.0.0:80

```
0.0.0.0:80
root /var/www/public
```

and replace with your https://yourdomain.com

```
https://yourdomain.com
root /var/www/public
```

uncomment tls

```
#tls self-signed
```

and replace self-signed with your email address

```
tls serverbreaker@gmai.com
```

This is needed Prior to Creating Let's Encypt

## Run Your Caddy Container without the -d flag and Generate SSL with Let's Encrypt

```
$root@server:~/laravel/laradock/caddy# docker-compose up  caddy
```

You'll be prompt here to enter your email... you may enter it or not

```
Attaching to laradock_mysql_1, laradock_caddy_1
caddy_1               | Activating privacy features...
caddy_1               | Your sites will be served over HTTPS automatically using Let's Encrypt.
caddy_1               | By continuing, you agree to the Let's Encrypt Subscriber Agreement at:
caddy_1               |   https://letsencrypt.org/documents/LE-SA-v1.0.1-July-27-2015.pdf
caddy_1               | Activating privacy features... done.
caddy_1               | https://yourdomain.com
caddy_1               | http://yourdomain.com
```

After it finishes, press `Ctrl` + `C` to exit.

## Stop All Containers and ReRun Caddy and Other Containers on Background

```
$root@server:~/laravel/laradock/caddy# docker-compose down
$root@server:~/laravel/laradock/caddy# docker-compose up -d mysql caddy
```

View your Site in the Browser Securely Using HTTPS (https://yourdomain.com)

**Note that Certificate will be Automatically Renew By Caddy**

>References:
>
- [https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-16-04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-16-04)
- [https://www.digitalocean.com/products/one-click-apps/docker/](https://www.digitalocean.com/products/one-click-apps/docker/)
- [https://docs.docker.com/engine/installation/linux/ubuntulinux/](https://docs.docker.com/engine/installation/linux/ubuntulinux/)
- [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)
- [https://caddyserver.com/docs/automatic-https](https://caddyserver.com/docs/automatic-https)
- [https://caddyserver.com/docs/tls](https://caddyserver.com/docs/tls)
- [https://caddyserver.com/docs/caddyfile](https://caddyserver.com/docs/caddyfile)





<br>
<br>
<br>
<br>
<br>

<a name="PHPStorm-Debugging"></a>
# PHPStorm XDebug Setup

- [Intro](#Intro)
- [Installation](#Installation)
    - [Customize laradock/docker-compose.yml](#CustomizeDockerCompose)
        - [Clean House](#InstallCleanHouse)
        - [Laradock Dial Tone](#InstallLaradockDialTone)
        - [hosts](#AddToHosts)
        - [Firewall](#FireWall)
        - [Enable xDebug on php-fpm](#enablePhpXdebug)
    - [PHPStorm Settings](#InstallPHPStorm)
        - [Configs](#InstallPHPStormConfigs)
- [Usage](#Usage)
    - [Laravel](#UsageLaravel)
        - [Run ExampleTest](#UsagePHPStormRunExampleTest)
        - [Debug ExampleTest](#UsagePHPStormDebugExampleTest)
        - [Debug Web Site](#UsagePHPStormDebugSite)
- [SSH into workspace](#SSHintoWorkspace)
    - [KiTTY](#InstallKiTTY)

<a name="Intro"></a>
## Intro

Wiring up [Laravel](https://laravel.com/), [Laradock](https://github.com/Laradock/laradock) [Laravel+Docker] and [PHPStorm](https://www.jetbrains.com/phpstorm/) to play nice together complete with remote xdebug'ing as icing on top! Although this guide is based on `PHPStorm Windows`,
you should be able to adjust accordingly. This guide was written based on Docker for Windows Native.

<a name="Installation"></a>
## Installation

- This guide assumes the following:
    - you have already installed and are familiar with Laravel, Laradock and PHPStorm.
    - you have installed Laravel as a parent of `laradock`. This guide assumes `/c/_dk/laravel`.

<a name="AddToHosts"></a>
## hosts
- Add `laravel` to your hosts file located on Windows 10 at `C:\Windows\System32\drivers\etc\hosts`. It should be set to the IP of your running container. Mine is: `10.0.75.2`
On Windows you can find it by opening Windows `Hyper-V Manager`.
    - ![Windows Hyper-V Manager](images/photos/PHPStorm/Settings/WindowsHyperVManager.png)

- [Hosts File Editor](https://github.com/scottlerch/HostsFileEditor) makes it easy to change your hosts file.
    - Set `laravel` to your docker host IP. See [Example](images/photos/SimpleHostsEditor/AddHost_laravel.png).


<a name="FireWall"></a>
## Firewall
Your PHPStorm will need to be able to receive a connection from PHP xdebug either your running workspace or php-fpm containers on port 9000. This means that your Windows Firewall should either enable connections from the Application PHPStorm OR the port.

- It is important to note that if the Application PHPStorm is NOT enabled in the firewall, you will not be able to recreate a rule to override that.
- Also be aware that if you are installing/upgrade different versions of PHPStorm, you MAY have orphaned references to PHPStorm in your Firewall! You may decide to remove orphaned references however in either case, make sure that they are set to receive public TCP traffic.

### Edit laradock/docker-compose.yml
Set the following variables:
```
### Workspace Utilities Container ###############

    workspace:
        build:
            context: ./workspace
            args:
                - INSTALL_XDEBUG=true
                - INSTALL_WORKSPACE_SSH=true
                ...


### PHP-FPM Container #####################

    php-fpm:
        build:
            context: ./php-fpm
            args:
                - INSTALL_XDEBUG=true
                ...

```

### Edit xdebug.ini files
- `laradock/workspace/xdebug.ini`
- `laradock/php-fpm/xdebug.ini`

Set the following variables:
```
xdebug.remote_autostart=1
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.cli_color=1
```


<a name="InstallCleanHouse"></a>
### Need to clean house first?
Make sure you are starting with a clean state. For example, do you have other Laradock containers and images?
Here are a few things I use to clean things up.

- Delete all containers using `grep laradock_` on the names, see: [Remove all containers based on docker image name](https://linuxconfig.org/remove-all-containners-based-on-docker-image-name).
`docker ps -a | awk '{ print $1,$2 }' | grep laradock_ | awk '{print $1}' | xargs -I {} docker rm {}`

- Delete all images containing `laradock`.
`docker images | awk '{print $1,$2,$3}' | grep laradock_ | awk '{print $3}' | xargs -I {} docker rmi {}`
**Note:** This will only delete images that were built with `Laradock`, **NOT** `laradock/*` which are pulled down by `Laradock` such as `laradock/workspace`, etc.
**Note:** Some may fail with:
`Error response from daemon: conflict: unable to delete 3f38eaed93df (cannot be forced) - image has dependent child images`

- I added this to my `.bashrc` to remove orphaned images.
    ```
    dclean() {
        processes=`docker ps -q -f status=exited`
        if [ -n "$processes" ]; thend
          docker rm $processes
        fi

        images=`docker images -q -f dangling=true`
        if [ -n "$images" ]; then
          docker rmi $images
        fi
    }
    ```

- If you frequently switch configurations for Laradock, you may find that adding the following and added to your `.bashrc` or equivalent useful:
```
# remove laravel* containers
# remove laravel_* images
dcleanlaradockfunction()
{
	echo 'Removing ALL containers associated with laradock'
	docker ps -a | awk '{ print $1,$2 }' | grep laradock | awk '{print $1}' | xargs -I {} docker rm {}

	# remove ALL images associated with laradock_
	# does NOT delete laradock/* which are hub images
	echo 'Removing ALL images associated with laradock_'
	docker images | awk '{print $1,$2,$3}' | grep laradock_ | awk '{print $3}' | xargs -I {} docker rmi {}

	echo 'Listing all laradock docker hub images...'
	docker images | grep laradock

	echo 'dcleanlaradock completed'
}
# associate the above function with an alias
# so can recall/lookup by typing 'alias'
alias dcleanlaradock=dcleanlaradockfunction
```

<a name="InstallLaradockDialTone"></a>
## Let's get a dial-tone with Laravel

```
# barebones at this point
docker-compose up -d nginx mysql

# run
docker-compose ps

# Should see:
          Name                        Command             State                     Ports
-----------------------------------------------------------------------------------------------------------
laradock_mysql_1            docker-entrypoint.sh mysqld   Up       0.0.0.0:3306->3306/tcp
laradock_nginx_1            nginx                         Up       0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp
laradock_php-fpm_1          php-fpm                       Up       9000/tcp
laradock_volumes_data_1     true                          Exit 0
laradock_volumes_source_1   true                          Exit 0
laradock_workspace_1        /sbin/my_init                 Up       0.0.0.0:2222->22/tcp


```

<a name="enablePhpXdebug"></a>
## Enable xDebug on php-fpm
In a host terminal sitting in the laradock folder, run: `.php-fpm/xdebug status`
You should see something like the following:
```
xDebug status
laradock_php-fpm_1
PHP 7.0.9 (cli) (built: Aug 10 2016 19:45:48) ( NTS )
Copyright (c) 1997-2016 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2016 Zend Technologies
    with Xdebug v2.4.1, Copyright (c) 2002-2016, by Derick Rethans
```
Other commands include `.php-fpm/xdebug start | stop`.

If you have enabled `xdebug=true` in `docker-compose.yml/php-fpm`, `xdebug` will already be running when
`php-fpm` is started and listening for debug info on port 9000.


<a name="InstallPHPStormConfigs"></a>
## PHPStorm Settings
- Here are some settings that are known to work:
    - `Settings/BuildDeploymentConnection`
        - ![Settings/BuildDeploymentConnection](/images/photos/PHPStorm/Settings/BuildDeploymentConnection.png)

    - `Settings/BuildDeploymentConnectionMappings`
        - ![Settings/BuildDeploymentConnectionMappings](/images/photos/PHPStorm/Settings/BuildDeploymentConnectionMappings.png)

    - `Settings/BuildDeploymentDebugger`
        - ![Settings/BuildDeploymentDebugger](/images/photos/PHPStorm/Settings/BuildDeploymentDebugger.png)

    - `Settings/EditRunConfigurationRemoteWebDebug`
        - ![Settings/EditRunConfigurationRemoteWebDebug](/images/photos/PHPStorm/Settings/EditRunConfigurationRemoteWebDebug.png)

    - `Settings/EditRunConfigurationRemoteExampleTestDebug`
        - ![Settings/EditRunConfigurationRemoteExampleTestDebug](/images/photos/PHPStorm/Settings/EditRunConfigurationRemoteExampleTestDebug.png)

    - `Settings/LangsPHPDebug`
        - ![Settings/LangsPHPDebug](/images/photos/PHPStorm/Settings/LangsPHPDebug.png)

    - `Settings/LangsPHPInterpreters`
        - ![Settings/LangsPHPInterpreters](/images/photos/PHPStorm/Settings/LangsPHPInterpreters.png)

    - `Settings/LangsPHPPHPUnit`
        - ![Settings/LangsPHPPHPUnit](/images/photos/PHPStorm/Settings/LangsPHPPHPUnit.png)

    - `Settings/LangsPHPServers`
        - ![Settings/LangsPHPServers](/images/photos/PHPStorm/Settings/LangsPHPServers.png)

    - `RemoteHost`
        To switch on this view, go to: `Menu/Tools/Deployment/Browse Remote Host`.
        - ![RemoteHost](/images/photos/PHPStorm/RemoteHost.png)

    - `RemoteWebDebug`
        - ![DebugRemoteOn](/images/photos/PHPStorm/DebugRemoteOn.png)

    - `EditRunConfigurationRemoteWebDebug`
        Go to: `Menu/Run/Edit Configurations`.
        - ![EditRunConfigurationRemoteWebDebug](/images/photos/PHPStorm/Settings/EditRunConfigurationRemoteWebDebug.png)

    - `EditRunConfigurationRemoteExampleTestDebug`
        Go to: `Menu/Run/Edit Configurations`.
        - ![EditRunConfigurationRemoteExampleTestDebug](/images/photos/PHPStorm/Settings/EditRunConfigurationRemoteExampleTestDebug.png)

    - `WindowsFirewallAllowedApps`
        Go to: `Control Panel\All Control Panel Items\Windows Firewall\Allowed apps`.
        - ![WindowsFirewallAllowedApps.png](/images/photos/PHPStorm/Settings/WindowsFirewallAllowedApps.png)

    - `hosts`
        Edit: `C:\Windows\System32\drivers\etc\hosts`.
        - ![WindowsFirewallAllowedApps.png](/images/photos/PHPStorm/Settings/hosts.png)

        - [Enable xDebug on php-fpm](#enablePhpXdebug)



<a name="Usage"></a>
## Usage

<a name="UsagePHPStormRunExampleTest"></a>
### Run ExampleTest
- right-click on `tests/ExampleTest.php`
    - Select: `Run 'ExampleTest.php'` or `Ctrl+Shift+F10`.
    - Should pass!! You just ran a remote test via SSH!

<a name="UsagePHPStormDebugExampleTest"></a>
### Debug ExampleTest
- Open to edit: `tests/ExampleTest.php`
- Add a BreakPoint on line 16: `$this->visit('/')`
- right-click on `tests/ExampleTest.php`
    - Select: `Debug 'ExampleTest.php'`.
    - Should have stopped at the BreakPoint!! You are now debugging locally against a remote Laravel project via SSH!
    - ![Remote Test Debugging Success](/images/photos/PHPStorm/RemoteTestDebuggingSuccess.png)


<a name="UsagePHPStormDebugSite"></a>
### Debug WebSite
- In case xDebug is disabled, from the `laradock` folder run:
`.php-fpm/xdebug start`.
    - To switch xdebug off, run:
`.php-fpm/xdebug stop`

- Start Remote Debugging
    - ![DebugRemoteOn](/images/photos/PHPStorm/DebugRemoteOn.png)

- Open to edit: `bootstrap/app.php`
- Add a BreakPoint on line 14: `$app = new Illuminate\Foundation\Application(`
- Reload [Laravel Site](http://laravel/)
    - Should have stopped at the BreakPoint!! You are now debugging locally against a remote Laravel project via SSH!
    - ![Remote Debugging Success](/images/photos/PHPStorm/RemoteDebuggingSuccess.png)


<a name="SSHintoWorkspace"></a>
## Let's shell into workspace
Assuming that you are in laradock folder, type:
`ssh -i workspace/insecure_id_rsa -p2222 root@laravel`
**Cha Ching!!!!**
- `workspace/insecure_id_rsa.ppk` may become corrupted. In which case:
    - fire up `puttygen`
    - import `workspace/insecure_id_rsa`
    - save private key to `workspace/insecure_id_rsa.ppk`

<a name="InstallKiTTY"></a>

### KiTTY
[Kitty](http://www.9bis.net/kitty/) KiTTY is a fork from version 0.67 of PuTTY.

- Here are some settings that are working for me:
    - ![Session](/images/photos/KiTTY/Session.png)
    - ![Terminal](/images/photos/KiTTY/Terminal.png)
    - ![Window](/images/photos/KiTTY/Window.png)
    - ![WindowAppearance](/images/photos/KiTTY/WindowAppearance.png)
    - ![Connection](/images/photos/KiTTY/Connection.png)
    - ![ConnectionData](/images/photos/KiTTY/ConnectionData.png)
    - ![ConnectionSSH](/images/photos/KiTTY/ConnectionSSH.png)
    - ![ConnectionSSHAuth](/images/photos/KiTTY/ConnectionSSHAuth.png)
    - ![TerminalShell](/images/photos/KiTTY/TerminalShell.png)


