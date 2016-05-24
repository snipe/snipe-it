---
currentMenu: contributing
---

# Contribution Guidelines


<div id="generated-toc" class="generate_from_h2"></div>

**Before opening an issue to report a bug or request help, make sure you've checked the [Common Issues](common-issues.html) and [Getting Help](getting-help.html) pages.**

## Developing on Snipe-IT

Please submit all pull requests to the [snipe/snipe-it](http://github.com/snipe/snipe-it) repository in the `develop` branch!

**As you're working on bug-fixes or features, please break them out into their own feature branches and open the pull request against your feature branch**. It makes it _much_ easier to decipher down the road, as you open multiple pull requests over time, and makes it much easier for us to approve pull requests quickly.

If you don't have a feature in mind, but would like to contribute back to the project, check out the [open issues](https://github.com/snipe/snipe-it/issues?state=open) and see if there are any you can tackle.

If you have a feature in mind that hasn't been asked for in Github Issues, please open an issue so that we can discuss how it should work so that it will benefit the entire community.

We use Waffle.io to help better communicate our roadmap with users. Our [project page there](http://waffle.io/snipe/snipe-it) will show you the backlog, what's ready to be worked on, what's in progress, and what's completed. Issues that have been approved by the project maintainer are labeled "ready for dev".

[![Stories in Ready](https://badge.waffle.io/snipe/snipe-it.png?label=ready+for+dev&title=Ready+for+Development)](http://waffle.io/snipe/snipe-it)

The labels we use in GitHub Issues and Waffle.io indicate also whether we've confirmed an issue as a bug, whether we're considering the issue as a potential feature, and whether it's ready for someone to work on it. We also provide labels such as "n00b", "intermediate" and "advanced" for the experience level we think it requires for contributors who want to help.

-----

## Setting Up a Dev Installation

The only real difference in setting Snipe-IT up for local development versus setting it up for production usage is the configuration files, and remembering to add the local environment flag on the artisan commands.

You’ll notice in your `app/config directory`, you have directories such as `local`, `staging`, and `production`. (The `testing` directory is reserved for unit tests, so don’t mess with that one.)

You’ll want to make sure you have the configuration files updated for whichever environment you’re in, which will most likely be `local`.

If your development, staging and production sites all run on the same server (which is generally a terrible idea), see [this example](http://words.weareloring.com/development/setting-up-multiple-environments-in-laravel-4-1/) of how to configure the app using environmental variables.

If you run the command line tools without the local flag, it will default to the production environment, so you’ll want to make sure you run the commands as:

```
php artisan key:generate --env=local
php artisan app:install --env=local
```

-----

## Set up the debugbar

In dev mode, we use the fabulous [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) by [barryvdh](https://github.com/barryvdh).

The profiler is enabled by default if you have `debug` set to `true` in your `app.php`. You certainly don’t have to use it, but it’s pretty handy for troubleshooting queries, seeing how much memory your pages are using, making sure your code isn't introducing n+1 queries, etc.

-----

## Database Considerations

Always make sure you're eager loading queries where possible, to avoid "N+1 query" issues with large data sets. The debugbar at the bottom of your development installation will show you the number of queries you're executing, which should alert you to any issues.

-----

## Purging the autoloader

If you’re doing any development on this, make sure you purge the auto-loader if you see any errors stating the new model you created can’t be found, etc, otherwise your new models won’t be grokked.

```
php composer.phar dump-autoload
```

-----

## Localization Support

When developing on Snipe-IT, please always use language strings (`@lang('path/to/file.string')` in blades, `Lang::get('path/to/file.string')` in controllers) instead of regular text on any user-facing text, so that we can easily extend your changes out to the translation community.

You do not need to provide translated strings for all of the languages we support, only English (`app/lang/en`). We use CrowdIn for translation management by native speakers, so you only need to provide English strings. More info on translations [available here](translations.html).

-----

## Contributor Code of Conduct

Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms. [See the source on Github](https://github.com/snipe/snipe-it) to read the current version of the Code of Conduct.
