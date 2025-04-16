APP_ENV ?= dev
CONTAINER_NAME ?= php
DOCKER_COMPOSE = docker compose --project-name tissup-api --project-directory .
PROJECT_NAME = tissup-api
PACKAGE ?= default-package
PARAMETER ?=
ENTITY ?= 

install: ## Install Api
install: dc-up 

exec: ## Execute a command in the container
	docker exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 bash

dc-up: .env
	PROJECT_NAME=$(PROJECT_NAME) $(DOCKER_COMPOSE) up --pull always -d --wait $(NO_DEPS)

sf-install: ## Install composer packages
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 composer install

package-install:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 composer require $(PACKAGE) $(PARAMETER); \

entity:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:entity $(ENTITY) 

user: 
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:user

migration: ## Create migrations
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:migration

migrate: ## Migrate migrations to data base
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console doctrine:migrations:migrate

help: ## Display help
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.DEFAULT_GOAL := help