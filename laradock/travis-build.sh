#!/usr/bin/env bash

#### halt script on error
set -xe

echo '##### Print docker version'
docker --version

echo '##### Print environment'
env | sort

#### Build the Docker Images
if [ -n "${PHP_VERSION}" ]; then
    cp env-example .env
    sed -i -- "s/PHP_VERSION=.*/PHP_VERSION=${PHP_VERSION}/g" .env
    sed -i -- 's/=false/=true/g' .env
    cat .env
    docker-compose build ${BUILD_SERVICE}
    docker images
fi

#### Generate the Laradock Documentation site using Hugo
if [ -n "${HUGO_VERSION}" ]; then
    HUGO_PACKAGE=hugo_${HUGO_VERSION}_Linux-64bit
    HUGO_BIN=hugo_${HUGO_VERSION}_linux_amd64

    # Download hugo binary
    curl -L https://github.com/spf13/hugo/releases/download/v$HUGO_VERSION/$HUGO_PACKAGE.tar.gz | tar xz
    mkdir $HOME/bin
    mv ./${HUGO_BIN}/${HUGO_BIN} $HOME/bin/hugo

    # Remove existing docs
    if [ -d "./docs" ]; then
        rm -r ./docs
    fi

    # Build docs
    cd DOCUMENTATION
    hugo
fi
