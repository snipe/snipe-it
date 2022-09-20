In these folders there are the configurations to start Snipe-it in FPM-Alpine version with nginx webserver and cache server redis via docker solution.

Building the first image can take several minutes, depending on the computing power of the workstation.

---Some advices---

-> If you use Docker desktop for Windows, you have to save the docker-entrypoint.sh file in LR mode (https://stackoverflow.com/a/73028795/19159500) otherwise the main container will give this error: exec user process caused "no such file or directory"

^^^^^ TAKE A LOT OF ATTENTION ^^^^^

In addition to editing the .env file for global variables (check the official documentation), you will need to enter your github token (https://github.com/settings/tokens) in the "Docker.fpm-alpine" file in order to correctly clone the "https://github.com/grokability/laravel-scim-server" repository present in the composer.json file (https://github.com/snipe/snipe-it/blob/master/composer.json) to install all php dependencies.
