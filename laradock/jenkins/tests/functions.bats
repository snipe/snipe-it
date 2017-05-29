#!/usr/bin/env bats

SUT_IMAGE=bats-jenkins

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

. $BATS_TEST_DIRNAME/../jenkins-support

@test "build image" {
  cd $BATS_TEST_DIRNAME/..
  docker_build -t $SUT_IMAGE .
}

@test "versionLT" {
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0 1.0"
  assert_failure
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0 1.1"
  assert_success
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.1 1.0"
  assert_failure
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0-beta-1 1.0"
  assert_success
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0 1.0-beta-1"
  assert_failure
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0-alpha-1 1.0-beta-1"
  assert_success
  run docker run --rm $SUT_IMAGE bash -c "source /usr/local/bin/jenkins-support && versionLT 1.0-beta-1 1.0-alpha-1"
  assert_failure
}
