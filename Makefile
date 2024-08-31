export COMPOSE=docker compose
export EXEC=$(COMPOSE) exec symfony

ssh:
	$(EXEC) bash

# Cache
cc:
	$(EXEC) php bin/console c:cl --no-warmup
	$(EXEC) php bin/console c:warmup

fixtures:
	$(EXEC) bin/console d:f:l -n && \
	echo "Fixtures has been loaded. End of make.";

dsu-f:
	$(EXEC) bin/console doctrine:schema:update --force && \
	echo "Database has been updated. End of make.";

dsu-d:
	$(EXEC) bin/console doctrine:schema:update --dump-sql 2>/dev/null && \
	read -p "Voulez-vous forcer l'update? (y/N) " response && \
	if [ "$$response" = "y" ] || [ "$$response" = "Y" ] || [ "$$response" = "o" ] || [ "$$response" = "O" ]; then \
		$(EXEC) bin/console doctrine:schema:update --force 2>/dev/null; \
		echo "Database has been updated. End of make."; \
	else \
		echo "Nothing has been updated. End of make."; \
	fi

dcu:
	$(COMPOSE) stop  && \
	$(COMPOSE) down && \
	$(COMPOSE) up --build --force-recreate -d

install:
	sudo chmod -R 777 * && \
	$(COMPOSE) down && \
	make dcu && \
	$(EXEC) composer install && \
	$(EXEC) bin/console d:d:c --if-not-exists && \
	make dsu-f && \
	$(EXEC) bin/console d:f:l -n && \
	$(COMPOSE) exec node npm run dev 

