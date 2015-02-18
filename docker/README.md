#### How to use the Snipe-IT docker image #####

### How to get up and running ###

* First get a MySQL container running

Figure out what you want for your:

* MySQL root password
* MySQL Database name for Snipe-IT
* MySQL User name for the user who will access Snipe-IT
* MySQL Password for that user

```sh
docker run --name mysql -e MYSQL_ROOT_PASSWORD=SUPERDUPERSECRETPASSWORD -e MYSQL_DATABASE=snipeit -e MYSQL_USER=snipeit -e MYSQL_PASSWORD=tinglewingler -d -p $(boot2docker ip)::3306 mysql
```

That should set you up with your database to use. (You can also use an environment file using ```--env-file```; see ```docker run --help``` for details)

Now you can start your Snipe-IT container -
```sh
docker run -d -p $(boot2docker ip)::80 --name="snipeit" --link mysql:mysql snipeit 
```

You can find out what port Snipe-IT is running on with:

```sh
docker port snipeit
```

And finally, you can initialize the application and database like this:

```sh
docker exec -i -t snipeit php artisan app:install
```

(Go ahead and answer the questions however you like. Type 'yes' when asked whether or not you want to run migrations.)

#NOTE:

You may have to run:

```sh
docker exec -i -t snipeit php artisan key:generate --env=production
```

to get the production application key set correctly; I'm not yet sure why this is (I think it's a bug?)

# ~~If you want to seed~~

~~You can load out some initial data into the DB if you like by doing this:~~

```sh
~~docker -p $(boot2docker ip):8000:80 --link mysql:mysql php artisan db:seed~~
```

~~This already happens~~

### For Development ###

When you call ```docker run``` - make sure to mount your own snipe-it directory *over* the /var/www/html directory. Something like:

```sh
docker run -d -v /Path/To/My/snipe-it/checkout:/var/www/html -p $(boot2docker ip)::80  --name="snipeit" --link mysql:mysql snipeit
```

Then your local changes to the code will be reflected. You will have to re-run ```composer install``` - 

```sh
docker exec -i -t snipeit composer install
```

You'll need to copy the docker/database.php file to ```app/config/production/``` , and copy the ```app/config/production/app.example.php to app/config/production/app.php```

And also app:install - 

```sh
docker exec -i -t snipeit php artisan app:install
```

And you may still need to generate the key with - 

```sh
docker exec -i -t snipeit php artisan key:generate --env=production
```
While you're developing, you may need to occasionally run -

```sh
docker exec snipeit composer dump-autoload
```

To fix the autoloading cache (if, for example, your class names change, or you add new ones...)
