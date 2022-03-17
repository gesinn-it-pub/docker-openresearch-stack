.PHONY: build
build:
	docker build \
	  --secret id=GH_API_TOKEN,src=${HOME}/GH_API_TOKEN \
	  --tag ghcr.io/gesinn-it/openresearch-stack:1.0.0-alpha1 \
	  ./context

.PHONY: sqlite-up
sqlite-up:
	docker-compose up -d

.PHONY: mysql-up
mysql-up:
	MYSQL_HOST=mysql docker-compose --profile mysql up -d

.PHONY: show-status
show-status:
	docker-compose ps

.PHONY: show-logs
show-logs:
	docker-compose logs -f || exit 0

.PHONY: stop
stop:
	docker-compose stop

.PHONY: down
down:
	docker-compose down --volumes --remove-orphans

.PHONY: backstop-test
backstop-test:
	docker-compose run --rm backstop test

.PHONY: clean
clean: down
	rm -rf data
