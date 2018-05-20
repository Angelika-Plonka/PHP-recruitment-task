.PHONY: config
config:
ifeq ("$(wildcard .env)", "")
	cp .env.dist .env
endif
ifeq ("$(wildcard docker-compose.yml)", "")
	cp docker-compose.yml.dist docker-compose.yml
endif

.PHONY: config-env
config-env:
ifeq ("$(wildcard .env)", "")
	cp .env.dist .env
endif

.PHONY: install
install: config
	docker-compose up -d
	sleep 5
	docker-compose run --rm php composer install

.PHONY: start
start:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down -v