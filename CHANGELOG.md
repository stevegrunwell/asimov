# Asimov Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Added

* Added Homebrew support 🙌 ([#34], props @Dids)
* Exclude Bower dependencies ([#22], props @moezzie)
* Exclude Maven builds ([#30], props @bertschneider)
* Exclude Stack dependencies ([#32], props @alex-kononovich)
* Exclude Carthage dependencies ([#37], props @qvacua)
* Exclude CocoaPods dependencies and Swift builds ([#43], props @slashmo)
* Define a [Travis CI pipeline for Asimov](https://travis-ci.com/github/stevegrunwell/asimov) ([#20])
* Add an automated test suite using PHPUnit ([#31])

### Fixed

* Removed an extraneous `read -r path`, which was causing the first match to be skipped ([#15], props @rowanbeentje)
* Use the full system path when running `chmod` in `install.sh` ([#33], props @ko-dever)

### Changed

* The size of the excluded directories are now included in the Asimov output ([#16], props @rowanbeentje)
* Switch to using find's -prune switch to exclude match subdirectories for speed, and exclude ~/Library folder from searches ([#17], props @rowanbeentje)
* Rework the `find` command and path variables so that `find` is only run once however many FILEPATHS are set ([#18], @props @rowanbeentje, yet again 😉)
 Fix incorrect directory pruning, simplify path handling ([#36], props @rwe)
* Recommend cloning via HTTPS rather than SSH for manual installations ([#52], props @Artoria2e5)


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
[#15]: https://github.com/stevegrunwell/asimov/pull/15
[#16]: https://github.com/stevegrunwell/asimov/pull/16
[#17]: https://github.com/stevegrunwell/asimov/pull/17
[#18]: https://github.com/stevegrunwell/asimov/pull/18
[#20]: https://github.com/stevegrunwell/asimov/pull/20
[#22]: https://github.com/stevegrunwell/asimov/pull/22
[#30]: https://github.com/stevegrunwell/asimov/pull/30
[#31]: https://github.com/stevegrunwell/asimov/pull/31
[#32]: https://github.com/stevegrunwell/asimov/pull/32
[#33]: https://github.com/stevegrunwell/asimov/pull/33
[#34]: https://github.com/stevegrunwell/asimov/pull/34
[#36]: https://github.com/stevegrunwell/asimov/pull/36
[#37]: https://github.com/stevegrunwell/asimov/pull/37
[#43]: https://github.com/stevegrunwell/asimov/pull/43
[#52]: https://github.com/stevegrunwell/asimov/pull/52
