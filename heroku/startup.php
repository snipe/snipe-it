<?php
// Snipe-IT Heroku Startup Script

// If DB_<value> values are set, ignore parser.
if (getenv("DB_DATABASE") || getenv("DB_HOST") || getenv("DB_USERNAME")) {
  echo "Database Environment variables are manually set. Ignoring add-ins.";
} else if (getenv("CLEARDB_DATABASE_URL")) {  // ClearDB Add-in
  echo "Using ClearDB Heroku add-in." . PHP_EOL;
  set_db(getenv('CLEARDB_DATABASE_URL'));
} else if (getenv("JAWSDB_MARIA_URL")) {      // JawsDB Maria Add-in
  echo "Using JawsDB Maria Heroku add-in." . PHP_EOL;
  set_db(getenv("JAWSDB_MARIA_URL"));
} else if (getenv("JAWSDB_MYSQL_URL")) {      // JawsDB MySQL Add-in
  echo "Using JawsDB MySQL Heroku add-in." . PHP_EOL;
  set_db(getenv("JAWSDB_MYSQL_URL"));
}

function set_db($uri) {
  file_put_contents('./.env', 'DB_HOST='     . parse_url($uri, PHP_URL_HOST). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_USERNAME=' . parse_url($uri, PHP_URL_USER). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_PASSWORD=' . parse_url($uri, PHP_URL_PASS). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_DATABASE=' . ltrim(parse_url($uri, PHP_URL_PATH), '/'). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_PREFIX=' . 'null' . PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'DB_DUMP_PATH=' . 'null' . PHP_EOL, FILE_APPEND);

}

// If Heroku Redis is setup, let's get it working.
if (getenv("REDIS_URL")) {                    // Heroku Redis
  echo "Setting up Heroku Redis." . PHP_EOL;
  $url = getenv("REDIS_URL");
  file_put_contents('./.env', 'REDIS_HOST='     . parse_url($url, PHP_URL_HOST). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'REDIS_PASSWORD=' . parse_url($url, PHP_URL_PASS). PHP_EOL, FILE_APPEND);
  file_put_contents('./.env', 'REDIS_PORT='     . parse_url($url, PHP_URL_PORT). PHP_EOL, FILE_APPEND);
}

// Set up APP_TRUSTED_PROXIES to allow for the Heroku Router
// https://devcenter.heroku.com/articles/deploying-symfony4#trusting-the-heroku-router
file_put_contents('./.env', 'APP_TRUSTED_PROXIES=10.0.0.0/8' . PHP_EOL, FILE_APPEND); 

// Set up GD
file_put_contents('./.env', 'IMAGE_LIB=gd' . PHP_EOL, FILE_APPEND); 

// Set local FILESYSTEM_DISK and PUBLIC_FILESYSTEM_DISK
file_put_contents('./.env', 'FILESYSTEM_DISK=local' . PHP_EOL, FILE_APPEND); 
file_put_contents('./.env', 'PUBLIC_FILESYSTEM_DISK=local_public' . PHP_EOL, FILE_APPEND);

// Set APP_CIPHER
file_put_contents('./.env', 'APP_CIPHER=AES-256-CBC' . PHP_EOL, FILE_APPEND); 

?>
