#!/usr/bin/env sh

# Print a section header
section() {
  printf "\\n\\033[0;36m%s\\033[0;0m\\n" "$1"
}

# Print a warning message
notice() {
  printf "\\033[0;33m%s\\033[0;0m" "$1"
}

success() {
  printf "\\033[0;32m%s\\033[0;0m\\n" "$1"
}

section "Running unit tests:"

if type phpunit > /dev/null; then
  phpunit --testdox --colors=always || exit 1
else
  notice "PHPUnit is not installed.\\nYou may install test dependencies by running: composer install"
fi

section "Checking coding standards:"

if type shellcheck > /dev/null; then
  shellcheck asimov ./*.sh tests/bin/run-tests.sh || exit 1
  success "No problems detected!"
else
  notice "Shellcheck is not installed.\\nPlease visit https://www.shellcheck.net/ for installation options."
fi
