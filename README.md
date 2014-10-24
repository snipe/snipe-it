[![Click here to lend your support to: Snipe IT - Free Open Source Asset Management System and make a donation at pledgie.com](https://pledgie.com/campaigns/22899.png?skin_name=chrome)](https://pledgie.com/campaigns/22899) [![Build Status](https://travis-ci.org/snipe/snipe-it.svg?branch=develop)](https://travis-ci.org/snipe/snipe-it) [![Stories in Ready](https://badge.waffle.io/snipe/snipe-it.png?label=ready&title=Ready)](http://waffle.io/snipe/snipe-it) [![ProjectStatus](http://stillmaintained.com/snipe/snipe-it.png)](http://stillmaintained.com/snipe/snipe-it)


## Snipe-IT - Asset Management For the Rest of Us

This is a FOSS project for asset management in IT Operations. Knowing who has which laptop, when it was purchased in order to depreciate it correctly, handling software licenses, etc.

It is built on [Laravel 4.1](http://laravel.com) and uses the [Sentry 2](https://github.com/cartalyst/sentry) package.

This project is being actively developed and we're [releasing quite frequently](https://github.com/snipe/snipe-it/releases). ([Check out the live demo here](http://snipeitapp.com/demo.php).)

__This is web-based software__. This means there there is no executable file (aka no .exe files), and it must be run on a web server and accessed through a web browser. It runs on any Mac OSX, flavor of Linux, as well as Windows.

-----
### Documentation & Installation

__Installation and configuration documentation for this project has been moved to http://docs.snipeitapp.com.__ This provides a more easily navigated, organized view of the documentation, and is based off of the [documentation branch](https://github.com/snipe/snipe-it/tree/documentation) in this repo. Contributions and bugfixes to the documentation are always welcome!

We'll be adding a long-overdue user's manual soon as well.

__To deploy on Ubuntu using Ansible and Vagrant, be sure to check out the [Snipe-IT Installation scripts](https://github.com/GR360RY/snipeit-ansible) created by [@GR360RY](https://github.com/GR360RY/).__

-----
### Bug Reports & Feature Requests

Feel free to check out the [GitHub Issues for this project](https://github.com/snipe/snipe-it/issues) to open a bug report or see what open issues you can help with. Please search through existing issues (open and closed) to see if your question hasn't already been answered before opening a new issue.

We use Waffle.io to help better communicate our roadmap with users. Our [project page there](http://waffle.io/snipe/snipe-it) will show you the backlog, what's ready to be worked on, what's in progress, and what's completed.

[![Stories in Ready](https://badge.waffle.io/snipe/snipe-it.png?label=ready&title=Ready)](http://waffle.io/snipe/snipe-it)

-----
### Announcement List

To be notified of important news (such as new releases, security advisories, etc), [sign up for our list](http://eepurl.com/XyZKz). We'll never sell or give away your info, and we'll only email you when it's important.


### Translations!

If you're not a coder but want to give back to the project and you're fluent in other languages, consider helping out with the translations. We use [CrowdIn](https://crowdin.com) to manage translations, and it makes it super-simple for you to add translations to the project without messing with code. Check out [the Snipe-IT CrowdIn translation project here](https://crowdin.com/project/snipe-it/).

-----
## Requirements

- PHP 5.4 or later
- MCrypt PHP Extension

-----

## Important Notes on Updating

Whenever you pull down a new version from master or develop, when you grab the [latest official release](https://github.com/snipe/snipe-it/releases), make sure to run the following commands via command line:

	php composer.phar dump-autoload
	php artisan migrate

Forgetting to do this can mean your DB might end up out of sync with the new files you just pulled, or you may have some funky cached autoloader values. It's a good idea to get into the habit of running these every time you pull anything new down. If there are no database changes to migrate, it won't hurt anything to run migrations anyway.
