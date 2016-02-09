---
currentMenu: command-line
---

# Using the CLI Installer

At this point you should have an *empty* database created, and all of your configuration settings set up the way you want them by carefully following the [configuration documentation](/installation/configuration.html) and editing the configuration files.

Now, you need to create yourself an admin user.

Use the following command to create your database tables, add a default user, create the default user groups and run all the necessary database migrations to ensure your database schema is up to date.

-----

#### <i class="fa fa-linux"></i> Linux / OSX
```
php artisan app:install --env=production
```

#### <i class="fa fa-windows"></i> Windows

Open `C:\inetpub\wwwroot\snipe-it` in Windows Explorer

- Right Click and select `Use Composer here`
- Type `php artisan app:install --env=production` and follow the prompts

-----

When it asks you if you’re sure you want to run the migrations, type in `y`. You may have to do this a few times.

-----

### Seed the Database (Optional)

During the `php artisan app:install` process, it will ask you if you wish to seed the database.

Loading up the sample data will give you an idea of how this should look, how your info should be structured, etc. It only pre-loads a handful of items, so you won’t have to spend an hour deleting sample data, but this step is optional. If you don’t wish to seed the database, type in `n` when the installer asks you whether you want to seed.

If you answer no, but change your mind after the installer is complete, you can run the database seeder by running:

```
php artisan db:seed --env=production
```

If you run this command on a database that already has your own production asset data in it, IT WILL OVER-WRITE YOUR ENTIRE DATABASE. ALL of your data will be gone forever. NEVER run the db seeder on production after on your initial install.

-----

### Update Your Secret Key (If you didn’t already)

After running the `php artisan app:install --env=production` command above, the output of your terminal window should show you a generated secret key. If you missed it in all the scrollback, that’s okay, you can manually run `php artisan key:generate --env=production`.

Update the value of `key` in your `app/config/production/app.php` file with the newly generated secret key.
