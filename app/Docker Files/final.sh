#!/bin/sh

sed -i "21i use Illuminate\\\\Support\\\\Facades\\\\URL;" /var/www/html/app/Providers/AppServiceProvider.php
sed -i "59i URL::forceScheme('https');" /var/www/html/app/Providers/AppServiceProvider.php

/startup.sh
