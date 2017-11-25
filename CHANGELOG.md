# Asimov Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).


## [0.2.0]

* Bundle the script with `com.stevegrunwell.asimov.plist`, enabling Asimov to be scheduled to run daily. Users can set this up in a single step by running the new `install.sh` script.
* Fixed pathing issue when resolving the script directory for `install.sh`. Props @morganestes. (#7)
* Change the scope of Asimov to find matching directories within the current user's home directory, not just `~/Sites`. Props to @vitch for catching this! (#10).
* Added a formal change log to the repository. (#5)


## [0.1.0]

Initial public release.


[Unreleased]: https://github.com/stevegrunwell/asimov/compare/master...develop
[0.2.0]: https://github.com/stevegrunwell/asimov/releases/tag/v0.2.0
[0.1.0]: https://github.com/stevegrunwell/asimov/releases/tag/v0.1.0
[#10]: https://github.com/stevegrunwell/asimov/issues/10
[#7]: https://github.com/stevegrunwell/asimov/issues/7
[#5]: https://github.com/stevegrunwell/asimov/issues/5