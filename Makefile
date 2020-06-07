all: install

.PHONY: install
install:
	@scripts/install.sh

.PHONY: uninstall
uninstall:
	@scripts/uninstall.sh
