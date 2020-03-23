.DEFAULT_GOAL := help
.PHONY: up down install db test.unit test.feature test.debug test test.coverage \
php.metrics.open php.cs php.cbf php.md build logs controller router \
composer.update composer.install composer.require db.migrate db.seed dependences docker-cleanup help

DOCKER_C := docker-compose -f docker-compose.yml
APP_NAME := app
DOCK_X_APP := $(DOCKER_C) exec $(APP_NAME)
DOCK_SHELL := $(DOCKER_C) run $(APP_NAME) /bin/sh

PHP_METRICS := /usr/local/lib/php-code-quality/vendor/bin/phpmetrics

VENDOR_CODECEPT := ./bin/phpunit
VENDOR_PHPCS := ./vendor/squizlabs/php_codesniffer/bin/phpcs
VENDOR_PHPCBF := ./vendor/squizlabs/php_codesniffer/bin/phpcbf
VENDOR_METRICS := ./vendor/phpmetrics/phpmetrics/bin/phpmetrics
VENDOR_PHPMD := ./vendor/bin/phpmd

OUTPUT_COVERAGE := tests/Reports/coverage/
OUTPUT_METRICS := tests/Reports/metrics_results/

up: ## Start docker container
	$(DOCKER_C) pull
	$(DOCKER_C) up -d

down: ## Stop docker container
	$(DOCKER_C) down

install: up composer.update ## Install the container & all the dependencies

shell: ## Stop docker container
	$(DOCK_SHELL)

test.unit: app/vendor ## Run unit tests suite
	$(DOCK_X_APP) php $(VENDOR_CODECEPT) --testsuite Unit

test.feature: app/vendor ## Run feature tests suite
	$(DOCK_X_APP) php $(VENDOR_CODECEPT) --testsuite Feature

test: app/vendor ## Run all available tests
	$(DOCK_X_APP) php $(VENDOR_CODECEPT)

test.debug: app/vendor ## Debug all available tests
	$(DOCK_X_APP) php $(VENDOR_CODECEPT) --debug

test.coverage: ## Check project test coverage
	$(DOCK_X_APP) php $(VENDOR_CODECEPT) --coverage-html $(OUTPUT_COVERAGE)
	open app/$(OUTPUT_COVERAGE)index.html >&- 2>&- || \
	xdg-open app/$(OUTPUT_COVERAGE)index.html >&- 2>&- || \
	gnome-open app/$(OUTPUT_COVERAGE)index.html >&- 2>&-

php.metrics: ## Run php metrics & open metrics web
	$(DOCKER_C) exec $(APP_NAME) php \
	$(VENDOR_METRICS) \
	--report-html=$(OUTPUT_METRICS) ./src 
	make php.metrics.open

php.metrics.open:
	open app/$(OUTPUT_METRICS)index.html >&- 2>&- || \
	xdg-open app/$(OUTPUT_METRICS)index.html >&- 2>&- || \
	gnome-open app/$(OUTPUT_METRICS)index.html >&- 2>&-

php.cs: ## Run php code sniffer
	$(DOCK_X_APP) php $(VENDOR_PHPCS) \
	-sv --extensions=php --standard=PSR12 --ignore=Kernel.php,Migrations ./src

php.cbf: ## Run php Code Beautifier and Fixer
	$(DOCK_X_APP) php $(VENDOR_PHPCBF) \
	-sv --extensions=php --standard=PSR12 --ignore=Kernel.php,Migrations ./src

php.md: ## Run php mess detector
	$(DOCK_X_APP) php $(VENDOR_PHPMD) ./src \
	text cleancode,codesize,design,unusedcode --exclude 'Migrations','Kernel.php','Entity' --ignore-violations-on-exit

build: ## Build docker image
	$(DOCKER_C) build

logs: ## Watch docker log files
	$(DOCKER_C) logs -f

composer.require: ## Install composer package
	$(DOCK_X_APP) composer require $(pac)

composer.require.dev: ## Install composer package
	$(DOCK_X_APP) composer require --dev $(pac)

composer.install: ## Install all packages composer
	$(DOCK_X_APP) composer install

composer.update: ## Run composer update inside container
	$(DOCK_X_APP) composer update

composer.normalize: ## Run composer.json formater
	$(DOCK_X_APP) composer normalize

composer.dumpautoload: # genarates auto-load
	$(DOCK_X_APP) composer dump-autoload

app/vendor:
	$(DOCK_X_APP) composer install

createdb: ## Create db
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console doctrine:database:create

db.entity: ## Create Entity
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console make:entity $(ent)

db.import: #Create Entities from database
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity

db.migration: ## Executes Migration
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console make:migration

db.migrate: ## Executes Migrate
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console doctrine:migrations:migrate

controller: ## Create a Controller
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console generate:controller --no-interaction --controller=$(name)

router: ## List all routes
	$(DOCKER_C) exec -T $(APP_NAME) php bin/console debug:router $(name)

docker-cleanup:
	docker stop $$(docker ps -a -q)
	docker rm $$(docker ps -a -q)
	docker volume prune
	docker system prune -a

help:
	@grep -E '^[a-zA-Z._-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
