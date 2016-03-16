---
currentMenu: getting-help
---

# Getting Help

If you're having trouble setting up Snipe-IT, don't worry!

__First__, check the [common issues page](common-issues.html) to make sure your problem hasn't already been addressed. We update that page frequently as requests come in.

If you can't find your issue there, simply post a new issue in the [Github Issues for Snipe-IT](https://github.com/snipe/snipe-it/issues), or ask in the [Snipe-IT Gitter chat room](https://gitter.im/snipe/snipe-it?utm_source=share-link&utm_medium=link&utm_campaign=share-link) and we'll try to get you sorted out.

Before posting an issue, please read the following so we can help you as quickly and efficiently as possible.

### Enable debug mode

In your `app/config/production/app.php`, set `debug` to true. You'll switch this back to false once we're done debugging your issue, but this will turn on verbose errors on the screen and will help you see what's breaking.

__If you get an "Oops!" or "Whoops!" message in the browser when you hit a specific page, that means debug is set to `false`.__ Set it to `true`, and reload for detailed errors.

### Enable your browser's error console

Sometimes errors reported by your browser can lend  clue as to what's going on. [Enable your browser's error console](http://webmasters.stackexchange.com/questions/8525/how-to-open-the-javascript-console-in-different-browsers) to see any client-side errors that may be causing issues.

### Posting an issue to Github or Gitter
When posting a new issue, please be SURE to include the following:

- Version of Snipe-IT you're running. (If you didn't grab an official release, let us know which branch you pulled from.)
- What OS and web server you're running Snipe-IT on
- What method you used to install Snipe-IT (`install.sh`, manual installation, docker, etc)
- If you're getting an error in your browser, include that error.
- What specific Snipe-IT page you're on, and what specific element you're interacting with to trigger the error
- If a stacktrace is provided in the error, include that too.
- Any errors that appear in your browser's error console.
- Confirm whether the error is reproduceable [on the demo](https://snipeitapp.com/demo).
- Include any additional information you can find in `app/storage/logs` and your webserver's logs.
- Include what you've done so far in the installation, and if you got any error messages along the way.
- Indicate whether or not you've manually edited any data directly in the database

#### It will be nearly impossible for us to help you without this info, so please try to be sure to include it with every help request so that we can try to get your problem sorted quickly.

**__Please do not email for installation support. Github Issues allows us to share solutions so that other people can learn from them, which gives the community the most benefit.__**
