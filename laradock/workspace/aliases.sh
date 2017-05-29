#! /bin/bash

# Colors used for status updates
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"

# Commonly Used Aliases
alias ..="cd .."
alias c="clear"
alias cla="clear && ls -l"
alias cll="clear && ls -la"
alias cls="clear && ls"
alias code="cd /var/www"
alias ea="vi ~/aliases"
alias g="gulp"
alias home="cd ~"
alias npm-global="npm list -g --depth 0"
alias ra="reload"
alias reload="source ~/.aliases && echo \"$COL_GREEN ==> Aliases Reloaded... $COL_RESET \n \""
alias run="npm run"
alias tree="xtree"

# Laravel / PHP Alisases
alias art="php artisan"
alias artisan="php artisan"
alias cdump="composer dump-autoload -o"
alias composer:dump="composer dump-autoload -o"
alias db:reset="php artisan migrate:reset && php artisan migrate --seed"
alias migrate="php artisan migrate"
alias seed="php artisan:seed"
alias phpunit="./vendor/bin/phpunit"


# requires installation of 'https://www.npmjs.com/package/npms-cli'
alias npms="npms search"

# requires installation of 'https://www.npmjs.com/package/package-menu-cli'
alias pm="package-menu"

# requires installation of 'https://www.npmjs.com/package/pkg-version-cli'
alias pv="package-version"

# requires installation of 'https://github.com/sindresorhus/latest-version-cli'
alias lv="latest-version"

# git aliases
alias gaa="git add ."
alias gd="git --no-pager diff"
alias git-revert="git reset --hard && git clean -df"
alias gs="git status"
alias whoops="git reset --hard && git clean -df"


# Create a new directory and enter it
function mkd() {
    mkdir -p "$@" && cd "$@"
}

function md() {
    mkdir -p "$@" && cd "$@"
}

function xtree {
    find ${1:-.} -print | sed -e 's;[^/]*/;|____;g;s;____|; |;g'
}
