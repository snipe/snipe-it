#!/usr/bin/env bats

SUT_IMAGE=bats-jenkins
SUT_CONTAINER=bats-jenkins

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

@test "build image" {
  cd $BATS_TEST_DIRNAME/..
  docker_build -t $SUT_IMAGE .
}

@test "clean test containers" {
    cleanup $SUT_CONTAINER
}

@test "test multiple JENKINS_OPTS" {
  # running --help --version should return the version, not the help
  local version=$(grep 'ENV JENKINS_VERSION' Dockerfile | sed -e 's/.*:-\(.*\)}/\1/')
  # need the last line of output
  assert "${version}" docker run --rm -e JENKINS_OPTS="--help --version" --name $SUT_CONTAINER -P $SUT_IMAGE | tail -n 1
}

@test "test jenkins arguments" {
  # running --help --version should return the version, not the help
  local version=$(grep 'ENV JENKINS_VERSION' Dockerfile | sed -e 's/.*:-\(.*\)}/\1/')
  # need the last line of output
  assert "${version}" docker run --rm --name $SUT_CONTAINER -P $SUT_IMAGE --help --version | tail -n 1
}

@test "create test container" {
    docker run -d -e JAVA_OPTS="-Duser.timezone=Europe/Madrid -Dhudson.model.DirectoryBrowserSupport.CSP=\"default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';\"" --name $SUT_CONTAINER -P $SUT_IMAGE
}

@test "test container is running" {
  sleep 1  # give time to eventually fail to initialize
  retry 3 1 assert "true" docker inspect -f {{.State.Running}} $SUT_CONTAINER
}

@test "Jenkins is initialized" {
    retry 30 5 test_url /api/json
}

@test "JAVA_OPTS are set" {
    local sed_expr='s/<wbr>//g;s/<td class="pane">.*<\/td><td class.*normal">//g;s/<t.>//g;s/<\/t.>//g'
    assert 'default-src &#039;self&#039;; script-src &#039;self&#039; &#039;unsafe-inline&#039; &#039;unsafe-eval&#039;; style-src &#039;self&#039; &#039;unsafe-inline&#039;;' \
      bash -c "curl -fsSL --user \"admin:$(get_jenkins_password)\" $(get_jenkins_url)/systemInfo | sed 's/<\/tr>/<\/tr>\'$'\n/g' | grep '<td class=\"pane\">hudson.model.DirectoryBrowserSupport.CSP</td>' | sed -e '${sed_expr}'"
    assert 'Europe/Madrid' \
      bash -c "curl -fsSL --user \"admin:$(get_jenkins_password)\" $(get_jenkins_url)/systemInfo | sed 's/<\/tr>/<\/tr>\'$'\n/g' | grep '<td class=\"pane\">user.timezone</td>' | sed -e '${sed_expr}'"
}

@test "clean test containers" {
    cleanup $SUT_CONTAINER
}
