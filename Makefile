create: up composer migrate fixtures
up:
	docker-compose -f docker-compose.yml up --build --force-recreate -d
down:
	docker-compose -f docker-compose.yml down -v
build:
	docker-compose -f docker-compose.yml build --no-cache
migrate:
	docker-compose -f docker-compose.yml exec -T php sh/wait-for-it.sh db:3306 -- vendor/bin/doctrine-migrations migrate
fixtures:
	docker-compose -f docker-compose.yml exec -T php bin/fixtures
composer:
	docker-compose -f docker-compose.yml exec -T php composer install --prefer-dist -o