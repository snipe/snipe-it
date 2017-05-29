# Official Jenkins Docker image

The Jenkins Continuous Integration and Delivery server.

This is a fully functional Jenkins server, based on the Long Term Support release.
[http://jenkins.io/](http://jenkins.io/).

For weekly releases check out [`jenkinsci/jenkins`](https://hub.docker.com/r/jenkinsci/jenkins/)


<img src="http://jenkins-ci.org/sites/default/files/jenkins_logo.png"/>


# Usage

```
docker run -p 8080:8080 -p 50000:50000 jenkins
```

NOTE: read below the _build executors_ part for the role of the `50000` port mapping.

This will store the workspace in /var/jenkins_home. All Jenkins data lives in there - including plugins and configuration.
You will probably want to make that an explicit volume so you can manage it and attach to another container for upgrades :

```
docker run -p 8080:8080 -p 50000:50000 -v jenkins_home:/var/jenkins_home jenkins
```

this will automatically create a 'jenkins_home' volume on docker host, that will survive container stop/restart/deletion. 

Avoid using a bind mount from a folder on host into `/var/jenkins_home`, as this might result in file permission issue. If you _really_ need to bind mount jenkins_home, ensure that directory on host is accessible by the jenkins user in container (jenkins user - uid 1000) or use `-u some_other_user` parameter with `docker run`.

## Backing up data

If you bind mount in a volume - you can simply back up that directory
(which is jenkins_home) at any time.

This is highly recommended. Treat the jenkins_home directory as you would a database - in Docker you would generally put a database on a volume.

If your volume is inside a container - you can use ```docker cp $ID:/var/jenkins_home``` command to extract the data, or other options to find where the volume data is.
Note that some symlinks on some OSes may be converted to copies (this can confuse jenkins with lastStableBuild links etc)

For more info check Docker docs section on [Managing data in containers](https://docs.docker.com/engine/tutorials/dockervolumes/)

# Setting the number of executors

You can specify and set the number of executors of your Jenkins master instance using a groovy script. By default its set to 2 executors, but you can extend the image and change it to your desired number of executors :

`executors.groovy`
```
import jenkins.model.*
Jenkins.instance.setNumExecutors(5)
```

and `Dockerfile`

```
FROM jenkins
COPY executors.groovy /usr/share/jenkins/ref/init.groovy.d/executors.groovy
```


# Attaching build executors

You can run builds on the master out of the box.

But if you want to attach build slave servers **through JNLP (Java Web Start)**: make sure you map the port: ```-p 50000:50000``` - which will be used when you connect a slave agent.

If you are only using [SSH slaves](https://wiki.jenkins-ci.org/display/JENKINS/SSH+Slaves+plugin), then you do **NOT** need to put that port mapping.

# Passing JVM parameters

You might need to customize the JVM running Jenkins, typically to pass system properties or tweak heap memory settings. Use JAVA_OPTS environment
variable for this purpose :

```
docker run --name myjenkins -p 8080:8080 -p 50000:50000 --env JAVA_OPTS=-Dhudson.footerURL=http://mycompany.com jenkins
```

# Configuring logging

Jenkins logging can be configured through a properties file and `java.util.logging.config.file` Java property.
For example:

```
mkdir data
cat > data/log.properties <<EOF
handlers=java.util.logging.ConsoleHandler
jenkins.level=FINEST
java.util.logging.ConsoleHandler.level=FINEST
EOF
docker run --name myjenkins -p 8080:8080 -p 50000:50000 --env JAVA_OPTS="-Djava.util.logging.config.file=/var/jenkins_home/log.properties" -v `pwd`/data:/var/jenkins_home jenkins
```

# Configuring reverse proxy
If you want to install Jenkins behind a reverse proxy with prefix, example: mysite.com/jenkins, you need to add environnement variable `JENKINS_OPTS="--prefix=/jenkins"` and then follow the below procedures to configure your reverse proxy, which will depend if you have Apache ou Nginx:
- [Apache](https://wiki.jenkins-ci.org/display/JENKINS/Running+Jenkins+behind+Apache)
- [Nginx](https://wiki.jenkins-ci.org/display/JENKINS/Jenkins+behind+an+NGinX+reverse+proxy)

# Passing Jenkins launcher parameters

Argument you pass to docker running the jenkins image are passed to jenkins launcher, so you can run for sample :
```
docker run jenkins --version
```
This will dump Jenkins version, just like when you run jenkins as an executable war.

You also can define jenkins arguments as `JENKINS_OPTS`. This is usefull to define a set of arguments to pass to jenkins launcher as you
define a derived jenkins image based on the official one with some customized settings. The following sample Dockerfile uses this option
to force use of HTTPS with a certificate included in the image

```
FROM jenkins:1.565.3

COPY https.pem /var/lib/jenkins/cert
COPY https.key /var/lib/jenkins/pk
ENV JENKINS_OPTS --httpPort=-1 --httpsPort=8083 --httpsCertificate=/var/lib/jenkins/cert --httpsPrivateKey=/var/lib/jenkins/pk
EXPOSE 8083
```

You can also change the default slave agent port for jenkins by defining `JENKINS_SLAVE_AGENT_PORT` in a sample Dockerfile.

```
FROM jenkins:1.565.3
ENV JENKINS_SLAVE_AGENT_PORT 50001
```
or as a parameter to docker,
```
docker run --name myjenkins -p 8080:8080 -p 50001:50001 --env JENKINS_SLAVE_AGENT_PORT=50001 jenkins
```

# Installing more tools

You can run your container as root - and install via apt-get, install as part of build steps via jenkins tool installers, or you can create your own Dockerfile to customise, for example:

```
FROM jenkins
# if we want to install via apt
USER root
RUN apt-get update && apt-get install -y ruby make more-thing-here
# drop back to the regular jenkins user - good practice
USER jenkins
```

In such a derived image, you can customize your jenkins instance with hook scripts or additional plugins.
For this purpose, use `/usr/share/jenkins/ref` as a place to define the default JENKINS_HOME content you
wish the target installation to look like :

```
FROM jenkins
COPY custom.groovy /usr/share/jenkins/ref/init.groovy.d/custom.groovy
```

## Preinstalling plugins

You can rely on the `install-plugins.sh` script to pass a set of plugins to download with their dependencies.
Use plugin artifact ID, whithout `-plugin` extension, and append the version if needed separated by `:`.
Dependencies that are already included in the Jenkins war will only be downloaded if their required version is newer than the one included.

```
FROM jenkins
RUN /usr/local/bin/install-plugins.sh docker-slaves github-branch-source:1.8
```

When jenkins container starts, it will check `JENKINS_HOME` has this reference content, and copy them
there if required. It will not override such files, so if you upgraded some plugins from UI they won't
be reverted on next start.

In case you *do* want to override, append '.override' to the name of the reference file. E.g. a file named
`/usr/share/jenkins/ref/config.xml.override` will overwrite an existing `config.xml` file in JENKINS_HOME.

Also see [JENKINS-24986](https://issues.jenkins-ci.org/browse/JENKINS-24986)


Here is an example to get the list of plugins from an existing server:

```
JENKINS_HOST=username:password@myhost.com:port
curl -sSL "http://$JENKINS_HOST/pluginManager/api/xml?depth=1&xpath=/*/*/shortName|/*/*/version&wrapper=plugins" | perl -pe 's/.*?<shortName>([\w-]+).*?<version>([^<]+)()(<\/\w+>)+/\1 \2\n/g'|sed 's/ /:/'
```

Example Output:

```
cucumber-testresult-plugin:0.8.2
pam-auth:1.1
matrix-project:1.4.1
script-security:1.13
...
```

For 2.x-derived images, you may also want to

    RUN echo 2.0 > /usr/share/jenkins/ref/jenkins.install.UpgradeWizard.state

to indicate that this Jenkins installation is fully configured.
Otherwise a banner will appear prompting the user to install additional plugins,
which may be inappropriate.

# Upgrading

All the data needed is in the /var/jenkins_home directory - so depending on how you manage that - depends on how you upgrade. Generally - you can copy it out - and then "docker pull" the image again - and you will have the latest LTS - you can then start up with -v pointing to that data (/var/jenkins_home) and everything will be as you left it.

As always - please ensure that you know how to drive docker - especially volume handling!

## Upgrading plugins

By default, plugins will be upgraded if they haven't been upgraded manually and if the version from the docker image is newer than the version in the container. Versions installed by the docker image are tracked through a marker file.

The default behaviour when upgrading from a docker image that didn't write marker files is to leave existing plugins in place. If you want to upgrade existing plugins without marker you may run the docker image with `-e TRY_UPGRADE_IF_NO_MARKER=true`. Then plugins will be upgraded if the version provided by the docker image is newer.

# Building

Build with the usual

    docker build -t jenkins .

Tests are written using [bats](https://github.com/sstephenson/bats) under the `tests` dir

    bats tests

Bats can be easily installed with `brew install bats` on OS X

# Questions?

Jump on irc.freenode.net and the #jenkins room. Ask!
