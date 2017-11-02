#!/usr/bin/env bash

# Install Asimov as a launchd daemon.
#
# @author  Steve Grunwell
# @license MIT

PLIST="com.stevegrunwell.asimov.plist"

# Symlink Asimov into /usr/local/bin.
echo -e "\\033[0;36mSymlinking ${PWD}/asimov to /usr/local/bin/asimov\\033[0m"
ln -si "${PWD}/asimov" /usr/local/bin/asimov

# If it's already loaded, unload first.
if launchctl list | grep -q com.stevegrunwell.asimov; then
    echo -e "\\n\\033[0;36mUnloading current instance of ${PLIST}\\033[0m";
    launchctl unload "$PLIST"
fi

# Load the .plist file.
launchctl load "$PLIST" && echo -e "\\n\\033[0;32mAsimov daemon has been loaded!\\033[0m";

# Run Asimov for the first time.
./asimov
