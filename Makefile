.PHONY: update-version artifact

.DEFAULT_GOAL := help

UNAME_S := $(shell uname -s)

update-version: ## Setup package version in manifests
	@VERSION=$(or $(VERSION),$(shell git describe --tags --always)) && \
	if [ "$(UNAME_S)" = "Darwin" ]; then \
		SED_INPLACE="sed -i ''"; \
	else \
		SED_INPLACE="sed -i"; \
	fi && \
	find . -type f \
		-not -path './vendor/*' \
		-not -path './.git/*' \
		-not -path './.idea/*' \
		-not -path './README*' \
		-exec $$SED_INPLACE -E 's/(@version\s*\t*|<version>)([0-9a-zA-Z_.-]+)/\1'"$$VERSION"'/' {} +

artifact: ## Build artifact
	@rm -f plg_content_langos.zip
	@zip -r plg_content_langos.zip \
		./language/* \
		./services/* \
		./src/* \
		./script.php \
		./langos.xml \
		./LICENSE

install-dev: ## Install composer dev dependencies
	composer install --no-progress --prefer-dist --optimize-autoloader

php-cs-fixer:
	./vendor/bin/php-cs-fixer fix --dry-run --diff --verbose

php-cs-fixer-fix:
	./vendor/bin/php-cs-fixer fix

help: ## Show current help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' ./Makefile | sort | \
	awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'