COMPOSER=composer
CONSOLE=php bin/console
GIT=git
PHPUNIT=php vendor/phpunit/phpunit/phpunit
OPENSSL=openssl

### Development

help: ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

server: ## Launcher server
	$(CONSOLE) server:start

cache: ## Clear cache
	$(CONSOLE) cache:clear
	$(CONSOLE) cache:clear --env=test
	$(CONSOLE) cache:clear --env=prod

bash: ## Launch bash on workspace laradock container
	$(LARADOCK) docker-compose exec workspace bash

routes: ## Display routes
	$(CONSOLE) debug:router

.PHONY: server cache laradock bash routes

### Build

install: ## Install dependencies, update databse, update fixtures, clear cache
	composer-install db-update db-fixtures cache ssh-keys

update: ## Update git sources, renew dependencies, update databse, update fixtures, clear cache
	git-update composer-renew db-update db-fixtures cache

ssh-keys: ## Generate SSH keys
	$(OPENSSL) genrsa -out var/jwt/private.pem -aes256 4096
	$(OPENSSL) rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem

.PHONY: install update ssh-keys

### Sources

git-update: ## Update sources
	$(GIT) stash
	$(GIT) checkout develop
	$(GIT) pull
	$(GIT) stash pop || :

.PHONY: git-update

### Vendors

composer-install: ## Install dependencies
	$(COMPOSER) install

composer-renew: ## Renew dependencies
	rm composer.lock
	$(COMPOSER) install

.PHONY: composer-install composer-renew

### Database

db-update: ## Update database schema
	$(CONSOLE) doctrine:schema:update --force

db-diff: ## Display database schema diff
	$(CONSOLE) doctrine:schema:update --dump-sql

db-fixtures: ## Update database fixtures
	$(CONSOLE) doctrine:fixtures:load --fixtures=src/I360/ApplicationFixtures/ --append

.PHONY: db-update db-diff db-fixtures

### Tests

tests: ## Execute all tests
	$(PHPUNIT) --configuration phpunit.xml.dist --coverage-text -d zend.enable_gc=0

unit-tests: ## Execute unit tests
	$(PHPUNIT) --testsuite=unit-tests --configuration phpunit.xml.dist -d zend.enable_gc=0

functional-tests: ## Execute functional tests
	$(PHPUNIT) --testsuite=functional-tests --configuration phpunit.xml.dist -d zend.enable_gc=0

.PHONY: tests unit-tests functional-tests
