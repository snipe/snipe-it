#!/bin/bash

# check dependencies
(
    type docker &>/dev/null || ( echo "docker is not available"; exit 1 )
    type curl &>/dev/null || ( echo "curl is not available"; exit 1 )
)>&2

# Assert that $1 is the outputof a command $2
function assert {
    local expected_output=$1
    shift
    local actual_output
    actual_output=$("$@")
    actual_output="${actual_output//[$'\t\r\n']}" # remove newlines
    if ! [ "$actual_output" = "$expected_output" ]; then
        echo "expected: \"$expected_output\""
        echo "actual:   \"$actual_output\""
        false
    fi
}

# Retry a command $1 times until it succeeds. Wait $2 seconds between retries.
function retry {
    local attempts=$1
    shift
    local delay=$1
    shift
    local i

    for ((i=0; i < attempts; i++)); do
        run "$@"
        if [ "$status" -eq 0 ]; then
            return 0
        fi
        sleep $delay
    done

    echo "Command \"$*\" failed $attempts times. Status: $status. Output: $output" >&2
    false
}

function docker_build {
    if [ -n "$JENKINS_VERSION" ]; then
        docker build --build-arg JENKINS_VERSION=$JENKINS_VERSION --build-arg JENKINS_SHA=$JENKINS_SHA "$@"
    else
        docker build "$@"
    fi
}

function get_jenkins_url {
    if [ -z "${DOCKER_HOST}" ]; then
        DOCKER_IP=localhost
    else
        DOCKER_IP=$(echo "$DOCKER_HOST" | sed -e 's|tcp://\(.*\):[0-9]*|\1|')
    fi
    echo "http://$DOCKER_IP:$(docker port "$SUT_CONTAINER" 8080 | cut -d: -f2)"
}

function get_jenkins_password {
    docker logs "$SUT_CONTAINER" 2>&1 | grep -A 2 "Please use the following password to proceed to installation" | tail -n 1
}

function test_url {
    run curl --user "admin:$(get_jenkins_password)" --output /dev/null --silent --head --fail --connect-timeout 30 --max-time 60 "$(get_jenkins_url)$1"
    if [ "$status" -eq 0 ]; then
        true
    else
        echo "URL $(get_jenkins_url)$1 failed" >&2
        echo "output: $output" >&2
        false
    fi
}

function cleanup {
    docker kill "$1" &>/dev/null ||:
    docker rm -fv "$1" &>/dev/null ||:
}

function unzip_manifest {
    local plugin=$1
    local work=$2
    bash -c "docker run --rm -v $work:/var/jenkins_home --entrypoint unzip $SUT_IMAGE -p /var/jenkins_home/plugins/$plugin META-INF/MANIFEST.MF | tr -d '\r'"
}
