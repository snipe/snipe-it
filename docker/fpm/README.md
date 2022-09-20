<h2>Snipe-it fpm alpine nginx</h2>

In these folders there are the configurations to start Snipe-it in FPM-Alpine version with nginx webserver and cache server redis via docker solution.

Building the first image can take several minutes, depending on the computing power of the workstation.

---Some advices---

-> If you use Docker desktop for Windows, you must save the docker-entrypoint.sh file with LR mode (example with VS Code https://stackoverflow.com/a/73028795/19159500) otherwise the main container will give this error: exec user process caused "no such file or directory

-> If during the construction of the image you get a github authentication error, you will have to go to insert your github token (https://github.com/settings/tokens) in the file "Docker.fpm-alpine" to be able to clone correctly the repository "https://github.com/grokability/laravel-scim-server" present in the composer.json file (https://github.com/snipe/snipe-it/blob/master/composer.json) to install all php dependencies.
Ref: - https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token - https://github.com/shivammathur/setup-php#github-composer-authentication
