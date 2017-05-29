#!/bin/bash -eu

# Publish any versions of the docker image not yet pushed to jenkinsci/jenkins
# Arguments:
#   -n dry run, do not build or publish images

set -o pipefail

sort-versions() {
    if [ "$(uname)" == 'Darwin' ]; then
        gsort --version-sort
    else
        sort --version-sort
    fi
}

# Try tagging with and without -f to support all versions of docker
docker-tag() {
    local from="jenkinsci/jenkins:$1"
    local to="jenkinsci/jenkins:$2"
    local out
    if out=$(docker tag -f "$from" "$to" 2>&1); then
        echo "$out"
    else
        docker tag "$from" "$to"
    fi
}

get-variant() {
    local branch
    branch=$(git show-ref | grep $(git rev-list -n 1 HEAD) | tail -1 | rev | cut -d/ -f 1 | rev)
    if [ -z "$branch" ]; then
        >&2 echo "Could not get the current branch name for commit, not in a branch?: $(git rev-list -n 1 HEAD)"
        return 1
    fi
    case "$branch" in
        master) echo "" ;;
        *) echo "-${branch}" ;;
    esac
}

login-token() {
    # could use jq .token
    curl -q -sSL https://auth.docker.io/token\?service\=registry.docker.io\&scope\=repository:jenkinsci/jenkins:pull | grep -o '"token":"[^"]*"' | cut -d':' -f 2 | xargs echo
}

is-published() {
    get-manifest "$1" &> /dev/null
}

get-manifest() {
    local tag=$1
    curl -q -fsSL -H "Accept: application/vnd.docker.distribution.manifest.v2+json" -H "Authorization: Bearer $TOKEN" "https://index.docker.io/v2/jenkinsci/jenkins/manifests/$tag"
}

get-digest() {
    #get-manifest "$1" | jq .config.digest
    get-manifest "$1" | grep -A 10 -o '"config".*' | grep digest | head -1 | cut -d':' -f 2,3 | xargs echo
}

get-latest-versions() {
    curl -q -fsSL https://api.github.com/repos/jenkinsci/jenkins/tags?per_page=20 | grep '"name": "jenkins-' | egrep -o '[0-9]+(\.[0-9]+)+' | sort-versions | uniq
}

publish() {
    local version=$1
    local variant=$2
    local tag="${version}${variant}"
    local sha
    local build_opts="--no-cache --pull"

    sha=$(curl -q -fsSL "http://repo.jenkins-ci.org/simple/releases/org/jenkins-ci/main/jenkins-war/${version}/jenkins-war-${version}.war.sha1")

    docker build --build-arg "JENKINS_VERSION=$version" \
                 --build-arg "JENKINS_SHA=$sha" \
                 --tag "jenkinsci/jenkins:${tag}" ${build_opts} .

    docker push "jenkinsci/jenkins:${tag}"
}

tag-and-push() {
    local source=$1
    local target=$2
    local digest_source; digest_source=$(get-digest ${tag1})
    local digest_target; digest_target=$(get-digest ${tag2})
    if [ "$digest_source" == "$digest_target" ]; then
        echo "Images ${source} [$digest_source] and ${target} [$digest_target] are already the same, not updating tags"
    else
        echo "Creating tag ${target} pointing to ${source}"
        if [ ! "$dry_run" = true ]; then
            docker-tag "jenkinsci/jenkins:${source}" "jenkinsci/jenkins:${target}"
            docker push "jenkinsci/jenkins:${source}"
        fi
    fi
}

publish-latest() {
    local version=$1
    local variant=$2

    # push latest (for master) or the name of the branch (for other branches)
    if [ -z "${variant}" ]; then
        tag-and-push "${version}${variant}" "latest"
    else
        tag-and-push "${version}${variant}" "${variant#-}"
    fi
}

publish-lts() {
    local version=$1
    local variant=$2
    tag-and-push "${version}" "lts${variant}"
}

dry_run=false
if [ "-n" == "${1:-}" ]; then
    dry_run=true
fi
if [ "$dry_run" = true ]; then
    echo "Dry run, will not build or publish images"
fi

TOKEN=$(login-token)

variant=$(get-variant)

lts_version=""
version=""
for version in $(get-latest-versions); do
    if is-published "$version$variant"; then
        echo "Tag is already published: $version$variant"
    else
        echo "Publishing version: $version$variant"
        if [ ! "$dry_run" = true ]; then
            publish "$version" "$variant"
        fi
    fi

    # Update lts tag
    if [[ "$version" =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        lts_version="${version}"
    fi
done

publish-latest "${version}" "${variant}"
if [ -n "${lts_version}" ]; then
    publish-lts "${lts_version}" "${variant}"
fi
