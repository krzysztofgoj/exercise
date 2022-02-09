start:
	docker-compose up

start-detached:
	docker-compose up -d

stop:
	docker-compose stop

enter:
	docker-compose exec app bash

composer-install:
	docker-compose exec -T app composer install

create-database:
	docker-compose exec -T app mkdir db
	docker-compose exec -T app bin/console doctrine:database:create
	docker-compose exec -T app chmod -R 777 db/

create-database-test:
	docker-compose exec -T app bin/console --env=test doctrine:database:create
	docker-compose exec -T app chmod -R 777 db/

database-migrate:
	docker-compose exec app bin/console doctrine:migrations:migrate

database-migrate-test:
	docker-compose exec app bin/console --env=test doctrine:migrations:migrate

test:
	docker-compose exec -T app bin/phpunit