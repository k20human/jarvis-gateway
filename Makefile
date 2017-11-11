COMPOSER=composer
CONSOLE=php bin/console
GIT=git
PHPUNIT=php vendor/phpunit/phpunit/phpunit

### Development

help: ## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

server: ## Launcher server
	$(CONSOLE) server:start

cache: ## Clear cache
	$(CONSOLE) cache:clear
	$(CONSOLE) cache:clear --env=test
	$(CONSOLE) cache:clear --env=prod

routes: ## Display routes
	$(CONSOLE) debug:router

.PHONY: server cache routes

### Build

install: ## Install dependencies, update databse, update fixtures, clear cache
	composer-install db-update db-fixtures cache ssh-keys

update: ## Update git sources, renew dependencies, update databse, update fixtures, clear cache
	git-update composer-renew db-update db-fixtures cache

.PHONY: install update ssh-keys

### Commands

create-user: ## Create user in database
	$(CONSOLE) app:create-user

.PHONY: create-user

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
	$(CONSOLE) doctrine:fixtures:load --fixtures=src/Jarvis/ApplicationFixtures/ --append

.PHONY: db-update db-diff db-fixtures

### Tests

tests: ## Execute all tests
	$(PHPUNIT) --configuration phpunit.xml.dist --coverage-text -d zend.enable_gc=0

unit-tests: ## Execute unit tests
	$(PHPUNIT) --testsuite=unit-tests --configuration phpunit.xml.dist -d zend.enable_gc=0

functional-tests: ## Execute functional tests
	$(PHPUNIT) --testsuite=functional-tests --configuration phpunit.xml.dist -d zend.enable_gc=0

.PHONY: tests unit-tests functional-tests
