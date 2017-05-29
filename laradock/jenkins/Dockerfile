FROM openjdk:8-jdk

RUN apt-get update && apt-get install -y git curl && rm -rf /var/lib/apt/lists/*

ENV JENKINS_HOME /var/jenkins_home
ENV JENKINS_SLAVE_AGENT_PORT 50000

ARG user=jenkins
ARG group=jenkins
ARG uid=1000
ARG gid=1000

# Jenkins is run with user `jenkins`, uid = 1000
# If you bind mount a volume from the host or a data container, 
# ensure you use the same uid
RUN groupadd -g ${gid} ${group} \
    && useradd -d "$JENKINS_HOME" -u ${uid} -g ${gid} -m -s /bin/bash ${user}

# Jenkins home directory is a volume, so configuration and build history 
# can be persisted and survive image upgrades
VOLUME /var/jenkins_home

# `/usr/share/jenkins/ref/` contains all reference configuration we want 
# to set on a fresh new installation. Use it to bundle additional plugins 
# or config file with your custom jenkins Docker image.
RUN mkdir -p /usr/share/jenkins/ref/init.groovy.d

ENV TINI_VERSION 0.13.2
ENV TINI_SHA afbf8de8a63ce8e4f18cb3f34dfdbbd354af68a1

# Use tini as subreaper in Docker container to adopt zombie processes 
RUN curl -fsSL https://github.com/krallin/tini/releases/download/v${TINI_VERSION}/tini-static-amd64 -o /bin/tini && chmod +x /bin/tini \
  && echo "$TINI_SHA  /bin/tini" | sha1sum -c -

COPY init.groovy /usr/share/jenkins/ref/init.groovy.d/tcp-slave-agent-port.groovy

# jenkins version being bundled in this docker image
ARG JENKINS_VERSION
ENV JENKINS_VERSION ${JENKINS_VERSION:-2.32.3}

# jenkins.war checksum, download will be validated using it
ARG JENKINS_SHA=a25b9a314ca9e76f9673da7309e1882e32674223

# Can be used to customize where jenkins.war get downloaded from
ARG JENKINS_URL=https://repo.jenkins-ci.org/public/org/jenkins-ci/main/jenkins-war/${JENKINS_VERSION}/jenkins-war-${JENKINS_VERSION}.war

# could use ADD but this one does not check Last-Modified header neither does it allow to control checksum 
# see https://github.com/docker/docker/issues/8331
RUN curl -fsSL ${JENKINS_URL} -o /usr/share/jenkins/jenkins.war \
  && echo "${JENKINS_SHA}  /usr/share/jenkins/jenkins.war" | sha1sum -c -

ENV JENKINS_UC https://updates.jenkins.io
RUN chown -R ${user} "$JENKINS_HOME" /usr/share/jenkins/ref


# Add jenkins to the correct group
# see http://stackoverflow.com/questions/42164653/docker-in-docker-permissions-error
# use "getent group docker | awk -F: '{printf "%d\n", $3}'" command on host to find correct value for gid or simply use 'id'
ARG DOCKER_GID=998

RUN groupadd -g ${DOCKER_GID} docker \
  && curl -sSL https://get.docker.com/ | sh \
  && apt-get -q autoremove \
  && apt-get -q clean -y \
  && rm -rf /var/lib/apt/lists/* /var/cache/apt/*.bin

# Install Docker-in-Docker from git@github.com:jpetazzo/dind.git
# RUN apt-get update -qq && apt-get install -qqy apt-transport-https ca-certificates curl lxc iptables
# Install Docker from Docker Inc. repositories.
RUN apt-get install -y curl && curl -sSL https://get.docker.com/ | sh
RUN usermod -aG docker jenkins

# Install Docker-Compose
RUN curl -L "https://github.com/docker/compose/releases/download/1.10.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
RUN chmod +x /usr/local/bin/docker-compose


# for main web interface:
EXPOSE 8080

# will be used by attached slave agents:
EXPOSE 50000

ENV COPY_REFERENCE_FILE_LOG $JENKINS_HOME/copy_reference_file.log

USER ${user}

COPY jenkins-support /usr/local/bin/jenkins-support
COPY jenkins.sh /usr/local/bin/jenkins.sh
ENTRYPOINT ["/bin/tini", "--", "/usr/local/bin/jenkins.sh"]

# from a derived Dockerfile, can use `RUN plugins.sh active.txt` to setup /usr/share/jenkins/ref/plugins from a support bundle
COPY plugins.sh /usr/local/bin/plugins.sh
COPY install-plugins.sh /usr/local/bin/install-plugins.sh

# Only need below if we are starting from empty jenkins_home
## Copy the RSA keys
#RUN mkdir -p /var/jenkins_home/.ssh
#RUN chown jenkins:jenkins /var/jenkins_home/.ssh
#COPY keys/id_rsa /var/jenkins_home/.ssh/id_rsa.pub
#COPY keys/id_rsa /var/jenkins_home/.ssh/id_rsa
#COPY keys/known_hosts /var/jenkins_home/.ssh/known_hosts
#
#USER root
#RUN chmod 600 /var/jenkins_home/.ssh/id_rsa
#RUN chmod 644 /var/jenkins_home/.ssh/id_rsa.pub
## ssh-keyscan -H github.com >> ~/.ssh/known_hosts
## ssh-keyscan -H bitbucket.org >> ~/.ssh/known_hosts
