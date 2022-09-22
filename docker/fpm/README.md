<h1>Snipe-it fpm alpine nginx</h1>

In these folders there are the configurations to start Snipe-it in FPM-Alpine version with nginx webserver and cache server redis via docker solution.

Building the first image can take several minutes, depending on the computing power of the workstation.

### Some advices

- If you use Docker desktop for Windows, you must save the docker-entrypoint.sh file with LR mode (example with VS Code https://stackoverflow.com/a/73028795/19159500) otherwise the main container will give this error: exec user process caused "no such file or directory

- If during the construction of the image you get a github authentication error, you will have to change some parameters in the [Docker.fpm-alpine](https://github.com/snipe/snipe-it/tree/master/docker/fpm/Docker.fpm-alpine) file:

```bash
  ARG GITHUB_TOKEN_ENABLE=true
  ARG GITHUB_TOKEN=yourtoken
```

## How to get a token:

https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token

## Reference composer authentication:

https://github.com/shivammathur/setup-php#github-composer-authentication
