# Developing & Contributing

<div id="generated-toc"></div>

Please be sure to see the [contributing guidelines](https://github.com/snipe/snipe-it/blob/develop/CONTRIBUTING.md) before submitting pull requests.

The only real difference in setting Snipe-IT up for local development versus setting it up for production usage is the configuration files, and remembering to add the local environment flag on the artisan commands.

You'll notice in your `app/config` directory, you have directories such as `local`, `staging`, and `production`. (The `testing` directory is reserved for unit tests, so don't mess with that one.)

You'll want to make sure you have the configuration files updated for whichever environment you're in, which will most likely be `local`.

If you run the command line tools without the local flag, it will default to the production environment, so you'll want to make sure you run the commands as:

	php artisan key:generate --env=local
	php artisan app:install --env=local

### Set up the debugbar

In dev mode, I use the fabulous [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) by [barryvdh](https://github.com/barryvdh). After you've installed/updated composer, you'll need to publish the assets for the debugbar:

	php artisan debugbar:publish

The profiler is enabled by default if you have debug set to true in your app.php. You certainly don't have to use it, but it's pretty handy for troubleshooting queries, seeing how much memory your pages are using, etc.

-----

### Purging the autoloader

If you're doing any development on this, make sure you purge the auto-loader if you see any errors stating the new model you created can't be found, etc, otherwise your new models won't be grokked.

	php composer.phar dump-autoload


-----

### Translations

You do not need to provide translated strings for all of the languages we support, only English (`app/lang/en`). We use CrowdIn for translation management by native speakers, so you only need to provide English strings. More info on translation is [available here](../translations.html).

-----
