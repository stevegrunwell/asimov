# Asimov Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).


## [Version 0.2.0] — 2017-11-25

### Added

* Bundle the script with `com.stevegrunwell.asimov.plist`, enabling Asimov to be scheduled to run daily. Users can set this up in a single step by running the new `install.sh` script.
 Added a formal change log to the repository. ([#5])

### Fixed

* Fixed pathing issue when resolving the script directory for `install.sh`. Props @morganestes. ([#7])

### Changed
* Change the scope of Asimov to find matching directories within the current user's home directory, not just `~/Sites`. Props to @vitch for catching this! ([#10]).


## [Version 0.1.0] — 2017-10-17

Initial public release.


[Unreleased]: https://github.com/stevegrunwell/asimov/compare/master...develop
[Version 0.1.0]: https://github.com/stevegrunwell/asimov/releases/tag/v0.1.0
[Version 0.2.0]: https://github.com/stevegrunwell/asimov/releases/tag/v0.2.0
[#5]: https://github.com/stevegrunwell/asimov/issues/5
[#7]: https://github.com/stevegrunwell/asimov/issues/7
[#10]: https://github.com/stevegrunwell/asimov/issues/10
