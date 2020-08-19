SHELL := /bin/bash

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$|(^#--)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m %-43s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m #-- /[33m/'

.PHONY: help
.DEFAULT_GOAL := help

#-- start symfony & minio
start: ## clean up all docker resource
	docker-compose up -d
	cd s3-symfony-demo && symfony serve


#-- stop symfony & minio
stop: ## clean up all docker resource
	docker-compose stop
	cd s3-symfony-demo && symfony server:stop


