#### How to use the Snipe-IT docker image #####

### How to get up and running ###

* First get a MySQL container running

Figure out what you want for your:

* MySQL root password
* MySQL Database name for Snipe-IT
* MySQL User name for the user who will access Snipe-IT
* MySQL Password for that user

```sh
docker run --name mysql -e MYSQL_ROOT_PASSWORD=SUPERDUPERSECRETPASSWORD -e MYSQL_DATABASE=snipeit -e MYSQL_USER=snipeit -e MYSQL_PASSWORD=tinglewingler -d -p $(boot2docker ip):33060:3306 mysql
```

That should set you up with your database to use.

Now you can start your Snipe-IT container -
```sh
docker run -d -p $(boot2docker ip):8000:80 --name="snipeit" --link mysql:mysql snipeit 
```

And finally, you can initialize the application and database like this:

```sh
docker exec -i -t snipeit php artisan app:install
```

(Go ahead and answer the questions however you like. Type 'yes' when asked whether or not you want to run migrations.)

# If you want to seed #

You can load out some initial data into the DB if you like by doing this:

```sh
docker -p $(boot2docker ip):8000:80 --link mysql:mysql php artisan db:seed
```

### For Development ###

When you call ```docker run``` - make sure to mount your own snipe-it directory *over* the /var/www/html directory. Something like:

```sh
docker run -v /Path/To/My/snipe-it/checkout:/var/www/html
```

Then your local changes to the code will be reflected.