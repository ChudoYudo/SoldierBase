.PHONY: test


COMPOSE_FILE='docker-compose.yml'

COMPOSE=docker-compose -f $(COMPOSE_FILE)

stop:
	@$(COMPOSE) stop

rm:
	@$(COMPOSE) rm

start: stop
	@$(COMPOSE) up -d --build $(c)

exec-node:
	@$(COMPOSE) exec node /bin/sh

exec-php:
	@$(COMPOSE) exec php /bin/bash

clean:
	@$(COMPOSE) down

docker-logs:
	@$(COMPOSE) logs -f $(c)

sync-logs:
	@$(SYNC) logs -c $(SYNC_FILE) -f $(c)

# cert:
# 	@docker run --rm -v ./docker/etc/ssl:/certificates -e "SERVER=$(NGINX_HOST)" jacoelho/generate-certificate

build:
	/bin/bash build.sh
