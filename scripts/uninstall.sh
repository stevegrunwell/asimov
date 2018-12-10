#!/usr/bin/env bash

# Uninstall Asimov.
#
# @author  Steve Grunwell
# @license MIT

# shellcheck disable=SC1091
source "$(pwd -P)/$(dirname $0)/vars"

echo -e "\\n\\033[0;36mRemoving command ${BIN}\\033[0m";
[[ -f ${BIN} ]] && rm "${BIN}"

if launchctl list | grep -q com.stevegrunwell.asimov; then
  echo -e "\\n\\033[0;36mUnloading current instance of ${PLIST}\\033[0m";
  launchctl unload "${DIR}/${PLIST}"
fi

echo -e "\\n\\033[0;32mAsimov has been successfully uninstalled.\\033[0m";
