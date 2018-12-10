# Asimov

[![Build Status](https://travis-ci.com/stevegrunwell/asimov.svg?branch=master)](https://travis-ci.com/stevegrunwell/asimov)

> Those people who think they know everything are a great annoyance to those of us who do.<br>— Issac Asimov

For macOS users, [Time Machine](https://support.apple.com/en-us/HT201250) is a no-frills, set-it-and-forget-it solution for on-site backups. Plug in an external hard drive (or configure a network storage drive), and your Mac's files are backed up.

For the average consumer, Time Machine is an excellent choice, especially considering many Mac owners may _only_ have Time Machine as a backup strategy. For developers, however, Time Machine presents a problem: **how do I keep project dependencies from taking up space on my Time Machine drive?**

Asimov aims to solve that problem, scanning your filesystem for known dependency directories (e.g. `node_modules/` living adjacent to a `package.json` file) and excluding them from Time Machine backups. After all, why eat up space on your backup drive for something you could easily restore via `npm install`?

## Installation

To get started with Asimov, clone the repository or download and extract an archive anywhere you'd like on your Mac:

```sh
$ git clone git@github.com:stevegrunwell/asimov.git
```

After you've cloned the repository:
* [Optional] before installing, you can edit `com.stevegrunwell.asimov.plist` to change the scheduling of Asimov (default to once a day).
* Run `make` to automatically:
  * Copy Asimov to `/usr/local/bin`, making it readily available from anywhere.
  * Schedule Asimov, ensuring new projects' dependencies are quickly excluded from Time Machine backups.
  * Run Asimov for the first time, finding all current project dependencies adding them to Time Machine's exclusion list.

## Uninstall

Simply run `make uninstall` from your cloned repository.

## How it works

At its essence, Asimov is a simple wrapper around Apple's `tmutil` program, which provides more granular control over Time Machine.

Asimov finds recognized dependency directories, verifies that the corresponding dependency file exists and, if so, tells Time Machine not to worry about backing up the dependency directory.

Don't worry about running it multiple times, either. Asimov is smart enough to see if a directory has already been marked for exclusion.

### Retrieving excluded files

If you'd like to see all of the directories and files that have been excluded from Time Machine, you can do so by running the following command ([props Brant Bobby on StackOverflow](https://apple.stackexchange.com/a/25833/206772)):

```bash
$ sudo mdfind "com_apple_backup_excludeItem = 'com.apple.backupd'"
```

If a directory has been excluded from backups in error, you can remove the exclusion using `tmutil`:

```bash
$ tmutil removeexclusion /path/to/directory
```
