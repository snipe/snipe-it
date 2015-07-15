---
currentMenu: getting-help
---

# Getting Help

If you're having trouble setting up Snipe-IT, don't worry!

__First__, check the [common issues page](../common-issues.html) to make sure your problem hasn't already been addressed. We update that page frequently as requests come in.

If you can't find your issue there, simply post a new issue in the [Github Issues for Snipe-IT](https://github.com/snipe/snipe-it/issues), or ask in the [Snipe-IT Gitter chat room](https://gitter.im/snipe/snipe-it?utm_source=share-link&utm_medium=link&utm_campaign=share-link) and we'll try to get you sorted out.

Before posting an issue, please read the following so we can help you as quickly and efficiently as possible.

### Enable debug mode

In your `app/config/app.php`, set `debug` to true. You'll switch this back to false once we're done debugging your issue, but this will turn on verbode errors on the screen and will help you see what's breaking.

If you get an "Oops!" or "Whoops!" message in the browser when you hit a specific page, that means debug is set to false. Set it to true, and reload for detailed errors.

### Posting an issue to Github or Gitter
When posting a new issue, please be SURE to include the following:

- Version of Snipe-IT you're running. (If you didn't grab an official release, let us know which branch you pulled from.)
- What OS and web server you're running Snipe-IT on
- If you're getting an error in your browser, include that error.
- If a stacktrace is provided in the error, include that too.
- Include any additional information you can find in `app/storage/logs` and your webserver's logs.
- Include what you've done so far in the installation, and if you got any error messages along the way.

#### It will be nearly impossible for us to help you without this info, so please try to be sure to include it with every help request so that we can try to get your problem sorted quickly.

**__Please do not email for support. Github Issues allows us to share solutions so that other people can learn from them, which gives the community the most benefit.__**
