#!/bin/bash -eu

# Generate the Docker official-images file

sha() {
    local branch=$1
    git rev-parse $branch
}

version_from_dockerfile() {
    local branch=$1
    git show $branch:Dockerfile | grep JENKINS_VERSION: | sed -e 's/.*:-\(.*\)}/\1/'
}

master_sha=$(sha master)
alpine_sha=$(sha alpine)

master_version=$(version_from_dockerfile master)
alpine_version=$(version_from_dockerfile alpine)

if ! [ "$master_version" == "$alpine_version" ]; then
    echo "Master version '$master_version' does not match alpine version '$alpine_version'"
    exit 1
fi

cat << EOF > ../official-images/library/jenkins
# maintainer: Nicolas De Loof <nicolas.deloof@gmail.com> (@ndeloof)
# maintainer: Michael Neale <mneale@cloudbees.com> (@michaelneale)
# maintainer: Carlos Sanchez <csanchez@cloudbees.com> (@carlossg)

latest: git://github.com/jenkinsci/jenkins-ci.org-docker@$master_sha
$master_version: git://github.com/jenkinsci/jenkins-ci.org-docker@$master_sha

alpine: git://github.com/jenkinsci/jenkins-ci.org-docker@$alpine_sha
$alpine_version-alpine: git://github.com/jenkinsci/jenkins-ci.org-docker@$alpine_sha
EOF
