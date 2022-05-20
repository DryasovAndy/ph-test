up:
	docker-compose up -d

down:
	docker-compose down

re:
	make down
	make up

composer_install:
	docker-compose exec --user=application php composer install

generate-jwt-keypair:
	docker-compose exec php php bin/console lexik:jwt:generate-keypair --skip-if-exists

bash:
	docker-compose exec --user=application php bash

cc:
	rm -rf app/var/cache/
	docker-compose exec -T --user=application php bin/console ca:cl

routes:
	docker-compose exec php bin/console debug:router

validate-schema:
	docker-compose exec --user=application php bin/console doctrine:schema:validate

drop-db:
	docker-compose exec --user=application php bin/console doctrine:database:drop --force

create-db:
	docker-compose exec --user=application php bin/console doctrine:database:create --if-not-exists

update-schema:
	docker-compose exec -T --user=application php bin/console doctrine:schema:update --force

import-db:
	cat locations_countries.sql | docker-compose exec -T database /usr/bin/mysql -u user --password=password database

migration:
	docker-compose exec -T --user=application php bin/console doctrine:migrations:migrate --no-interaction

permissions:
	sudo chown 1000:www-data -R ./
	sudo chown 1000:1000 -R docker/mariadb/
	sudo chmod 775 -R ./
	sudo chmod 777 -R docker/mariadb/

install:
	make re
	make composer_install
	make generate-jwt-keypair
	make drop-db
	make create-db
	make import-db
	make migration
	make permissions

prepare_test_env:
	docker-compose exec php bin/console cache:clear --env=test
	docker-compose exec php bin/console doctrine:database:drop --env=test --no-debug --force --if-exists
	docker-compose exec php bin/console doctrine:database:create --env=test --no-debug --if-not-exists
	docker-compose exec php bin/console doctrine:schema:create --env=test --no-debug --no-interaction
	docker-compose exec php bin/console lexik:jwt:generate-keypair --env=test --no-debug --overwrite --no-interaction
	docker-compose exec php bin/console doctrine:fixtures:load --env=test --no-debug

test:
	docker-compose exec php bin/phpunit
