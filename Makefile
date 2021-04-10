SHELL := /bin/bash

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$|(^#--)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m %-43s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m #-- /[33m/'

.PHONY: help
.DEFAULT_GOAL := help

#-- start symfony & minio
install: ## install the package for library & demo
	cd package && composer install
	cd s3-symfony-demo && composer install

start: ## start the minIO docker and symfony web server
	docker-compose up -d
	cd s3-symfony-demo && symfony serve


#-- stop symfony & minio
stop: ## stop the minIO docker and symfony web server
	docker-compose stop
	cd s3-symfony-demo && symfony server:stop


#-- Start the tests
test: ## start the unit tests
	docker-compose up -d
	cd package && composer run test


