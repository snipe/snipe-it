#!/usr/bin/env bats

SUT_IMAGE=bats-jenkins

load 'test_helper/bats-support/load'
load 'test_helper/bats-assert/load'
load test_helpers

@test "build image" {
  cd $BATS_TEST_DIRNAME/..
  docker_build -t $SUT_IMAGE .
}

@test "plugins are installed with plugins.sh" {
  run docker build -t $SUT_IMAGE-plugins $BATS_TEST_DIRNAME/plugins
  assert_success
  # replace DOS line endings \r\n
  run bash -c "docker run --rm $SUT_IMAGE-plugins ls --color=never -1 /var/jenkins_home/plugins | tr -d '\r'"
  assert_success
  assert_line 'maven-plugin.jpi'
  assert_line 'maven-plugin.jpi.pinned'
  assert_line 'ant.jpi'
  assert_line 'ant.jpi.pinned'
}

@test "plugins are installed with install-plugins.sh" {
  run docker build -t $SUT_IMAGE-install-plugins $BATS_TEST_DIRNAME/install-plugins
  assert_success
  refute_line --partial 'Skipping already bundled dependency'
  # replace DOS line endings \r\n
  run bash -c "docker run --rm $SUT_IMAGE-install-plugins ls --color=never -1 /var/jenkins_home/plugins | tr -d '\r'"
  assert_success
  assert_line 'maven-plugin.jpi'
  assert_line 'maven-plugin.jpi.pinned'
  assert_line 'ant.jpi'
  assert_line 'ant.jpi.pinned'
  assert_line 'credentials.jpi'
  assert_line 'credentials.jpi.pinned'
  assert_line 'mesos.jpi'
  assert_line 'mesos.jpi.pinned'
  # optional dependencies
  refute_line 'metrics.jpi'
  refute_line 'metrics.jpi.pinned'
  # plugins bundled but under detached-plugins, so need to be installed
  assert_line 'javadoc.jpi'
  assert_line 'javadoc.jpi.pinned'
  assert_line 'mailer.jpi'
  assert_line 'mailer.jpi.pinned'
}

@test "plugins are installed with install-plugins.sh even when already exist" {
  run docker build -t $SUT_IMAGE-install-plugins-update --no-cache $BATS_TEST_DIRNAME/install-plugins/update
  assert_success
  assert_line "Using provided plugin: ant"
  refute_line --partial 'Skipping already bundled dependency'
  # replace DOS line endings \r\n
  run bash -c "docker run --rm $SUT_IMAGE-install-plugins-update unzip -p /var/jenkins_home/plugins/maven-plugin.jpi META-INF/MANIFEST.MF | tr -d '\r'"
  assert_success
  assert_line 'Plugin-Version: 2.13'
}

@test "plugins are getting upgraded but not downgraded" {
  # Initial execution
  run docker build -t $SUT_IMAGE-install-plugins $BATS_TEST_DIRNAME/install-plugins
  assert_success
  local work; work="$BATS_TEST_DIRNAME/upgrade-plugins/work"
  mkdir -p $work
  # Image contains maven-plugin 2.7.1 and ant-plugin 1.3
  run bash -c "docker run -u $UID -v $work:/var/jenkins_home --rm $SUT_IMAGE-install-plugins true"
  assert_success
  run unzip_manifest maven-plugin.jpi $work
  assert_line 'Plugin-Version: 2.7.1'
  run unzip_manifest ant.jpi $work
  assert_line 'Plugin-Version: 1.3'

  # Upgrade to new image with different plugins
  run docker build -t $SUT_IMAGE-upgrade-plugins $BATS_TEST_DIRNAME/upgrade-plugins
  assert_success
  # Images contains maven-plugin 2.13 and ant-plugin 1.2
  run bash -c "docker run -u $UID -v $work:/var/jenkins_home --rm $SUT_IMAGE-upgrade-plugins true"
  assert_success
  run unzip_manifest maven-plugin.jpi $work
  assert_success
  # Should be updated
  assert_line 'Plugin-Version: 2.13'
  run unzip_manifest ant.jpi $work
  # 1.2 is older than the existing 1.3, so keep 1.3
  assert_line 'Plugin-Version: 1.3'
}

@test "clean work directory" {
    run bash -c "rm -rf $BATS_TEST_DIRNAME/upgrade-plugins/work"
}

@test "do not upgrade if plugin has been manually updated" {
  run docker build -t $SUT_IMAGE-install-plugins $BATS_TEST_DIRNAME/install-plugins
  assert_success
  local work; work="$BATS_TEST_DIRNAME/upgrade-plugins/work"
  mkdir -p $work
  # Image contains maven-plugin 2.7.1 and ant-plugin 1.3
  run bash -c "docker run -u $UID -v $work:/var/jenkins_home --rm $SUT_IMAGE-install-plugins curl --connect-timeout 20 --retry 5 --retry-delay 0 --retry-max-time 60 -s -f -L https://updates.jenkins.io/download/plugins/maven-plugin/2.12.1/maven-plugin.hpi -o /var/jenkins_home/plugins/maven-plugin.jpi"
  assert_success
  run unzip_manifest maven-plugin.jpi $work
  assert_line 'Plugin-Version: 2.12.1'
  run docker build -t $SUT_IMAGE-upgrade-plugins $BATS_TEST_DIRNAME/upgrade-plugins
  assert_success
  # Images contains maven-plugin 2.13 and ant-plugin 1.2
  run bash -c "docker run -u $UID -v $work:/var/jenkins_home --rm $SUT_IMAGE-upgrade-plugins true"
  assert_success
  run unzip_manifest maven-plugin.jpi $work
  assert_success
  # Shouldn't be updated
  refute_line 'Plugin-Version: 2.13'
}

@test "clean work directory" {
    run bash -c "rm -rf $BATS_TEST_DIRNAME/upgrade-plugins/work"
}
