#!/usr/bin/env bash

# Install Asimov as a launchd daemon.
#
# @author  Steve Grunwell
# @license MIT

# shellcheck disable=SC1091
source "$(pwd -P)/$(dirname $0)/vars"

# Verify that Asimov is executable.
chmod +x "${DIR}/asimov"

# Copy Asimov into /usr/local/bin.
echo -e "\\033[0;36mInstalling to ${BIN}\\033[0m"
cp -a "${DIR}/asimov" "${BIN}"

# Ensure daemon is not already loaded.
if launchctl list | grep -q com.stevegrunwell.asimov; then
  echo -e "\\n\\033[0;36mUnloading current instance of ${PLIST}\\033[0m";
  launchctl unload "${DIR}/${PLIST}"
fi

# Load the .plist file.
launchctl load "${DIR}/${PLIST}" && echo -e "\\n\\033[0;32mAsimov daemon has been loaded!\\033[0m";

# Run Asimov for the first time.
echo -e "\\nRun Asimov immediately with \\033[0;35m${BIN}\\033[0m"
