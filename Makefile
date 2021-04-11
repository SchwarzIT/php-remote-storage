SHELL := /bin/bash

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$|(^#--)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m %-43s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m #-- /[33m/'

.PHONY: help
.DEFAULT_GOAL := help

#-- Manage storage package and symfony demp app
install: ## install the package for library & demo
	cd s3-symfony-demo && composer install

start: ## start the minIO docker and symfony web server
	docker-compose up -d
	cd s3-symfony-demo && symfony serve

stop: ## stop the minIO docker and symfony web server
	docker-compose stop
	cd s3-symfony-demo && symfony server:stop

test: ## start the unit tests
	docker-compose up -d
	cd package && composer run test


