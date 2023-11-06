# Asimov


[![Build Status](https://travis-ci.com/stevegrunwell/asimov.svg?branch=develop)](https://travis-ci.com/stevegrunwell/asimov)
![Requires macOS 10.13 (High Sierra) or newer](https://img.shields.io/badge/macOS-10.13%20or%20higher-blue)
[![MIT license](https://img.shields.io/badge/license-MIT-green)](LICENSE.txt)

> Those people who think they know everything are a great annoyance to those of us who do.<br>— Issac Asimov

For macOS users, [Time Machine](https://support.apple.com/en-us/HT201250) is a no-frills, set-it-and-forget-it solution for on-site backups. Plug in an external hard drive (or configure a network storage drive), and your Mac's files are backed up.

For the average consumer, Time Machine is an excellent choice, especially considering many Mac owners may _only_ have Time Machine as a backup strategy. For developers, however, Time Machine presents a problem: **how do I keep project dependencies from taking up space on my Time Machine drive?**

Asimov aims to solve that problem, scanning your filesystem for known dependency directories (e.g. `node_modules/` living adjacent to a `package.json` file) and excluding them from Time Machine backups. After all, why eat up space on your backup drive for something you could easily restore via `npm install`?


## Installation

Asimov may be installed in a few different ways:

### Installation via Homebrew

The easiest way to install Asimov is through [Homebrew](https://brew.sh):

```sh
 brew install asimov
```

If you would prefer to use the latest development release, you may append the `--head` flag:

```sh
 brew install asimov --head
```

Once installed, you may instruct Homebrew to automatically load the scheduled job, ensuring Asimov is being run automatically every day:

```sh
 sudo brew services start asimov
```

If you don't need or want the scheduled job, you may run Asimov on-demand:

```sh
 asimov
```

### Manual installation

If you would prefer to install Asimov manually, you can do so by cloning the repository (or downloading and extracting an archive of the source) anywhere on your Mac:

```sh
 git clone https://github.com/stevegrunwell/asimov.git --depth 1
```

After you've cloned the repository, run the `install.sh` script to automatically:
* Symlink Asimov to `/usr/local/bin`, making it readily available from anywhere.
* Schedule Asimov to run once a day, ensuring new projects' dependencies are quickly excluded from Time Machine backups.
* Run Asimov for the first time, finding all current project dependencies adding them to Time Machine's exclusion list.


## How it works

At its essence, Asimov is a simple wrapper around Apple's `tmutil` program, which provides more granular control over Time Machine.

Asimov finds recognized dependency directories, verifies that the corresponding dependency file exists and, if so, tells Time Machine not to worry about backing up the dependency directory.

Don't worry about running it multiple times, either. Asimov is smart enough to see if a directory has already been marked for exclusion.

### Retrieving excluded files

If you'd like to see all of the directories and files that have been excluded from Time Machine, you can do so by running the following command ([props Brant Bobby on StackOverflow](https://apple.stackexchange.com/a/25833/206772)):

```bash
 sudo mdfind "com_apple_backup_excludeItem = 'com.apple.backupd'"
```

If a directory has been excluded from backups in error, you can remove the exclusion using `tmutil`:

```bash
 tmutil removeexclusion /path/to/directory
```
