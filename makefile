APP_ENV ?= dev
CONTAINER_NAME ?= php
DOCKER_COMPOSE = docker compose --project-name tissup-api --project-directory .
PROJECT_NAME = tissup-api
PACKAGE ?= default-package
DEV ?=

install: dc-up

exec:
	docker container exec -it

dc-up: .env
	PROJECT_NAME=$(PROJECT_NAME) $(DOCKER_COMPOSE) up --pull always -d --wait $(NO_DEPS)

sf-install:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 composer install

package-install:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 composer require $(PACKAGE) $(DEV); \

entity:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:entity 

user:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:user

migration:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console make:migration

migrate:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 php bin/console doctrine:migrations:migrate