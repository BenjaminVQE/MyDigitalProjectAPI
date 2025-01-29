APP_ENV ?= dev
CONTAINER_NAME ?= php
DOCKER_COMPOSE = docker compose --project-name tissup-api --project-directory .
PROJECT_NAME = tissup-api

install: dc-up

dc-up: .env
	PROJECT_NAME=$(PROJECT_NAME) $(DOCKER_COMPOSE) up --pull always -d --wait $(NO_DEPS)

sf-install:
	docker container exec -it $(PROJECT_NAME)-$(CONTAINER_NAME)-1 composer install