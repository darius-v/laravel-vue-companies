.PHONY: start stop restart init

include .env
export $(shell sed 's/=.*//' .env)

start:
	docker-compose up -d

stop:
	docker-compose stop

restart:
	docker-compose stop
	docker-compose up -d

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	docker-compose exec php /app/scripts/wait-for-it.sh mysql:$(MYSQL_PORT) -- echo "mysql is up"
	docker-compose exec -T mysql mysql -u"$(DB_USERNAME)" -p"$(DB_PASSWORD)" -e "create database $(DB_DATABASE)"
	docker-compose exec php php artisan migrate

