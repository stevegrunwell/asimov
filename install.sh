#!/usr/bin/env bash

# Install Asimov as a launchd daemon.
#
# @author  Steve Grunwell
# @license MIT

DIR="$(cd "$(dirname "$0")" || return; pwd -P)"
PLIST="com.stevegrunwell.asimov.plist"

# Verify that Asimov is executable.
chmod +x ./asimov

# Symlink Asimov into /usr/local/bin.
echo -e "\\033[0;36mSymlinking ${DIR} to /usr/local/bin/asimov\\033[0m"
ln -si "${DIR}/asimov" /usr/local/bin/asimov

# If it's already loaded, unload first.
if launchctl list | grep -q com.stevegrunwell.asimov; then
    echo -e "\\n\\033[0;36mUnloading current instance of ${PLIST}\\033[0m";
    launchctl unload "${DIR}/${PLIST}"
fi

# Load the .plist file.
launchctl load "${DIR}/${PLIST}" && echo -e "\\n\\033[0;32mAsimov daemon has been loaded!\\033[0m";

# Run Asimov for the first time.
"${DIR}/asimov"
