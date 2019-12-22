composer:
	docker-compose -f docker-compose.yml exec -T php composer install --prefer-dist -o
up:
	docker-compose -f docker-compose.yml up --build --force-recreate -d
	make composer
	make migrate
down:
	docker-compose -f docker-compose.yml down -v
build:
	docker-compose -f docker-compose.yml build --no-cache
clean:
	docker-compose -f docker-compose.yml rm -fsv
migrate:
	docker-compose -f docker-compose.yml exec -T php vendor/bin/doctrine-migrations migrate
fixtures:
	docker-compose -f docker-compose.yml exec -T php bin/fixtures